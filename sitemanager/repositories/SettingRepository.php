<?php

/**
 * @link https://github.com/t2cms/sitemanager
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/t2cms-core/sitemanager/blob/master/LICENSE
 */

namespace t2cms\sitemanager\repositories;

use yii\db\ActiveRecord;
use t2cms\sitemanager\models\
{
    Setting,
    SettingValue,
    forms\SettingForm
};

/**
 * Repository for Settings model
 * 
 * Repository for Settings model, implements repository design
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class SettingRepository 
{    
    const RELATION_NAME = 'value';
    
    /**
     * Checks if exists Setting by name
     * 
     * @param string $name
     * @return bool
     */
    public function existSetting(string $name): bool
    {
        return Setting::find()->where(['name' => $name])->exists();
    }
    
    public function getById(int $id): Setting
    {
        if(!$model = Setting::findOne($id)){
            throw new DomainException();
        }
        
        return $model;
    }
    
    public function getByName(string $name, $domain_id = null, $language_id = null): Setting
    {           
        $setting = Setting::find()->where(['name' => $name])->one();
        
        $settingValue = SettingValue::find()
                ->andWhere(['id' => SettingValue::getSuitableId($setting->id, $domain_id, $language_id)])
                ->one();
        
        $setting->populateRelation(self::RELATION_NAME, $settingValue);
        
        return $setting;
    }
    
    public function getAllByStatus
    (
        $status          = [Setting::STATUS['GENERAL']],
        int $domain_id   = null,
        int $language_id = null
    )
    {        
        $model = Setting::find()
                ->with([self::RELATION_NAME =>function($query) use ($domain_id, $language_id) {
                    $in = SettingValue::getAllSuitableId($domain_id, $language_id);
                    $query->andWhere(['IN', 'id', $in]);
                }])
                ->andFilterWhere(['status' => $status])
                ->indexBy('name')
                ->all();
        
        if(!$model){
            throw new \DomainException("Setting with status: {$status} does not exist");
        }
        
        return $model;
    }
    
    public function getAll(int $domain_id, int $language_id = null)
    {
        $model = Setting::find()
                ->with([self::RELATION_NAME =>function($query) use ($domain_id, $language_id) {
                    $in = SettingValue::getAllSuitableId($domain_id, $language_id);
                    $query->andWhere(['IN', 'id', $in]);
                }])
                ->indexBy('name')
                ->all();
        
        if(!$model){
            throw new \DomainException("Setting for domain id: {$domain_id} does not exist");
        }
        
        return $model;
    }
    
    public function getAllForDomain(int $domain_id, int $language_id = null)
    {
        
        $allSuitableIdForDomain = SettingValue::getAllSuitableIdForDomain($domain_id, $language_id);
        
        $model = Setting::find()
                ->with([self::RELATION_NAME =>function($query) use ($domain_id, $language_id) {
                    $in = array_values($allSuitableIdForDomain);
                    $query->andWhere(['IN', 'id', $in]);
                }])
                ->andWhere(['id' => array_keys($allSuitableIdForDomain)])
                ->indexBy('name')
                ->all();
                        
        if(!$model){
            throw new \DomainException("Setting for domain id: {$domain_id} does not exist");
        }
        
        return $model;
    }
    
    /**
     * Saves setting
     * 
     * @return bool
     * @throws \DomainException
     */
    public function save(ActiveRecord $setting): bool
    {
        if(!$setting->save()){
            throw new \RuntimeException();
        }
        
        return true;
    }
    
    public function delete(ActiveRecord $setting): bool
    {
        if(!$setting->delete()){
            throw new RuntimeException();
        }
        
        return true;
    }
    
    /**
     * Saves all settings
     * 
     * @param array $settings
     * @param array $data
     * @return bool
     */
    public function saveAll(array $settings, array $data, $domain_id = null, $language_id = null): bool
    {
        foreach($settings as $index => $setting){
            $load = [
                'value'    => $data['Setting'][$index],
                'required' => $setting->required
            ];
                        
            if($setting->value->load($load, '') && $setting->value->validate()){
                if(($setting->value->domain_id != $domain_id || $setting->value->language_id != $language_id)
                    && $setting->value->getDirtyAttributes())
                {
                    $this->copySetting($setting->value, $domain_id, $language_id);
                }
                else{
                    $this->save($setting->value);
                }
            }
            else{
                return false;
            }
        }
        
        return true;
    }
    
    private function copySetting(ActiveRecord $setting, $domain_id, $language_id)
    {
        $newSetting = new SettingValue();
        $newSetting->attributes = $setting->attributes;
        
        $newSetting->domain_id   = $domain_id;
        $newSetting->language_id = $language_id;
        
        return $this->save($newSetting);
    }
    
    public function create(SettingForm $form, $status = Setting::STATUS['CUSTOM']): bool
    {
        $setting = new Setting([
            'name'     => $form->name,
            'autoload' => $form->autoload,
            'required' => $form->required,
            'status'   => $status
        ]);
        
        $settingValue = new SettingValue([
            'value'     => $form->value,
        ]);
        
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $this->save($setting);
            $settingValue->link('setting', $setting);
            $transaction->commit();
        }catch(\RuntimeException $e){
            $transaction->rollBack();
            return false;
        }
        
        return true;
    }
}
