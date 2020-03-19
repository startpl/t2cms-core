<?php

namespace t2cms\menu\models;

use t2cms\sitemanager\repositories\DomainRepository;


/**
 * This is the ActiveQuery class for [[MenuItemContent]].
 *
 * @see MenuItemContent
 */
class MenuItemContentQuery extends \yii\db\ActiveQuery
{
    public static function get(int $id, $domain_id = null, $language_id = null): \yii\db\ActiveQuery
    {
        $defaultDomain = DomainRepository::getDefaultId();
        
        $query = MenuItemContent::find()
                ->andWhere(['menu_item_id' => $id, 'domain_id' => $domain_id, 'language_id' => $language_id]);
        
        if($language_id){
            $subquery = MenuItemContent::find()
                ->andWhere(['menu_item_id' => $id, 'domain_id' => $domain_id, 'language_id' => null])
                ->andWhere(['NOT IN', 'menu_item_id', 
                (new \yii\db\Query)
                ->select('menu_item_id')
                ->from(MenuItemContent::tableName())
                ->andWhere(['menu_item_id' => $id, 'domain_id' => $domain_id, 'language_id' => $language_id])
                ]);
            
            $query->union($subquery);
        }
                
        if($domain_id != $defaultDomain && $domain_id){
            $subquery = MenuItemContent::find()
                ->andWhere(['menu_item_id' => $id, 'domain_id' => $defaultDomain, 'language_id' => $language_id])
                ->andWhere(['NOT IN', 'menu_item_id', 
                (new \yii\db\Query)
                ->select('menu_item_id')
                ->from(MenuItemContent::tableName())
                ->andWhere(['menu_item_id' => $id, 'domain_id' => $domain_id, 'language_id' => $language_id])
                ->orWhere(['menu_item_id' => $id, 'domain_id' => $domain_id, 'language_id' => null])
                ]);
            
            $query->union($subquery);
        }
        
        if($domain_id != $defaultDomain && $domain_id && $language_id){
            $subquery = MenuItemContent::find()
                ->andWhere(['menu_item_id' => $id, 'domain_id' => $defaultDomain, 'language_id' => null])
                ->andWhere(['NOT IN', 'menu_item_id', 
                (new \yii\db\Query)
                ->select('menu_item_id')
                ->from(MenuItemContent::tableName())
                ->andWhere(['menu_item_id' => $id, 'domain_id' => $domain_id, 'language_id' => $language_id])
                ->orWhere(['menu_item_id' => $id, 'domain_id' => $domain_id, 'language_id' => null])
                ->orWhere(['menu_item_id' => $id, 'domain_id' => $defaultDomain, 'language_id' => $language_id])
                ]);
            
            $query->union($subquery);
        }
        
        if($domain_id && $language_id){
            $subquery = MenuItemContent::find()
                ->andWhere(['domain_id' => null, 'language_id' => $language_id])
                ->andWhere(['NOT IN', 'menu_item_id', 
                (new \yii\db\Query)
                ->select('menu_item_id')
                ->from(MenuItemContent::tableName())
                ->andWhere(['menu_item_id' => $id, 'domain_id' => $domain_id, 'language_id' => $language_id])
                ->orWhere(['menu_item_id' => $id, 'domain_id' => $domain_id, 'language_id' => null])
                ->orWhere(['menu_item_id' => $id, 'domain_id' => $defaultDomain, 'language_id' => $language_id])
                ->orWhere(['menu_item_id' => $id, 'domain_id' => $defaultDomain, 'language_id' => null])
                ]);
            
            $query->union($subquery);
        }
        
        if($domain_id || $language_id){
            
            $exclude = (new \yii\db\Query)
                    ->select('menu_item_id')
                    ->from(MenuItemContent::tableName())
                    ->andWhere(['menu_item_id' => $id, 'domain_id' => $domain_id, 'language_id' => $language_id]);
            
            if($domain_id) $exclude->orWhere(['menu_item_id' => $id, 'domain_id' => $domain_id, 'language_id' => null]);
            
            $exclude->orWhere(['menu_item_id' => $id, 'domain_id' => $defaultDomain, 'language_id' => $language_id])
                ->orWhere(['menu_item_id' => $id, 'domain_id' => $defaultDomain, 'language_id' => null]);
            
            if($language_id) $exclude->orWhere(['domain_id' => null, 'language_id' => $language_id]);
            
            $subquery = MenuItemContent::find()
                ->andWhere(['menu_item_id' => $id, 'domain_id' => null, 'language_id' => null])
                ->andWhere(['NOT IN', 'menu_item_id', $exclude]);
            
            $query->union($subquery);
        }
        
        return $query;
    }
    
