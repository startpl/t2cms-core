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
            'id' => Yii::t('user', 'ID'),
            'username' => Yii::t('user', 'Username'),
            'auth_key' => Yii::t('user', 'Auth Key'),
            'password_hash' => Yii::t('user', 'Password Hash'),
            'password_reset_token' => Yii::t('user', 'Password Reset Token'),
            'email' => Yii::t('user', 'Email'),
            'status' => Yii::t('user', 'Status'),
            'created_at' => Yii::t('user', 'Created At'),
            'updated_at' => Yii::t('user', 'Updated At'),
            'verification_token' => Yii::t('user', 'Verification Token'),
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
