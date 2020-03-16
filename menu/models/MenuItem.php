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
 *
 * @property Menu $tree0
 */
class MenuItem extends \yii\db\ActiveRecord
{
    const TYPE_ROOT          = -1;
    
    const TYPE_URI           = 0;
    const TYPE_BLOG_CATEGORY = 1;
    const TYPE_BLOG_PAGE     = 2;
    
    const OFFSET_ROOT = 1;
    
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
            [['type', 'tree', 'lft', 'rgt', 'depth', 'parent_id', 'active'], 'integer'],
            [['data'], 'string', 'max' => 255],
            [['active'], 'default', 'value' => true],
            [['tree'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['tree' => 'id']],
        ];
    }
    
    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                // 'treeAttribute' => 'tree',
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
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
}
