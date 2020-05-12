<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\user\common\enums;

/**
 * Description of Groups
 *
 * @author Koperdog <koperdog@github.com>
 */
class UserPermissions 
{    
    const PERMISSIONS = [
        [
            'name' => 'adminPanel',
            'description' => 'Login to admin panel'
        ],
        [
            'name' => 'managePost',
            'description' => 'Post management'
        ],
        [
            'name' => 'manageSetting',
            'description' => 'Setting management'
        ],
        [
            'name' => 'manageRBAC',
            'description' => 'Roles and Permission management'
        ],
        [
            'name' => 'manageModule',
            'description' => 'Modules management'
        ],
        [
            'name' => 'manageMenu',
            'description' => 'Menu management'
        ]
    ];
}