<?php

/**
 * @link https://github.com/koperdog/yii2-treeview
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/koperdog/yii2-treeview/blob/master/LICENSE
 */

namespace t2cms\base\widgets\treeview;

use Closure;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\i18n\Formatter;
use yii\widgets\BaseListView;

/**
 * The TreeView widget is used to display data in a tree grid.
 *
 * It provides features like [[sorter|sorting]], [[pager|paging]] and also [[filterModel|filtering]] the data.
 *
 * A basic usage looks like the following:
 *
 * ```php
 * <?= TreeView::widget([
 *     'dataProvider'  => $dataProvider,
 *     //'depthPrefix' => ' ⚫ ',
 *     //'depthRoot'   => 1,
 *     //'collaplse'   => true,
 *     'columns' => [
 *         'id',
 *         'name',
 *         'created_at:datetime',
 *         // ...
 *     ],
 * ]) ?>
 * ```
 *
 * The columns of the grid table are configured in terms of [[Column]] classes,
 * which are configured via [[columns]].
 * 
 * Based on [[yii\grid\GridView]]
 * 
 * @author Koperdog <koperdog.dev@gmail.com>
 * @version 1.0.1
 */

class TreeView extends BaseListView
{
    const FILTER_POS_HEADER = 'header';
    const FILTER_POS_FOOTER = 'footer';
    const FILTER_POS_BODY = 'body';
    
    /*
     * @var string the default prefix for each child of tree
     */
    public $depthPrefix = ' — ';
    /**
     * @var int offset from the root of the tree, used to set depth prefixes.
     */
    public $depthRoot = 0;
    
    /**
     * @var boolean flag of collapse of nested levels
     * if true, subcategories wrapper will be have additional class 'closed' and TreeView container - 'tree-collapse'
     */
    public $collapse = false;

