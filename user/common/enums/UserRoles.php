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
class UserRoles 
{
    const DEFAULT_ROLE = 'user';
    
    const ROLES = [
        [
            'name' => 'admin',
            'description' => 'Administrator'
        ],
        [
            'name' => 'content',
            'description' => 'Content manager'
        ],
        [
            'name' => 'user',
            'description' => 'User'
        ]
    ];
}