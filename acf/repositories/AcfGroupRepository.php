<?php

/**
 * @link https://github.com/startpl/t2cms-core
 * @copyright Copyright (c) 2020 Koperdog
 * @license https://github.com/startpl/t2cms-core/blob/master/LICENSE
 */

namespace t2cms\acf\repositories;

use t2cms\acf\models\AcfGroup;

/**
 * Description of AcfGroupRepository
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 */
class AcfGroupRepository 
{
    public function get(int $id): AcfGroup
    {
        if(!$model = AcfGroup::findOne($id)){
            throw new \DomainException("Field Group with id: {$id} does not exists");
        }
        
        return $model;
    }
    
    public static function getAll(): ?array
    {
        return AcfGroup::find()->all();
    }
    
    public function save(AcfGroup $model): bool
    {
        if(!$model->save()){
            throw new \RuntimeException("Error save");
        }
        
        return true;
    }
    
    public function delete(AcfGroup $model): bool
    {
        if(!$model->delete()){
            throw new RuntimeException("Error delete");
        }
        
        return true;
    }
}
