<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\menu\repository;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use t2cms\menu\models\{
    MenuItemContent,
    MenuItem,
    MenuItemContentQuery
};

/**
 * Description of MenuItemRepository
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 * @version 1.0
 */
class MenuItemRepository 
{
    public function get(int $id, $domain_id = null, $language_id = null): ActiveRecord
    {
        $model = MenuItem::find()
            ->with(['itemContent' => function($query) use ($id, $domain_id, $language_id){
                $query->andWhere(['id' => MenuItemContentQuery::getId($id, $domain_id, $language_id)->one()]);
            }])
            ->andWhere(['menu_item.id' => $id])
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
                ->all();
        }
        
        return null;
    }
    
    public function save($model): bool
    {
        if(!$model->save()){
            throw new \RuntimeException('Error saving model');
        }
        
        return true;
    }
    
    public function appendTo(MenuItem $model): bool
    {
        $parent = $this->get($model->parent_id);
        
        if(!$model->appendTo($parent)){
            throw new \RuntimeException("Error append model");
        }
        
        return true;
    }
    
    public function makeRoot(MenuItem $model): bool
    {
        if(!$model->makeRoot()){
            throw new \RuntimeException("Error Make Root menu model");
        }
        
        return true;
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
    
    public function delete(MenuItem $model): bool
    {
        return $model->deleteWithChildren();
    }
    
    public function saveContent(MenuItemContent $model, $domain_id = null, $language_id = null): bool
    {
        if(($model->domain_id != $domain_id || $model->language_id != $language_id) && $model->getDirtyAttributes())
        {
            return $this->copyCategoryContent($model, $domain_id, $language_id);
        }
        
        return $this->save($model);
    }
    
    private function copyCategoryContent(\yii\db\ActiveRecord $model, $domain_id, $language_id)
    {
        $newContent = new MenuItemContent([
            'name'         => $model->name,
            'menu_item_id' => $model->menu_item_id,
            'domain_id'    => $domain_id,
            'language_id'  => $language_id
        ]);
        
        return $this->save($newContent);
    }
    
    public function link(string $name, $target, $model): void
    {
        $model->link($name, $target);
    }
}
