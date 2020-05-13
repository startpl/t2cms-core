<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\user\common\enums;

use common\models\User;

/**
 * Description of UserStatusEnum
 *
 * @author Koperdog <koperdog@github.com>
 */
class UserStatus 
{       
    public static function getStatuses(): array
    {
        return [
            User::STATUS_ACTIVE => \Yii::t('t2cms', 'Active'),
            User::STATUS_INACTIVE => \Yii::t('t2cms', 'Inactive'),
            User::STATUS_DELETED => \Yii::t('t2cms', 'Deleted')
        ];
    }
}
