<?php

/**
 * @link https://github.com/startpl/t2cms-core
 * @copyright Copyright (c) 2020 Koperdog
 * @license https://github.com/startpl/t2cms-core/blob/master/LICENSE
 */

namespace t2cms\acf\repositories;

use t2cms\acf\models\AcfField;

/**
 * Description of AcfGoupRepository
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 */
class AcfFieldRepository 
{
    public function get(int $id, $domain_id = null, $language_id = null): AcfField
    {
        $model = AcfField::find()
            ->with(['fieldValue' => function($query) use ($id, $domain_id, $language_id){
                $query->andWhere(['id' => AcfFieldValueQuery::getId($id, $domain_id, $language_id)->one()]);
            }])
            ->andWhere(['acf_field.id' => $id])
            ->one();
        
        if(!$model = AcfField::findOne($id)){
            throw new \DomainException("Field with id: {$id} does not exists");
        }
        
        return $model;
    }
    
    public static function getAll($domain_id = null, $language_id = null): ?array
    {
        return AcfField::find()
            ->joinWith(['fieldValue' => function($query) use ($domain_id, $language_id){
                $in = \yii\helpers\ArrayHelper::getColumn(AcfFieldValueQuery::getAllId($domain_id, $language_id)->asArray()->all(), 'id');
                $query->andWhere(['IN','acf_field_value.id', $in]);
            }])
            ->all();
    }
    
    public function getAllByGroup(
        int $groupId, 
        int $srcId, 
        string $srcType, 
        int $domain_id = null, 
        int $language_id = null
    ): ?array 
    {         
        return AcfField::find()
        ->with(['value' => function($query) use ($srcId, $srcType, $domain_id, $language_id){
            $in = \t2cms\acf\models\AcfFieldValue::getAllSuitableId($domain_id, $language_id);
            $query->andWhere(['id' => $in, 'src_id' => $srcId, 'src_type' => $srcType]);
        }])
        ->andWhere(['group_id' => $groupId])
        ->all();
    }
        
    public function save(AcfField $model): bool
    {
        if(!$model->save()){
            throw new \RuntimeException("Error save");
        }
        
        return true;
    }
    
    public function delete(AcfField $model): bool
    {
        if(!$model->delete()){
            throw new RuntimeException("Error delete");
        }
        
        return true;
    }
}
