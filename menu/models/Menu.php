<?php

namespace t2cms\menu\models;

use Yii;

/**
 * This is the model class for table "{{%menu}}".
 *
 * @property int $id
 * @property int $name
 * @property int $title
 *
 * @property MenuItem[] $menuItems
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%menu}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'title'], 'required'],
            ['name', 'filter', 'filter'=>'strtolower'],
            ['name', 'match', 'pattern' => '/^[a-z0-9\_]+$/i'],
            [['name', 'title'], 'string', 'max' => 120],
            ['name', 'unique', 'message' => 'The Menu with that name already exists.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('menu', 'ID'),
            'name' => Yii::t('menu', 'Name'),
            'title' => Yii::t('menu', 'Title'),
        ];
    }

    /**
     * Gets query for [[MenuItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMenuItems()
    {
        return $this->hasMany(MenuItem::className(), ['tree' => 'id']);
    }
}
