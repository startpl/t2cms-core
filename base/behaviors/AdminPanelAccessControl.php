<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\base\behaviors;

use yii\base\ActionFilter;
use yii\di\Instance;
use yii\web\User;
use yii\web\ForbiddenHttpException;

/**
 * Description of AdminPanelAccessControl
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 */
class AdminPanelAccessControl extends ActionFilter
{
    public $user = 'user';
    
    public $permissionName = 'adminPanel';
    
    /**
     * Initializes the [[rules]] array by instantiating rule objects from configurations.
     */
    public function init()
    {
        parent::init();
        if ($this->user !== false) {
            $this->user = Instance::ensure($this->user, User::className());
        }
    }
    
    /**
     * This method is invoked right before an action is to be executed (after all possible filters.)
     * You may override this method to do last-minute preparation for the action.
     * @param Action $action the action to be executed.
     * @return bool whether the action should continue to be executed.
    */
    public function beforeAction($action)
    {
        $user = $this->user;
        if($user->can($this->permissionName)) {
            return true;
        }
        
        $this->denyAccess($user);
        return false;
    }
    
    /**
     * Denies the access of the user.
     * The default implementation will redirect the user to the login page if he is a guest;
     * if the user is already logged, a 403 HTTP exception will be thrown.
     * @param User|false $user the current user or boolean `false` in case of detached User component
     * @throws ForbiddenHttpException if the user is already logged in or in case of detached User component.
     */
    protected function denyAccess($user)
    {
        if ($user !== false && $user->getIsGuest()) {
            $user->loginRequired();
        } else {
            throw new ForbiddenHttpException(\Yii::t('app', 'You do not have access to the admin panel.'));
        }
    }
}
