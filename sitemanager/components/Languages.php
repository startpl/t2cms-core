<?php

/**
 * @link https://github.com/startpl/t2cms
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/t2cms/blob/master/LICENSE
 */

namespace t2cms\sitemanager\components;

use t2cms\sitemanager\repositories\read\LanguageReadRepository;
use t2cms\sitemanager\useCases\LanguageService;

/**
 * Component for work with Languages
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class Languages extends \yii\base\Component
{    
    /**
     * @var array Current|Default language
     */
    private static $current;
    
    /**
     * @var LanguageService Service (UseCases) of language
     */
    private $languageService;
    
    /**
     * @var LanguageReadRepository Repository for work with language model
     */
    private $languageRepository;
    
    public function __construct(LanguageService $service, LanguageReadRepository $repository)
    {
        parent::__construct();
        
        $this->languageService    = $service;
        $this->languageRepository = $repository;
        
        $this->getCurrent(\Yii::$app->language);
    }
    
    /**
     * Gets current language
     * 
     * @param string $code_local
     * @return array
     */
    public function getCurrent(string $code_local): array
    {
        if(self::$current === null){
            try{
                self::$current = $this->languageRepository->getByCodeLocal($code_local);
            } catch(\DomainException $e){
                self::$current = $this->getDefault();
            }
        }
        
        return self::$current;
    }
    
    /**
     * Gets id of current language
     * 
     * @return int
     */
    public function getCurrentId(): int
    {
        return self::$current['id'];
    }
    
    
    /**
     * Gets default langauge
     * 
     * @return array
     */
    public function getDefault(): array
    {
        return $this->languageRepository->getDefault();
    }
    
    public static function getEditorLangaugeId(): ?int
    {
        if(\Yii::$app->request->get('language') !== null){
            return ((int)\Yii::$app->request->get('language') > 0)? (int)\Yii::$app->request->get('language'): null;
        }
        
        return ((int)\Yii::$app->session->get('_language') > 0)? (int)\Yii::$app->session->get('_language'): null;
    }
}
