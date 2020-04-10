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
        $infoFile = $this->fileRepository->getModuleInfo($path);
        $config = $infoFile;
        
        try{
            $infoDB   = $this->dbRepository->getByPath($path);
            $config['currentVersion'] = $infoDB->version;
            $config['status'] = $infoDB->status;
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
}
