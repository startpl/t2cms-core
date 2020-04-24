<?php

namespace t2cms\sitemanager\models;

use Yii;
use yii\helpers\ArrayHelper;
use t2cms\base\factories\ContentApproaches;

/**
 * This is the model class for table "{{%setting_value}}".
 *
 * @property int $id
 * @property int $src_id
 * @property int|null $domain_id
 * @property int|null $language_id
 * @property int $value
 */
class SettingValue extends \yii\db\ActiveRecord
{
    use \t2cms\base\traits\ContentValueTrait;
    
    public $required;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%setting_value}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['src_id'], 'required'],
            [['src_id', 'domain_id', 'language_id'], 'integer'],
            [['value'], 'safe'],
            [['required'], 'checkRequired', 'when' => function($model){ return (bool)$model->required;}],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sitemanager', 'ID'),
            'src_id' => Yii::t('sitemanager', 'Setting ID'),
            'domain_id' => Yii::t('sitemanager', 'Domain ID'),
            'language_id' => Yii::t('sitemanager', 'Lang ID'),
            'value' => Yii::t('sitemanager', 'Value'),
        ];
    }
    
    public function checkRequired()
    {
        if(!mb_strlen($this->value)){
            $this->addError('value', Yii::t('sitemanager', 'The field cannot be blank.'));
        }
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSetting()
    {
        return $this->hasOne(Setting::className(), ['id' => 'src_id']);
    }
    
    public static function getAllSuitableId($domain_id = null, $language_id = null): ?array
    {
        $approaches = ContentApproaches::getApproaches($domain_id, $language_id);  
        
        $result = [];
        foreach($approaches as $approach){
            $result += ArrayHelper::map(
                self::getAllExistsId($approach['domain_id'], $approach['language_id'], array_keys($result)), 
                'src_id',
                'id');
        }
        
        return array_values($result);
    }
    
    public static function getAllSuitableIdForDomain($domain_id = null, $language_id = null): ?array
    {
        $approaches = [
            [
                'domain_id'   => $domain_id,
                'language_id' => $language_id
            ],
            [
                'domain_id'   => $domain_id,
                'language_id' => null
            ]
        ];
        
        $result = [];
        foreach($approaches as $approach){
            $result += ArrayHelper::map(
                self::getAllExistsId($approach['domain_id'], $approach['language_id'], array_keys($result)), 
                'src_id',
                'id');
        }
        
        return $result;
    }
    
    protected static function getAllExistsId($domain_id = null, $language_id = null, $exclude = []): ?array
    {
        return self::find()
                ->select('id, src_id')
                ->where(['domain_id' => $domain_id, 'language_id' => $language_id])
                ->andFilterWhere(['NOT IN', 'src_id', $exclude])
                ->all();
    }
}