    public static function getId(int $id, $domain_id = null, $language_id = null): \yii\db\ActiveQuery
    {
        $defaultDomain = DomainRepository::getDefaultId();
        
        $query = MenuItemContent::find()
                ->select('id')
                ->andWhere(['menu_item_id' => $id, 'domain_id' => $domain_id, 'language_id' => $language_id]);
        
        if($language_id){
            $subquery = MenuItemContent::find()
                ->select('id')
                ->andWhere(['menu_item_id' => $id, 'domain_id' => $domain_id, 'language_id' => null])
                ->andWhere(['NOT IN', 'menu_item_id', 
                (new \yii\db\Query)
                ->select('menu_item_id')
                ->from(MenuItemContent::tableName())
                ->andWhere(['menu_item_id' => $id, 'domain_id' => $domain_id, 'language_id' => $language_id])
                ]);
            
            $query->union($subquery);
        }
                
        if($domain_id != $defaultDomain && $domain_id){
            $subquery = MenuItemContent::find()
                ->select('id')
                ->andWhere(['menu_item_id' => $id, 'domain_id' => $defaultDomain, 'language_id' => $language_id])
                ->andWhere(['NOT IN', 'menu_item_id', 
                (new \yii\db\Query)
                ->select('menu_item_id')
                ->from(MenuItemContent::tableName())
                ->andWhere(['menu_item_id' => $id, 'domain_id' => $domain_id, 'language_id' => $language_id])
                ->orWhere(['menu_item_id' => $id, 'domain_id' => $domain_id, 'language_id' => null])
                ]);
            
            $query->union($subquery);
        }
        
        if($domain_id != $defaultDomain && $domain_id && $language_id){
            $subquery = MenuItemContent::find()
                ->select('id')
                ->andWhere(['menu_item_id' => $id, 'domain_id' => $defaultDomain, 'language_id' => null])
                ->andWhere(['NOT IN', 'menu_item_id', 
                (new \yii\db\Query)
                ->select('menu_item_id')
                ->from(MenuItemContent::tableName())
                ->andWhere(['menu_item_id' => $id, 'domain_id' => $domain_id, 'language_id' => $language_id])
                ->orWhere(['menu_item_id' => $id, 'domain_id' => $domain_id, 'language_id' => null])
                ->orWhere(['menu_item_id' => $id, 'domain_id' => $defaultDomain, 'language_id' => $language_id])
                ]);
            
            $query->union($subquery);
        }
        
        if($domain_id && $language_id){
            $subquery = MenuItemContent::find()
                ->select('id')
                ->andWhere(['domain_id' => null, 'language_id' => $language_id])
                ->andWhere(['NOT IN', 'menu_item_id', 
                (new \yii\db\Query)
                ->select('menu_item_id')
                ->from(MenuItemContent::tableName())
                ->andWhere(['menu_item_id' => $id, 'domain_id' => $domain_id, 'language_id' => $language_id])
                ->orWhere(['menu_item_id' => $id, 'domain_id' => $domain_id, 'language_id' => null])
                ->orWhere(['menu_item_id' => $id, 'domain_id' => $defaultDomain, 'language_id' => $language_id])
                ->orWhere(['menu_item_id' => $id, 'domain_id' => $defaultDomain, 'language_id' => null])
                ]);
            
            $query->union($subquery);
        }
        
        if($domain_id || $language_id){
            
            $exclude = (new \yii\db\Query)
                    ->select('menu_item_id')
                    ->from(MenuItemContent::tableName())
                    ->andWhere(['menu_item_id' => $id, 'domain_id' => $domain_id, 'language_id' => $language_id]);
            
            if($domain_id) $exclude->orWhere(['menu_item_id' => $id, 'domain_id' => $domain_id, 'language_id' => null]);
            
            $exclude->orWhere(['menu_item_id' => $id, 'domain_id' => $defaultDomain, 'language_id' => $language_id])
                ->orWhere(['menu_item_id' => $id, 'domain_id' => $defaultDomain, 'language_id' => null]);
            
            if($language_id) $exclude->orWhere(['domain_id' => null, 'language_id' => $language_id]);
            
            $subquery = MenuItemContent::find()
                ->select('id')
                ->andWhere(['menu_item_id' => $id, 'domain_id' => null, 'language_id' => null])
                ->andWhere(['NOT IN', 'menu_item_id', $exclude]);
            
            $query->union($subquery);
        }
        
        return $query;
    }
    
