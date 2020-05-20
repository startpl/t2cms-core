<?php

namespace t2cms\acf\models;

use Yii;

/**
 * This is the model class for table "{{%acf_field}}".
 *
 * @property int $id
 * @property string $name
 * @property int $type
 * @property int $group_id
 *
 * @property AcfGroup $group
 * @property AcfFieldValue[] $acfFieldValues
 */
class AcfField extends \yii\db\ActiveRecord
{
    const TYPE_TEXT     = 0;
    const TYPE_INTEGER  = 1;
    const TYPE_TEXTAREA = 2;
    const TYPE_CHECKBOX = 3;
    const TYPE_SELECT   = 4;
    const TYPE_FILE     = 5;
    
    public function behaviors(): array 
    {
        return [
            'content' => [
                'class' => \t2cms\base\behaviors\ContentBehavior::className(),
                'relationName'  => 'value',
                'relationModel' => AcfFieldValue::className() 
            ]
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%acf_field}}';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type', 'group_id'], 'required'],
            [['type', 'group_id'], 'integer'],
            [['name', 'data'], 'string', 'max' => 100],
            [['type'], 'default', 'value' => self::TYPE_TEXT],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => AcfGroup::className(), 'targetAttribute' => ['group_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'type' => Yii::t('app', 'Type'),
            'group_id' => Yii::t('app', 'Group ID'),
        ];
    }

    /**
     * Gets query for [[Group]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(AcfGroup::className(), ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValue()
    {
        return $this->hasOne(AcfFieldValue::className(), ['field_id' => 'id']);
    }
    
    public static function getTypes(): array
    {
        return [
            self::TYPE_TEXT     => 'text',
            self::TYPE_INTEGER  => 'number',
            self::TYPE_TEXTAREA => 'textarea',
            self::TYPE_CHECKBOX => 'checkbox',
            self::TYPE_SELECT   => 'select',
            self::TYPE_FILE     => 'file'
        ];
    }
    
    public static function getType(int $type): string
    {
        return self::getTypes()[$type];
    }
}
