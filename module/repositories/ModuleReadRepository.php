<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\module\repositories;

use t2cms\module\dto\ModuleDTO;
use t2cms\module\factories\ModuleFactory;
use t2cms\module\repositories\{
    ModuleDBRepository,
    ModuleFileRepository
};

/**
 * Description of ModuleReadRepositoryt
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 */
class ModuleReadRepository 
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
        $infoDB   = $this->dbRepository->getByPath($path);
        
        $config = $infoFile;
        $config['currentVersion'] = $infoDB->version;
        $config['status'] = $infoDB->status;
        
        return ModuleFactory::getModuleDTO($config);
    }
    
    public function getAll(): ?array
    {
        return FileHelper::findDirectories($this->pathThemes, ['recursive' => false]);
    }
    
}