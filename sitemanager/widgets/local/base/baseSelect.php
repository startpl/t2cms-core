<?php

/**
 * @link https://github.com/t2cms/sitemanager
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/t2cms-core/sitemanager/blob/master/LICENSE
 */

namespace t2cms\sitemanager\widgets\local\base;

use t2cms\sitemanager\interfaces\ReadReposotory;
use yii\helpers\{
    Html,
    ArrayHelper,
    Url
};

/**
 * Base class for generating select tag
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class baseSelect extends \yii\base\BaseObject{
    /**
     * @var string name of select tag 
     */
    protected $selectName = "select";
    
    /**
     * @var \yii\base\Widget owner this select tag
     */
    public $select;
    
    /**
     * @var ReadReposotory for getting value
     */
    protected $repository;
    
    /**
     * @var string session admin name for controll content
     */
    protected $paramName = "_select";
    
    public function __construct(ReadReposotory $repository, $config = [])
    {
        parent::__construct($config);
        
        $this->repository = $repository;
    }
    
    /**
     * Render list section
     * 
     * @return string
     */
    public function render(): string
    {
        $options = ArrayHelper::merge(
                $this->select->optionsList, 
                ['id' => 'change_'.$this->selectName, 'name' => $this->selectName]
                );
        
        $content  = Html::beginTag('select', $options);
        $content .= $this->renderItems();
        $content .= Html::endTag('select');
        
        return $content;
    }
    
    /**
     * Render items
     * 
     * @return string
     */
    protected function renderItems(): string
    {
        $items    = $this->repository->getAll();
        $content .= $this->defaultItemRender(); 
        
        foreach($items as $item){
            $selected = (bool)(
                \Yii::$app->request->get($this->paramName) == $item['id'] 
                || \Yii::$app->session->get('_'.$this->paramName) == $item['id']
            );
            
            $content .= Html::tag('option', $item['name'], ['selected' => $selected, 'value' => $this->buildUrl($item['id']), 'data' => [
                $this->paramName => $item['id']
            ]]);
        }
        
        return $content;
    }
    
    /**
     * Render default item
     * 
     * @return string
     */
    protected function defaultItemRender(): string
    {
        $selected = (\Yii::$app->request->get($this->paramName) == null);
                
        return Html::tag('option', \Yii::t('app', 'General'), ['selected' => $selected,'value' => $this->buildUrl(-1)]);
    }
    
    private function buildUrl($id): string
    {
        $url = array_merge(\Yii::$app->request->queryParams, [$this->paramName => $id]);
        return Url::to($url);
    }
    
}