    /**
     * @var string the default data column class if the class name is not explicitly specified when configuring a data column.
     * Defaults to 't2cms\treeview\base\DataColumn'.
     */
    public $dataColumnClass;
    /**
     * @var string the caption of the grid table
     * @see captionOptions
     */
    public $caption;
    /**
     * @var array the HTML attributes for the caption element.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     * @see caption
     */
    public $captionOptions = [];
    /**
     * @var array the HTML attributes for the grid table element.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $tableOptions = ['class' => 'table table-striped table-bordered'];
    /**
     * @var array the HTML attributes for the container tag of the grid view.
     * The "tag" element specifies the tag name of the container element and defaults to "div".
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = ['class' => 'tree-view'];
    /**
     * @var array the HTML attributes for the table header row.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $headerRowOptions = [];
    /**
     * @var array the HTML attributes for the table footer row.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $footerRowOptions = [];
    /**
     * @var array|Closure the HTML attributes for the table body rows. This can be either an array
     * specifying the common HTML attributes for all body rows, or an anonymous function that
     * returns an array of the HTML attributes. The anonymous function will be called once for every
     * data model returned by [[dataProvider]]. It should have the following signature:
     *
     * ```php
     * function ($model, $key, $index, $grid)
     * ```
     *
     * - `$model`: the current data model being rendered
     * - `$key`: the key value associated with the current data model
     * - `$index`: the zero-based index of the data model in the model array returned by [[dataProvider]]
     * - `$grid`: the TreeView object
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $rowOptions = [];
    /**
     * @var Closure an anonymous function that is called once BEFORE rendering each data model.
     * It should have the similar signature as [[rowOptions]]. The return result of the function
     * will be rendered directly.
     */
    public $beforeRow;
    /**
     * @var Closure an anonymous function that is called once AFTER rendering each data model.
     * It should have the similar signature as [[rowOptions]]. The return result of the function
     * will be rendered directly.
     */
    public $afterRow;
    /**
     * @var bool whether to show the header section of the grid table.
     */
    public $showHeader = true;
    /**
     * @var bool whether to show the footer section of the grid table.
     */
    public $showFooter = false;
    /**
     * @var bool whether to place footer after body in DOM if $showFooter is true
     * @since 2.0.14
     */
    public $placeFooterAfterBody = false;
    /**
     * @var bool whether to show the grid view if [[dataProvider]] returns no data.
     */
    public $showOnEmpty = true;
    /**
     * @var array|Formatter the formatter used to format model attribute values into displayable texts.
     * This can be either an instance of [[Formatter]] or an configuration array for creating the [[Formatter]]
     * instance. If this property is not set, the "formatter" application component will be used.
     */
    public $formatter;
    /**
     * @var array grid column configuration. Each array element represents the configuration
     * for one particular grid column. For example,
     *
     * ```php
     * [
     *     ['class' => SerialColumn::className()],
     *     [
     *         'class' => DataColumn::className(), // this line is optional
     *         'attribute' => 'name',
     *         'format' => 'text',
     *         'label' => 'Name',
     *     ],
     *     ['class' => CheckboxColumn::className()],
     * ]
     * ```
     *
     * If a column is of class [[DataColumn]], the "class" element can be omitted.
     *
     * As a shortcut format, a string may be used to specify the configuration of a data column
     * which only contains [[DataColumn::attribute|attribute]], [[DataColumn::format|format]],
     * and/or [[DataColumn::label|label]] options: `"attribute:format:label"`.
     * For example, the above "name" column can also be specified as: `"name:text:Name"`.
     * Both "format" and "label" are optional. They will take default values if absent.
     *
     * Using the shortcut format the configuration for columns in simple cases would look like this:
     *
     * ```php
     * [
     *     'id',
     *     'amount:currency:Total Amount',
     *     'created_at:datetime',
     * ]
     * ```
     *
     * When using a [[dataProvider]] with active records, you can also display values from related records,
     * e.g. the `name` attribute of the `author` relation:
     *
     * ```php
     * // shortcut syntax
     * 'author.name',
     * // full syntax
     * [
     *     'attribute' => 'author.name',
     *     // ...
     * ]
     * ```
     */
    public $columns = [];
    /**
     * @var string the HTML display when the content of a cell is empty.
     * This property is used to render cells that have no defined content,
     * e.g. empty footer or filter cells.
     *
     * Note that this is not used by the [[DataColumn]] if a data item is `null`. In that case
     * the [[\yii\i18n\Formatter::nullDisplay|nullDisplay]] property of the [[formatter]] will
     * be used to indicate an empty data value.
     */
    public $emptyCell = '&nbsp;';
    /**
     * @var \yii\base\Model the model that keeps the user-entered filter data. When this property is set,
     * the grid view will enable column-based filtering. Each data column by default will display a text field
     * at the top that users can fill in to filter the data.
     *
     * Note that in order to show an input field for filtering, a column must have its [[DataColumn::attribute]]
     * property set and the attribute should be active in the current scenario of $filterModel or have
     * [[DataColumn::filter]] set as the HTML code for the input field.
     *
     * When this property is not set (null) the filtering feature is disabled.
     */
    public $filterModel;
    /**
     * @var string|array the URL for returning the filtering result. [[Url::to()]] will be called to
     * normalize the URL. If not set, the current controller action will be used.
     * When the user makes change to any filter input, the current filtering inputs will be appended
     * as GET parameters to this URL.
     */
    public $filterUrl;
    /**
     * @var string additional jQuery selector for selecting filter input fields
     */
    public $filterSelector;
    /**
     * @var string whether the filters should be displayed in the grid view. Valid values include:
     *
     * - [[FILTER_POS_HEADER]]: the filters will be displayed on top of each column's header cell.
     * - [[FILTER_POS_BODY]]: the filters will be displayed right below each column's header cell.
     * - [[FILTER_POS_FOOTER]]: the filters will be displayed below each column's footer cell.
     */
    public $filterPosition = self::FILTER_POS_BODY;
    /**
     * @var array the HTML attributes for the filter row element.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $filterRowOptions = ['class' => 'filters'];
    /**
     * @var array the options for rendering the filter error summary.
     * Please refer to [[Html::errorSummary()]] for more details about how to specify the options.
     * @see renderErrors()
     */
    public $filterErrorSummaryOptions = ['class' => 'error-summary'];
    /**
     * @var array the options for rendering every filter error message.
     * This is mainly used by [[Html::error()]] when rendering an error message next to every filter input field.
     */
    public $filterErrorOptions = ['class' => 'help-block'];
    /**
     * @var bool whatever to apply filters on losing focus. Leaves an ability to manage filters via yiiGridView JS
     * @since 2.0.16
     */
    public $filterOnFocusOut = true;
    /**
     * @var string the layout that determines how different sections of the grid view should be organized.
     * The following tokens will be replaced with the corresponding section contents:
     *
     * - `{summary}`: the summary section. See [[renderSummary()]].
     * - `{errors}`: the filter model error summary. See [[renderErrors()]].
     * - `{items}`: the list items. See [[renderItems()]].
     * - `{sorter}`: the sorter. See [[renderSorter()]].
     * - `{pager}`: the pager. See [[renderPager()]].
     */
    public $layout = "{summary}\n{items}\n{pager}";
    
    
    private $treeHelper;
    


