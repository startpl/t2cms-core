<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\menu\useCases;

use t2cms\menu\models\forms\MenuForm;
use t2cms\menu\models\{
    Menu,
    MenuItem    
};

/**
 * Description of menuService
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 * @version 1.0
 */
class MenuService 
{
    private $menuRepository;
    private $menuItemRepository;
    
    public function __construct(
        \t2cms\menu\repository\MenuRepository $menuRepository,
        \t2cms\menu\repository\MenuItemRepository $menuItemRepository
    )
    {
        $this->menuRepository     = $menuRepository;
        $this->menuItemRepository = $menuItemRepository;
    }
    
    public function create(MenuForm $form): bool
    {
        $menu = new Menu([
            'name'  => $form->name,
            'title' => $form->title
        ]);
        
        $menuRoot = new MenuItem([
            'type' => MenuItem::TYPE_ROOT
        ]);
        
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $this->menuRepository->save($menu);
            
            $menuRoot->tree = $menu->id;
            $this->menuItemRepository->makeRoot($menuRoot);
            $transaction->commit();
        } catch (\Exception $e) {
            debug($e);
            $transaction->rollBack();
            return false;
        }
        
        return true;
    }
}
