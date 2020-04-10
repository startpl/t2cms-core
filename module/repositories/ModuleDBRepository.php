<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\module\repositories;

use t2cms\module\models\Module;

/**
 * Description of ModuleRepository
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 */
class ModuleDBRepository 
{
    public function get(int $id): ?Module
    {
        if(!$model = Module::findOne($id)){
            throw new \DomainException("Module with id: {$id} does not exists");
        }
        
        return $model;
    }
    
    public function getByPath(string $path): ?Module
    {
        if(!$model = Module::find()->where(['path' => $path])->one()){
            throw new \DomainException("Module with path: {$path} does not exists");
        }
        
        return $model;
    }
        
    public function save(Module $model): bool
    {
        if(!$model->save()){
            throw new \RuntimeException("Save Error");
        }
        
        return true;
    }
    
    public static function getAll($status = null): ?array
    {
        return Module::find()
                ->andFilterWhere(['status' => $status])
                ->all();
    }
}
