<?php

namespace t2cms\menu\models;

use Yii;
use creocoder\nestedsets\NestedSetsBehavior;

/**
 * This is the model class for table "{{%menu_items}}".
 *
 * @property int $id
 * @property int $type
 * @property string $data
 * @property int $tree
 * @property int $lft
 * @property int $rgt
 * @property int $depth
 * @property int|null $parent_id
 * @property boolean $status
 * 
 * @property Menu $menu
 */
class MenuItem extends \yii\db\ActiveRecord
{
    const TYPE_ROOT          = -1;
    
    const TYPE_URI           = 0;
    const TYPE_BLOG_CATEGORY = 1;
    const TYPE_BLOG_PAGE     = 2;
    
    const OFFSET_ROOT = 1;
    
    const TARGET_CURRENT = 0;
    const TARGET_NEW_WIN = 1;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%menu_item}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type', 'tree', 'lft', 'rgt', 'depth', 'parent_id'], 'integer'],
            [['status', 'target'], 'boolean'],
            [['data'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => true],
            [['target'], 'default', 'value' => self::TARGET_CURRENT],
            
            [['tree'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['tree' => 'id']],
        ];
    }
    
    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                 'treeAttribute' => 'tree',
            ],
        ];
    }
    
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new MenuItemQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('menu', 'ID'),
            'type' => Yii::t('menu', 'Type'),
            'data' => Yii::t('menu', 'Data'),
            'tree' => Yii::t('menu', 'Tree'),
            'lft' => Yii::t('menu', 'Lft'),
            'rgt' => Yii::t('menu', 'Rgt'),
            'depth' => Yii::t('menu', 'Depth'),
            'parent_id' => Yii::t('menu', 'Parent ID'),
            'status'    => Yii::t('menu', 'Status')
        ];
    }

    /**
     * Gets query for [[Tree]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'tree']);
    }
    
    public static function getItemTypes(): array
    {
        return [
            self::TYPE_URI => \Yii::t('menu', 'URI'),
            self::TYPE_BLOG_CATEGORY => \Yii::t('menu', 'Category'),
            self::TYPE_BLOG_PAGE => \Yii::t('menu', 'Page'),
        ];
    }
    
    /**
     * Get a full tree as a list, except the node and its children
     * @param  integer $node_id node's ID
     * @return array array of node
     */
    public static function getTree(int $tree, $exclude, $domain_id = null, $language_id = null)
    {   
        // don't include children and the node
        $children = [];

        if(!empty($exclude)){
            $children = array_merge(
                self::findOne($exclude)->children()->column(),
                [$exclude]
            );
        }
        
        $rows = MenuItem::find()
            ->joinWith(['itemContent' => function($query) use ($domain_id, $language_id){
                $in = \yii\helpers\ArrayHelper::getColumn(MenuItemContentQuery::getAllId($domain_id, $language_id)->asArray()->all(), 'id');
                $query->andWhere(['IN','menu_item_content.id', $in]);
            }])
            ->select(['menu_item.id', 'tree', 'depth', 'lft', 'menu_item_content.name'])
            ->andWhere(['NOT IN', 'menu_item.id', $tree])
            ->andWhere(['NOT IN', 'menu_item.id', $children])
            ->orderBy('tree, lft')
            ->all();
        
        $return = [];
        
        foreach ($rows as $row)
            $return[$row->id] = str_repeat(' - ', $row->depth - self::OFFSET_ROOT) . ' ' . $row->itemContent->name;
        
        return $return;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemContent()
    {
        return $this->hasOne(MenuItemContent::className(), ['menu_item_id' => 'id']);
    }
}
