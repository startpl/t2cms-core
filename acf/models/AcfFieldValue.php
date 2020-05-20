<?php

namespace t2cms\acf\models;

use Yii;

/**
 * This is the model class for table "{{%acf_field_value}}".
 *
 * @property int $id
 * @property int $field_id
 * @property string|null $value
 * @property string $src_type
 * @property int $domain_id
 * @property int $language_id
 *
 * @property Domain $domain
 * @property AcfField $field
 * @property Language $language
 */
class AcfFieldValue extends \yii\db\ActiveRecord
{
    use \t2cms\base\traits\ContentValueTrait;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%acf_field_value}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['field_id', 'domain_id', 'language_id'], 'required'],
            [['field_id', 'domain_id', 'language_id'], 'integer'],
            [['value', 'src_type'], 'string'],
            [['domain_id'], 'exist', 'skipOnError' => true, 'targetClass' => Domain::className(), 'targetAttribute' => ['domain_id' => 'id']],
            [['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => AcfField::className(), 'targetAttribute' => ['field_id' => 'id']],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'field_id' => Yii::t('app', 'Field ID'),
            'value' => Yii::t('app', 'Value'),
            'domain_id' => Yii::t('app', 'Domain ID'),
            'language_id' => Yii::t('app', 'Language ID'),
        ];
    }

    /**
     * Gets query for [[Domain]].
     *
     * @return \yii\db\ActiveQuery|DomainQuery
     */
    public function getDomain()
    {
        return $this->hasOne(Domain::className(), ['id' => 'domain_id']);
    }

    /**
     * Gets query for [[Field]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(AcfField::className(), ['id' => 'field_id']);
    }

    /**
     * Gets query for [[Language]].
     *
     * @return \yii\db\ActiveQuery|LanguageQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }
}
