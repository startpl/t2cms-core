<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\base\traits;

use t2cms\base\factories\ContentApproaches;
use yii\helpers\ArrayHelper;

/**
 * Description of ContentValueApproachesTrait
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 */
trait ContentValueTrait
{
    public static function getSuitableId(int $id, $domain_id = null, $language_id = null): ?int
    {
        $approaches = ContentApproaches::getApproaches($domain_id, $language_id);
                
        foreach($approaches as $approach){
            if($result = static::isExistsId($id, $approach['domain_id'], $approach['language_id'])){
                return $result;
            }
        }
        
        return null;
    }
    
    public static function getAllSuitableId($domain_id = null, $language_id = null): ?array
    {
        $approaches = ContentApproaches::getApproaches($domain_id, $language_id);  
        
        $result = [];
        foreach($approaches as $approach){
            $result += ArrayHelper::map(
                static::getAllExistsId($approach['domain_id'], $approach['language_id'], array_keys($result)), 
                'src_id',
                'id');
        }
        
        return array_values($result);
    }
    
    protected static function isExistsId(int $id, $domain_id, $language_id): ?int
    {
        $model = static::find()
                ->select('id')
                ->where(['src_id' => $id])
                ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id])
                ->one();
        
        return $model !== null? $model->id : null;
    }
    
    protected static function getAllExistsId($domain_id = null, $language_id = null, $exclude = []): ?array
    {
        return static::find()
                ->select('id, src_id')
                ->where(['domain_id' => $domain_id, 'language_id' => $language_id])
                ->andFilterWhere(['NOT IN', 'src_id', $exclude])
                ->all();
    }
}
