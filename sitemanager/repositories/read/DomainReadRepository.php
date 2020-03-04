<?php

/**
 * @link https://github.com/startpl/t2cms
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/t2cms/blob/master/LICENSE
 */

namespace t2cms\sitemanager\repositories\read;

use t2cms\sitemanager\interfaces\ReadReposotory;
use t2cms\sitemanager\models\Domain;

/**
 * Repository for Domain model
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class DomainReadRepository implements ReadReposotory
{
    public function getById(int $id): array
    {
        if(!$model = Domain::find()->where(['id' => $id])->asArray()->one()){
            throw new \DomainException("The domain with id: {$id} does not exist");
        }
        
        return $model;
    }
    
    public function getByDomain(string $name): array
    {
        if(!$model = Domain::find()->where(['domain' => $name])->asArray()->one()){
            throw new \DomainException("The domain with name: {$name} does not exist!");
        }
        
        return $model;
    }
    
    public function getDefault(): array
    {
        if(!$model = Domain::find()->where(['is_default' => true])->asArray()->one()){
            throw new \DomainException("The default domain does not exist!");
        }
        
        return $model;
    }
    
    public function getAll(): ?array
    {
        return Domain::find()->asArray()->all();
    }
}
