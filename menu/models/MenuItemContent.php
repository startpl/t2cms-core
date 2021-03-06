<?php

namespace t2cms\menu\models;

use Yii;

/**
 * This is the model class for table "{{%menu_item_content}}".
 *
 * @property int $id
 * @property int $src_id
 * @property string $name
 * @property int $domain_id
 * @property int $language_id
 */
class MenuItemContent extends \yii\db\ActiveRecord
{
    use \t2cms\base\traits\ContentValueTrait;
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
            [['src_id', 'name'], 'required'],
            [['id', 'src_id', 'domain_id', 'language_id'], 'integer'],
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
            'src_id' => Yii::t('menu', 'Menu Item ID'),
            'name' => Yii::t('menu', 'Name'),
            'domain_id' => Yii::t('menu', 'Domain ID'),
            'language_id' => Yii::t('menu', 'Language ID'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(MenuItem::className(), ['id' => 'src_id']);
    }
}