    /**
     * Initializes the grid view.
     * This method will initialize required property values and instantiate [[columns]] objects.
     */
    public function init()
    {
        parent::init();
        if ($this->formatter === null) {
            $this->formatter = Yii::$app->getFormatter();
        } elseif (is_array($this->formatter)) {
            $this->formatter = Yii::createObject($this->formatter);
        }
        if (!$this->formatter instanceof Formatter) {
            throw new InvalidConfigException('The "formatter" property must be either a Format object or a configuration array.');
        }
        if (!isset($this->filterRowOptions['id'])) {
            $this->filterRowOptions['id'] = $this->options['id'] . '-filters';
        }
        
        $this->treeHelper = new base\TreeHelper($this);

        $this->initColumns();
    }

    /**
     * Runs the widget.
     */
    public function run()
    {
        $view = $this->getView();
        base\TreeViewAsset::register($view);
        $id = $this->options['id'];
        $options = Json::htmlEncode(array_merge($this->getClientOptions(), ['filterOnFocusOut' => $this->filterOnFocusOut]));
        $view->registerJs("jQuery('#$id').yiiGridView($options);");
        parent::run();
    }

    /**
     * Renders validator errors of filter model.
     * @return string the rendering result.
     */
    public function renderErrors()
    {
        if ($this->filterModel instanceof Model && $this->filterModel->hasErrors()) {
            return Html::errorSummary($this->filterModel, $this->filterErrorSummaryOptions);
        }

        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function renderSection($name)
    {
        switch ($name) {
            case '{errors}':
                return $this->renderErrors();
            default:
                return parent::renderSection($name);
        }
    }

    /**
     * Returns the options for the grid view JS widget.
     * @return array the options
     */
    protected function getClientOptions()
    {
        $filterUrl = isset($this->filterUrl) ? $this->filterUrl : Yii::$app->request->url;
        $id = $this->filterRowOptions['id'];
        $filterSelector = "#$id input, #$id select";
        if (isset($this->filterSelector)) {
            $filterSelector .= ', ' . $this->filterSelector;
        }

        return [
            'filterUrl' => Url::to($filterUrl),
            'filterSelector' => $filterSelector,
        ];
    }
    
    protected function renderItem($model, $key, $index)
    {
        $content = $this->renderTableRow($model, $key, $index);
        
        if($model->children !== null){
            $content .= Html::beginTag('div', ['class' => 'categories']);
            
            foreach($model->children as $value){
                $content .= Html::tag('div', $this->renderItem($value, $key, $index), ['data-id' => $value->id]);
            }
            
            $content .= Html::endTag('div');
        }
        return $content;
    }

    /**
     * Renders the data models for the grid view.
     * @return string the HTML code of table
     */
    public function renderItems()
    {
        $caption = $this->renderCaption();
        $tableHeader = $this->showHeader ? $this->renderTableHeader() : false;
        $tableBody = $this->renderTableBody();

        $tableFooter = false;
        $tableFooterAfterBody = false;
        
        if ($this->showFooter) {
            if ($this->placeFooterAfterBody) {
                $tableFooterAfterBody = $this->renderTableFooter();
            } else {
                $tableFooter = $this->renderTableFooter();
            }
        }

        $content = array_filter([
            $caption,
            $tableHeader,
            $tableFooter,
            $tableBody,
            $tableFooterAfterBody,
        ]);

        return Html::tag('div', implode("\n", $content), $this->tableOptions);
    }

    /**
     * Renders the caption element.
     * @return bool|string the rendered caption element or `false` if no caption element should be rendered.
     */
    public function renderCaption()
    {
        if (!empty($this->caption)) {
            return Html::tag('div', $this->caption, $this->captionOptions);
        }

        return false;
    }

    /**
     * Renders the table header.
     * @return string the rendering result.
     */
    public function renderTableHeader()
    {
        $cells = [];
        foreach ($this->columns as $column) {
            /* @var $column Column */
            $cells[] = $column->renderHeaderCell();
        }
        $content = Html::tag('div', implode('', $cells), $this->headerRowOptions);
        if ($this->filterPosition === self::FILTER_POS_HEADER) {
            $content = $this->renderFilters() . $content;
        } elseif ($this->filterPosition === self::FILTER_POS_BODY) {
            $content .= $this->renderFilters();
        }

        return "<div class=\"thead\">\n" . $content . "\n</div>";
    }

    /**
     * Renders the table footer.
     * @return string the rendering result.
     */
    public function renderTableFooter()
    {
        $cells = [];
        foreach ($this->columns as $column) {
            /* @var $column Column */
            $cells[] = $column->renderFooterCell();
        }
        $content = Html::tag('tr', implode('', $cells), $this->footerRowOptions);
        if ($this->filterPosition === self::FILTER_POS_FOOTER) {
            $content .= $this->renderFilters();
        }

        return "<div class=\"tfoot\">\n" . $content . "\n</div>";
    }

    /**
     * Renders the filter.
     * @return string the rendering result.
     */
    public function renderFilters()
    {
        if ($this->filterModel !== null) {
            $cells = [];
            foreach ($this->columns as $column) {
                /* @var $column Column */
                $cells[] = $column->renderFilterCell();
            }

            return Html::tag('div', implode('', $cells), $this->filterRowOptions);
        }

        return '';
    }

    /**
     * Renders the table body.
     * @return string the rendering result.
     */
    public function renderTableBody()
    {
        $data   = $this->treeHelper->prepareModels($this->dataProvider->getModels());
        $models = array_values($data);
        
        $keys = $this->dataProvider->getKeys();
        $rows = [];
        foreach ($models as $index => $model) {
            $key = $keys[$index];
            if ($this->beforeRow !== null) {
                $row = call_user_func($this->beforeRow, $model, $key, $index, $this);
                if (!empty($row)) {
                    $rows[] = $row;
                }
            }
            
            $rows[] = '<div data-id="'.$model->id.'">'.$this->renderItem($model, $key, $index).'</div>';

            if ($this->afterRow !== null) {
                $row = call_user_func($this->afterRow, $model, $key, $index, $this);
                if (!empty($row)) {
                    $rows[] = $row;
                }
            }
        }

        if (empty($rows) && $this->emptyText !== false) {
            return "<div class=\"tbody\">\n<div class=\"tr empty\">" . $this->renderEmpty() . "</div>\n</div>";
        }

        return "<div class=\"tbody\">\n"
            . "<div class=\"categories_wr".($this->collapse? ' tree-collapse': '')."\">\n" 
            . implode("\n", $rows) 
            . "\n</div>"
            . "\n</div>";
    }

    /**
     * Renders a table row with the given data model and key.
     * @param mixed $model the data model to be rendered
     * @param mixed $key the key associated with the data model
     * @param int $index the zero-based index of the data model among the model array returned by [[dataProvider]].
     * @return string the rendering result
     */
    public function renderTableRow($model, $key, $index)
    {
        $cells = [];
        /* @var $column Column */
        foreach ($this->columns as $column) {
            $cells[] = $column->renderDataCell($model, $key, $index);
        }
        if ($this->rowOptions instanceof Closure) {
            $options = call_user_func($this->rowOptions, $model, $key, $index, $this);
        } else {
            $options = $this->rowOptions;
        }
        
        $options['data-id'] = $model->id;
        $class = ($this->collapse && $model->children !== null)? 'category closed' : 'category';
        
        $options['class'] = $options['class']? $options['class'].' '.$class : $class;

        return Html::tag('div', implode('', $cells), $options);
    }

    /**
     * Creates column objects and initializes them.
     */
    protected function initColumns()
    {
        if (empty($this->columns)) {
            $this->guessColumns();
        }
        foreach ($this->columns as $i => $column) {
            if (is_string($column)) {
                $column = $this->createDataColumn($column);
            } else {
                $column = Yii::createObject(array_merge([
                    'class' => $this->dataColumnClass ?: base\DataColumn::className(),
                    'grid' => $this,
                ], $column));
            }
            if (!$column->visible) {
                unset($this->columns[$i]);
                continue;
            }
            $this->columns[$i] = $column;
        }
    }

    /**
     * Creates a [[DataColumn]] object based on a string in the format of "attribute:format:label".
     * @param string $text the column specification string
     * @return DataColumn the column instance
     * @throws InvalidConfigException if the column specification is invalid
     */
    protected function createDataColumn($text)
    {
        if (!preg_match('/^([^:]+)(:(\w*))?(:(.*))?$/', $text, $matches)) {
            throw new InvalidConfigException('The column must be specified in the format of "attribute", "attribute:format" or "attribute:format:label"');
        }

        return Yii::createObject([
            'class' => $this->dataColumnClass ?: base\DataColumn::className(),
            'grid' => $this,
            'attribute' => $matches[1],
            'format' => isset($matches[3]) ? $matches[3] : 'text',
            'label' => isset($matches[5]) ? $matches[5] : null,
        ]);
    }

    /**
     * This function tries to guess the columns to show from the given data
     * if [[columns]] are not explicitly specified.
     */
    protected function guessColumns()
    {
        $models = $this->dataProvider->getModels();
        $model = reset($models);
        if (is_array($model) || is_object($model)) {
            foreach ($model as $name => $value) {
                if ($value === null || is_scalar($value) || is_callable([$value, '__toString'])) {
                    $this->columns[] = (string) $name;
                }
            }
        }
    }
    
    private function asTree(array $models): array
    {
        $tree = [];

        foreach ($models as $n) {
            $node = &$tree;

            for ($depth = $models[0]->depth; $n->depth > $depth; $depth++) {
                $node = &$node[count($node) - 1]->children;
            }
            $n->children = null;
            $node[] = $n;
        }
        return $tree;
    }
}