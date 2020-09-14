<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\module\services;

use t2cms\module\dto\ModuleDTO;
use t2cms\module\factories\ModuleFactory;
use t2cms\module\models\Module;
use t2cms\module\repositories\{
    ModuleDBRepository,
    ModuleFileRepository
};

/**
 * Description of ModuleService
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 */
class ModuleService 
{
    private $dbRepository;
    private $fileRepository;
    
    public function __construct(ModuleDBRepository $dbRepository, ModuleFileRepository $fileRepository)
    {
        $this->dbRepository   = $dbRepository;
        $this->fileRepository = $fileRepository;
    }
    
    public function getModule(string $path): ?ModuleDTO
    {        
        try{
            $infoFile = $this->fileRepository->getModuleInfo($path);
            $config = $infoFile;
        } catch (\DomainException $e) {
            return null;
        }
        
        try{
            $infoDB = $this->dbRepository->getByPath($path);
            $config['currentVersion'] = $infoDB->version;
            $config['status'] = $infoDB->status;
            $config['show_in_menu'] = $infoDB->show_in_menu;
        } catch (\DomainException $e) {
            $config['status'] = Module::STATUS_NEW;
        }
        
        return ModuleFactory::getModuleDTO($config);
    }
    
    public function getAll(): ?array
    {
        $directories = $this->fileRepository->getAll();
        
        $result = [];
        foreach($directories as $dir){
            $result[] = $this->getModule($dir);
        }
        
        return $result;
    }
    
    public function getAllActive(): ?array
    {
        $modules = $this->dbRepository->getAllActive();
                
        $result = [];
        foreach($modules as $module){
            $result[] = $this->getModule($module->path);
        }
        
        return array_filter($result);
    }
    
    public function install(ModuleDTO $module): bool
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $this->fileRepository->install($module);
            $this->dbRepository->install($module);
            $transaction->commit();
        } catch (\Exception $e){
            $transaction->rollBack();
            return false;
        }
        
        return true;
    }
    
    public function uninstall(ModuleDTO $module): bool
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $this->fileRepository->uninstall($module);
            $this->dbRepository->uninstall($module);
            $transaction->commit();
        } catch (\Exception $e){
            $transaction->rollBack();
            return false;
        }
        
        return true;
    }
    
    public function activate(ModuleDTO $module): bool
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $this->fileRepository->activate($module);
            $this->dbRepository->activate($module);
            $transaction->commit();
        } catch (\Exception $e){
            $transaction->rollBack();
            return false;
        }
        
        return true;
    }
    
    public function deactivate(ModuleDTO $module): bool
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $this->fileRepository->deactivate($module);
            $this->dbRepository->deactivate($module);
            $transaction->commit();
        } catch (\Exception $e){
            $transaction->rollBack();
            return false;
        }
        
        return true;
    }
    
    public function update(ModuleDTO $module): bool
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $this->fileRepository->deactivate($module);
            $this->dbRepository->deactivate($module);
            $transaction->commit();
        } catch (\Exception $e){
            $transaction->rollBack();
            return false;
        }
        
        return true;
    }
    
    public function showMenuToggle($module, $value): bool
    {
        $transaction = \Yii::$app->db->beginTransaction();
               
        try{
            $this->dbRepository->showMenuToggle($module, $value);
            $transaction->commit();
        } catch (\Exception $e){
            debug($e);
            $transaction->rollBack();
            return false;
        }
        
        return true;
    }
    
    public function getAllToShowMenu(): ?array
    {
        $modules = $this->dbRepository->getAllToShowMenu();
                
        $result = [];
        foreach($modules as $module){
            $result[] = $this->getModule($module->path);
        }
        
        return $result;
    }
    
    public function isActive(string $path): bool
    {
        $module = $this->getModule($path);
        
        return $module->status === Module::STATUS_ACTIVE;
    }
}
