<?php

namespace t2cms\sitemanager\models;

use Yii;

/**
 * This is the model class for table "{{%setting}}".
 *
 * @property int $id
 * @property string $name
 * @property int $required
 * @property int $autoload
 * @property int $status
 */
class Setting extends \yii\db\ActiveRecord
{    
    const STATUS = [
        'GENERAL' => 0, 
        'MAIN'    => 1, 
        'CUSTOM'  => 2,
        'SYSTEM'  => 3
    ];
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%setting}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'required', 'autoload', 'status'], 'required'],
            [['required', 'autoload', 'status'], 'integer'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sitemanager', 'ID'),
            'name' => Yii::t('sitemanager', 'Name'),
            'required' => Yii::t('sitemanager', 'Required'),
            'autoload' => Yii::t('sitemanager', 'Autoload'),
            'status' => Yii::t('sitemanager', 'Status'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return SettingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SettingQuery(get_called_class());
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValue()
    {
        return $this->hasOne(SettingValue::className(), ['setting_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValues()
    {
        return $this->hasMany(SettingValue::className(), ['setting_id' => 'id']);
    }
    
    public function getGeneralValue()
    {
        return $this->hasOne(SettingValue::className(), ['setting_id' => 'id'])
                ->andWhere(['domain_id' => null, 'language_id' => null]);
    }
}
