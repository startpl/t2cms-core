<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\menu\repository\read;

use yii\helpers\ArrayHelper;
use t2cms\menu\models\{
    MenuItem,
    MenuItemContentQuery
};

/**
 * Description of MenuItemRepository
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 * @version 1.0
 */
class MenuItemReadRepository 
{
    public function get(int $id, $domain_id = null, $language_id = null): array
    {
        $model = MenuItem::find()
            ->with(['itemContent' => function($query) use ($id, $domain_id, $language_id){
                $query->andWhere(['id' => MenuItemContentQuery::getId($id, $domain_id, $language_id)->one()]);
            }])
            ->andWhere(['menu_item.id' => $id])
            ->asArray()
            ->one();
                   
        if(!$model){
            throw new \DomainException("Menu with id: {$id} was not found");
        }
        
        return $model;
    }
    
    public function getAll($domain_id = null, $language_id = null, $exclude = null): ?array
    {
        return MenuItem::find()
            ->joinWith(['itemContent' => function($query) use ($domain_id, $language_id){
                $in = ArrayHelper::getColumn(MenuItemContentQuery::getAllId($domain_id, $language_id)->asArray()->all(), 'id');
                $query->andWhere(['IN','menu_item_content.id', $in]);
            }])
            ->andWhere(['NOT IN', 'menu_item.id', 1])
            ->andFilterWhere(['NOT IN', 'menu_item.id', $exclude])
            ->asArray()
            ->all();
    }
    
    public function getItemsByMenu(MenuItem $menu, $domain_id = null, $language_id = null): ?array
    {        
        if($menu){
            return $menu->children()
                ->joinWith(['itemContent' => function($query) use ($domain_id, $language_id){
                    $in = ArrayHelper::getColumn(
                        MenuItemContentQuery::getAllId($domain_id, $language_id)
                        ->asArray()
                        ->all()
                    , 'id');
                    $query->andWhere(['IN','menu_item_content.id', $in]);
                }])
                ->orderBy('lft')
                ->asArray()
                ->all();
        }
        
        return null;
    }
    
    public function getRoot(int $treeId): ?MenuItem
    {
        $model = MenuItem::find()
                ->where(['tree' => $treeId, 'type' => MenuItem::TYPE_ROOT])
                ->one();
        
        if(!$model){
            throw new \DomainException("The Root for Menu with id: {$treeId} not found");
        }
        
        return $model;
    }
}
