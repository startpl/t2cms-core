<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\base\behaviors;

/**
 * Description of ContentBehavior
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 */
class ContentBehavior extends \yii\base\Behavior
{
    public $relationName;
    public $relationModel;
    
    public function withContent(int $id, $domain_id = null, $language_id = null)
    {
        $model = $this->owner->modelClass;
        
        $query = $this->owner;
        
        $result = $query->with([$this->relationName => function($query) use ($id, $domain_id, $language_id){
                $query->andWhere(['id' => $this->relationModel::getSuitableId($id, $domain_id, $language_id)]);
            }])
            ->where([$model::tableName() . '.id' => $id]);
            
        return $result;
    }
        
    public function withAllContent($domain_id = null, $language_id = null, $exclude = [])
    {
        $model = $this->owner->modelClass;
        
        $query = $this->owner;            
            
        $result = $query->with([$this->relationName => function($query) use ($domain_id, $language_id, $exclude){
                $query->andWhere(['IN','id', $this->relationModel::getAllSuitableId($domain_id, $language_id, $exclude)]);
            }])
            ->andFilterWhere(['NOT IN', $model::tableName() . '.id', $exclude]);
    
        return $result;
    }
}