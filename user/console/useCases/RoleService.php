<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\user\console\useCases;

use t2cms\user\console\repositories\RoleRepository;
use yii\rbac\Role;

/**
 * Description of UserService
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 * @version 1.0
 */
class RoleService 
{
    private $roleRepository;
    
    public function __construct(RoleRepository $roleRepository) {
        $this->roleRepository = $roleRepository;
    }
    
    public function createRoles(array $roles): bool
    {
        foreach($roles as $role){
            $role = $this->createRole($role['name'], $role['description']);
            $this->saveRole($role);
        }
        
        return true;
    }
    
    public function saveRole(Role $role): bool
    {
        try{
            $this->roleRepository->addRole($role);
        } catch (\Exception $e){
            return false;
        }
        return true;
    }
    
    public function createRole(string $name, string $description = ''): Role
    {
        try{
            $role = $this->roleRepository->createRole($name, $description);
        } catch (\Exception $e) {
            return null;
        }
        
        return $role;
    }
    
}
