<?php

namespace t2cms\user\common\models;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $verification_token
 */
class User extends \yii\db\ActiveRecord
{
    public $newPassword;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            [['status'], 'integer'],
            [['username', 'email', 'password_hash', 'newPassword'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['email'], 'unique'],
            ['newPassword', 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('t2cms', 'ID'),
            'username' => Yii::t('t2cms', 'Username'),
            'auth_key' => Yii::t('t2cms', 'Auth Key'),
            'password_hash' => Yii::t('t2cms', 'Password Hash'),
            'password_reset_token' => Yii::t('t2cms', 'Password Reset Token'),
            'email' => Yii::t('t2cms', 'Email'),
            'status' => Yii::t('t2cms', 'Status'),
            'created_at' => Yii::t('t2cms', 'Created At'),
            'updated_at' => Yii::t('t2cms', 'Updated At'),
            'verification_token' => Yii::t('t2cms', 'Verification Token'),
        ];
    }
    
    public function beforeSave($insert) 
    {
        parent::beforeSave($insert);
        
        if($this->newPassword){
            $this->password_hash = Yii::$app->security->generatePasswordHash($this->newPassword);
        }
    }
    
    public function getRole() 
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'item_name'])
                ->viaTable(AuthAssignment::tableName(), ['user_id' => 'id']);
    }
}
