<?php

/**
 * @link https://github.com/t2cms/sitemanager
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/t2cms-core/sitemanager/blob/master/LICENSE
 */

namespace t2cms\sitemanager\repositories\read;

use t2cms\sitemanager\interfaces\ReadReposotory;
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
    const RELATION_NAME = 'value';
    
    public function getById(int $id): array
    {
        return Setting::find()->where(['id' => $id])->asArray()->one();
    }
    
    public function getAllByStatus
    (
        $status          = [Setting::STATUS['GENERAL']],
        int $domain_id   = null,
        int $language_id = null
    ): ?array
    {        
        $model = Setting::find()
                ->with([self::RELATION_NAME =>function($query) use ($domain_id, $language_id) {
                    $in = SettingValue::getAllSuitableId($domain_id, $language_id);
                    $query->andWhere(['IN', 'id', $in]);
                }])
                ->andFilterWhere(['status' => $status])
                ->indexBy('name')
                ->asArray()
                ->all();
        
        return $model;
    }
    
    
    public function getAll(int $domain_id, int $language_id = null, bool $autoload = null): ?array
    {
        $model = Setting::find()
                ->with([self::RELATION_NAME =>function($query) use ($domain_id, $language_id) {
                    $in = SettingValue::getAllSuitableId($domain_id, $language_id);
                    $query->andWhere(['IN', 'id', $in]);
                }])
                ->andFilterWhere(['autoload' => $autoload])
                ->indexBy('name')
                ->asArray()
                ->all();
        return $model;
    }
    
    public function getByName(string $name, $domain_id = null, $language_id = null): ?array
    {           
        $setting = Setting::find()->where(['name' => $name])->asArray()->one();
        
        $settingValue = SettingValue::find()
                ->andWhere(['id' => SettingValue::getSuitableId($setting['id'], $domain_id, $language_id)])
                ->asArray()
                ->one();
        
        $setting['value'] = $settingValue;
        
        return $setting;
    }
}
