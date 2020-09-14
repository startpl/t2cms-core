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
    
    public function getAllActive(): ?array
    {
        return Module::find()->active()->all();
    }


    public function save(Module $model): bool
    {
        if(!$model->save()){
            throw new \RuntimeException("Save Error");
        }
        
        return true;
    }
    
    public function delete(Module $model): bool
    {
        if(!$model->delete()){
            throw new \RuntimeException("Delete Error");
        }
        
        return true;
    }
    
    public static function getAll($status = null): ?array
    {
        return Module::find()
                ->andFilterWhere(['status' => $status])
                ->all();
    }
    
    public function install(\t2cms\module\dto\ModuleDTO $module): bool
    {
        $model = new Module([
            'url' => $module->url,
            'path' => $module->path,
            'version' => $module->version,
            'status'  => Module::STATUS_INSTALL,
            'show_in_menu' => false
        ]);
        
        return $this->save($model);
    }
    
    public function uninstall(\t2cms\module\dto\ModuleDTO $module): bool
    {
        $model = Module::findOne(['path' => $module->path]);
        
        return $this->delete($model);
    }
    
    public function activate(\t2cms\module\dto\ModuleDTO $module): bool
    {
        return $this->setStatus($module, Module::STATUS_ACTIVE);
    }
    
    public function deactivate(\t2cms\module\dto\ModuleDTO $module): bool
    {
        return $this->setStatus($module, Module::STATUS_INACTIVE);
    }
    
    public function update(\t2cms\module\dto\ModuleDTO $module, $version): bool
    {
        $model = Module::findOne(['path' => $module->path]);
        $model->version = $version;
        
        return $this->save($model);
    }
    
    public function showMenuToggle(\t2cms\module\dto\ModuleDTO $module, $value): bool
    {
        $model = Module::findOne(['path' => $module->path]);
        $model->show_in_menu = $value;
        
        return $this->save($model);
    }
    
    public function getAllToShowMenu(): ?array
    {
        return Module::find()->where(['show_in_menu' => true, 'status' => Module::STATUS_ACTIVE])->all();
    }
    
    private function setStatus(\t2cms\module\dto\ModuleDTO $module, int $status): bool
    {
        $model = Module::findOne(['path' => $module->path]);
        $model->status = $status;
        
        return $this->save($model);
    }
    
}
