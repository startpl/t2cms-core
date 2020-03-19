<?php

namespace t2cms\menu\models;

use Yii;

/**
 * This is the model class for table "{{%menu_item_content}}".
 *
 * @property int $id
 * @property int $menu_item_id
 * @property string $name
 * @property int $domain_id
 * @property int $language_id
 */
class MenuItemContent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%menu_item_content}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'menu_item_id', 'name', 'domain_id', 'language_id'], 'required'],
            [['id', 'menu_item_id', 'domain_id', 'language_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('menu', 'ID'),
            'menu_item_id' => Yii::t('menu', 'Menu Item ID'),
            'name' => Yii::t('menu', 'Name'),
            'domain_id' => Yii::t('menu', 'Domain ID'),
            'language_id' => Yii::t('menu', 'Language ID'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return MenuItemContentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MenuItemContentQuery(get_called_class());
    }
}