    public static function getAll($domain_id = null, $language_id = null): \yii\db\ActiveQuery
    {
        $defaultDomain = DomainRepository::getDefaultId();
        
        $query = MenuItemContent::find()
                ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id]);
        
        if($language_id){
            $subquery = MenuItemContent::find()
                ->andWhere(['domain_id' => $domain_id, 'language_id' => null])
                ->andWhere(['NOT IN', 'menu_item_id', 
                (new \yii\db\Query)
                ->select('menu_item_id')
                ->from(MenuItemContent::tableName())
                ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id])
                ]);
            
            $query->union($subquery);
        }
                
        if($domain_id != $defaultDomain && $domain_id){
            $subquery = MenuItemContent::find()
                ->andWhere(['domain_id' => $defaultDomain, 'language_id' => $language_id])
                ->andWhere(['NOT IN', 'menu_item_id', 
                (new \yii\db\Query)
                ->select('menu_item_id')
                ->from(MenuItemContent::tableName())
                ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id])
                ->orWhere(['domain_id' => $domain_id, 'language_id' => null])
                ]);
            
            $query->union($subquery);
        }
        
        if($domain_id != $defaultDomain && $domain_id && $language_id){
            $subquery = MenuItemContent::find()
                ->andWhere(['domain_id' => $defaultDomain, 'language_id' => null])
                ->andWhere(['NOT IN', 'menu_item_id', 
                (new \yii\db\Query)
                ->select('menu_item_id')
                ->from(MenuItemContent::tableName())
                ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id])
                ->orWhere(['domain_id' => $domain_id, 'language_id' => null])
                ->orWhere(['domain_id' => $defaultDomain, 'language_id' => $language_id])
                ]);
            
            $query->union($subquery);
        }
        
        if($domain_id && $language_id){
            $subquery = MenuItemContent::find()
                ->andWhere(['domain_id' => null, 'language_id' => $language_id])
                ->andWhere(['NOT IN', 'menu_item_id', 
                (new \yii\db\Query)
                ->select('menu_item_id')
                ->from(MenuItemContent::tableName())
                ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id])
                ->orWhere(['domain_id' => $domain_id, 'language_id' => null])
                ->orWhere(['domain_id' => $defaultDomain, 'language_id' => $language_id])
                ->orWhere(['domain_id' => $defaultDomain, 'language_id' => null])
                ]);
            
            $query->union($subquery);
        }
        
        if($domain_id || $language_id){
            
            $exclude = (new \yii\db\Query)
                    ->select('menu_item_id')
                    ->from(MenuItemContent::tableName())
                    ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id]);
            
            if($domain_id) $exclude->orWhere(['domain_id' => $domain_id, 'language_id' => null]);
            
            $exclude->orWhere(['domain_id' => $defaultDomain, 'language_id' => $language_id])
                ->orWhere(['domain_id' => $defaultDomain, 'language_id' => null]);
            
            if($language_id) $exclude->orWhere(['domain_id' => null, 'language_id' => $language_id]);
            
            $subquery = MenuItemContent::find()
                ->andWhere(['domain_id' => null, 'language_id' => null])
                ->andWhere(['NOT IN', 'menu_item_id', $exclude]);
            
            $query->union($subquery);
        }
        
        return $query;
    }
    
    public static function getAllId($domain_id = null, $language_id = null): \yii\db\ActiveQuery
    {
        $defaultDomain = DomainRepository::getDefaultId();
        
        $query = MenuItemContent::find()
                ->select('id')
                ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id]);
        
        if($language_id){
            $subquery = MenuItemContent::find()
                ->select('id')
                ->andWhere(['domain_id' => $domain_id, 'language_id' => null])
                ->andWhere(['NOT IN', 'menu_item_id', 
                (new \yii\db\Query)
                ->select('menu_item_id')
                ->from(MenuItemContent::tableName())
                ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id])
                ]);
            
            $query->union($subquery);
        }
                
        if($domain_id != $defaultDomain && $domain_id){
            $subquery = MenuItemContent::find()
                ->select('id')
                ->andWhere(['domain_id' => $defaultDomain, 'language_id' => $language_id])
                ->andWhere(['NOT IN', 'menu_item_id', 
                (new \yii\db\Query)
                ->select('menu_item_id')
                ->from(MenuItemContent::tableName())
                ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id])
                ->orWhere(['domain_id' => $domain_id, 'language_id' => null])
                ]);
            
            $query->union($subquery);
        }
        
        if($domain_id != $defaultDomain && $domain_id && $language_id){
            $subquery = MenuItemContent::find()
                ->select('id')
                ->andWhere(['domain_id' => $defaultDomain, 'language_id' => null])
                ->andWhere(['NOT IN', 'menu_item_id', 
                (new \yii\db\Query)
                ->select('menu_item_id')
                ->from(MenuItemContent::tableName())
                ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id])
                ->orWhere(['domain_id' => $domain_id, 'language_id' => null])
                ->orWhere(['domain_id' => $defaultDomain, 'language_id' => $language_id])
                ]);
            
            $query->union($subquery);
        }
        
        if($domain_id && $language_id){
            $subquery = MenuItemContent::find()
                ->select('id')
                ->andWhere(['domain_id' => null, 'language_id' => $language_id])
                ->andWhere(['NOT IN', 'menu_item_id', 
                (new \yii\db\Query)
                ->select('menu_item_id')
                ->from(MenuItemContent::tableName())
                ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id])
                ->orWhere(['domain_id' => $domain_id, 'language_id' => null])
                ->orWhere(['domain_id' => $defaultDomain, 'language_id' => $language_id])
                ->orWhere(['domain_id' => $defaultDomain, 'language_id' => null])
                ]);
            
            $query->union($subquery);
        }
        
        if($domain_id || $language_id){
            
            $exclude = (new \yii\db\Query)
                    ->select('menu_item_id')
                    ->from(MenuItemContent::tableName())
                    ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id]);
            
            if($domain_id) $exclude->orWhere(['domain_id' => $domain_id, 'language_id' => null]);
            
            $exclude->orWhere(['domain_id' => $defaultDomain, 'language_id' => $language_id])
                ->orWhere(['domain_id' => $defaultDomain, 'language_id' => null]);
            
            if($language_id) $exclude->orWhere(['domain_id' => null, 'language_id' => $language_id]);
            
            $subquery = MenuItemContent::find()
                ->select('id')
                ->andWhere(['domain_id' => null, 'language_id' => null])
                ->andWhere(['NOT IN', 'menu_item_id', $exclude]);
            
            $query->union($subquery);
        }
        
        return $query;
    }
}
