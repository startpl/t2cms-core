<?php

/**
 * @link https://github.com/t2cms/sitemanager
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/t2cms-core/sitemanager/blob/master/LICENSE
 */

namespace t2cms\sitemanager\useCases;

use t2cms\sitemanager\repositories\{
    SettingRepository,
    DomainRepository
};
use \t2cms\sitemanager\models\{
    Setting,
    forms\SettingForm
};

/**
 * Setting (UseCases) for setting, setting_value model
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class SettingService {
    /**
     * @var SettingRepository repository of setting model
     */
    private $settingRepository;
    
    /**
     * @var DomainRepository repository of domain model
     */
    private $domainRepository;
    
    public function __construct(SettingRepository $setting, DomainRepository $domain)
    {
        $this->settingRepository = $setting;
        $this->domainRepository  = $domain;
    }
    
    /**
     * Creates setting
     * 
     * @param SettingForm $form
     * @param type $status
     * @return bool
     */
    public function create(SettingForm $form, $status = Setting::STATUS['CUSTOM']): bool
    {
        return $this->settingRepository->create($form, $status);
    }
    
    /**
     * Saves all values of settings
     * 
     * @param array $settings
     * @param array $data
     * @param int $domain_id
     * @param int $language_id
     * @return bool
     */
    public function saveMultiple(array $settings, array $data, int $domain_id = null, int $language_id = null): bool
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $success = $this->settingRepository->saveAll($settings, $data, $domain_id, $language_id);
            $transaction->commit();
        }catch(\RuntimeException $e){
            $transaction->rollBack();
            return false;
        }
        
        return $success;
    }
    
    /**
     * Saves value setting
     * 
     * @param Setting $setting
     * @return bool
     */
    public function save(Setting $setting): bool
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $this->settingRepository->save($setting);
            $transaction->commit();
        } catch(\Throwable $e) {
            $transaction->rollBack();
            return false;
        }
        
        return true;
    }
    
    /**
     * Deletes setting
     * 
     * @param Setting $setting
     * @return bool
     */
    public function delete(Setting $setting): bool
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $setting->unlinkAll('values', true);
            $this->settingRepository->delete($setting);
            $transaction->commit();
        } catch(\Throwable $e) {
            $transaction->rollBack();
            return false;
        }
        
        return true;
    }
}