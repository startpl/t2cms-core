<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\user\common\repositories;

use t2cms\user\common\models\AuthItemChild;

/**
 * Description of PermissionRepository
 *
 * @author Koperdog <koperdog.dev@github.com>
 */
class AuthItemChildRepository extends \yii\base\BaseObject
{    
    public function save(AuthItemChild $model): bool
    {
        if(!$model->save()){
            throw new \RuntimeException("Error save");
        }
        
        return true;
    }
    
    public function delete(AuthItemChild $model): bool
    {
        if(!$model->delete()){
            throw new \RuntimeException("Error delete");
        }
        
        return true;
    }
}
