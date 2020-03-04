<?php

/**
 * @link https://github.com/startpl/t2cms
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/t2cms/blob/master/LICENSE
 */

namespace t2cms\sitemanager\repositories\read;

use t2cms\sitemanager\interfaces\ReadReposotory;
use t2cms\sitemanager\repositories\query\SettingValueQuery;
use t2cms\sitemanager\models\
{
    Setting,
    SettingValue
};

/**
 * Repository for Settings model
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class SettingReadRepository implements ReadReposotory
{

    public function getById(int $id): array
    {        
        return Setting::find()->where(['id' => $id])->asArray()->one();
    }
    
    public function getAllByStatus
    (
        int $status    = Setting::STATUS['GENERAL'],
        $domain_id     = null,
        $language_id   = null,
        $autoload      = null
    ): array
    {
        $model = SettingValueQuery::get($domain_id, $language_id, $status, $autoload)
                ->joinWith('setting')
                ->indexBy('setting.name')
                ->asArray()
                ->all();
                
        return $model;
    }
    
    public function getAllByDomain(int $domain_id, int $language_id = null, $autoload = null): array
    {        
        $model = SettingValueQuery::get($domain_id, $language_id, null, $autoload)
                ->joinWith('setting')
                ->indexBy('setting.name')
                ->asArray()
                ->all();
        
        return $model;
    }
    
    public function getByName(string $name, $domain_id = null, $language_id = null): array
    {        
        $model = SettingValueQuery::getByName($name, $domain_id, $language_id)
                ->indexBy('setting.name')
                ->asArray()
                ->one();
        
        return $model;
    }
    
    public function getAll(): ?array
    {
        return Setting::find()->asArray()->all();
    }
}
