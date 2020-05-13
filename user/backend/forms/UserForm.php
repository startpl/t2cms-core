<?php

namespace t2cms\user\backend\forms;

use yii\base\Model;
use common\models\User;
use t2cms\user\common\models\AuthItem;
use t2cms\user\common\enums\UserRoles;

/**
 * Setting create form
 */
class UserForm extends Model
{
    public $id;
    public $username;
    public $status;
    public $role;
    public $email;
        
    public $newPassword;
    public $passwordRepeat;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            
            [['newPassword', 'passwordRepeat'], 'string', 'min' => 6],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'newPassword'],
            
            ['status', 'default', 'value' => User::STATUS_INACTIVE],
            ['status', 'in', 'range' => [User::STATUS_ACTIVE, User::STATUS_INACTIVE, User::STATUS_DELETED]],
            
            ['id', 'integer'],
            
            ['role', 'required'],
            ['role', 'default', 'value' => UserRoles::DEFAULT_ROLE],
            ['role', 'roleValidator']
        ];
    }
    
    public function roleValidator($attribute, $params): void
    {
        if(!AuthItem::find()->where(['name' => $this->role, 'type' => AuthItem::ROLE_TYPE])->exists()){
            $this->addError($attribute, \Yii::t('t2cms/error', 'Role {role} does not exist', ['role' => $this->role]));
        }
    }
    
    public function fillModel(Model $model): void
    {
        $this->attributes = $model->attributes;
    }
}
