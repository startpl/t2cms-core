<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\user\common\enums;

/**
 * Description of DefaultAssignments
 *
 * @author Koperdog <koperdog@github.com>
 */
class DefaultAssignments 
{    
    /**
     * Default adjacency matrix graph, rows - roles, columns - permissions
     * 
     * rows = [ admin, content, user]
     * columns = [ adminPanel, managePost, manageSetting, manageRBAC, manageModule, manageMenu ]
     */
    const ADJACENCY_MATRIX = [       
        [1, 1, 1, 1, 1, 1],
        [1, 1, 0, 0, 0, 1],
        [0, 0, 0, 0, 0, 0]
    ];

}