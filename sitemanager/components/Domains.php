<?php

/**
 * @link https://github.com/t2cms/sitemanager
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/t2cms-core/sitemanager/blob/master/LICENSE
 */

namespace t2cms\sitemanager\components;

use t2cms\sitemanager\repositories\read\DomainReadRepository;
use t2cms\sitemanager\useCases\DomainService;

/**
 * Component for work with domains
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class Domains extends \yii\base\Component
{
    /**
     * @var string Current domain, SERVER_HOST
     */
    public $currentHost;
    
    /**
     * @var array Current|Default langauge
     */
    private static $current;
    
    /**
     * @var DomainService Service (UseCases) for work with domains
     */
    private $domainService;
    
    /**
     * @var DomainReadRepository Repository for work with domains model
     */
    private $domainRepository;
    
    public function __construct(DomainService $service, DomainReadRepository $repository) {
        parent::__construct();
                    
        $this->domainService    = $service;
        $this->domainRepository = $repository;
        
        if(!\Yii::$app->request->isConsoleRequest){
            $this->currentHost = \Yii::$app->getRequest()->serverName;
        } else {
            $this->currentHost = $this->getDefault()['name'];
        }
        
        $this->getDomain();
    }
    
    /**
     * Gets id of current domain
     * 
     * @return int
     */
    public function getCurrentId(): int
    {
        return self::$current['id'];
    }
    
    /**
     * Gets current domain
     * 
     * @return array|null
     */
    public function getDomain(): ?array
    {
        if(self::$current === null){
            try{
                self::$current = $this->domainRepository->getByDomain($this->currentHost);
            } catch(\DomainException $e){
                self::$current = $this->getDefault();
            }
        }
        return self::$current;
    }
    
    /**
     * Gets default domain
     * 
     * @return array
     */
    public function getDefault(): array
    {
        return $this->domainRepository->getDefault();
    }
    
    public static function getEditorDomainId(): ?int
    {
        if(\Yii::$app->request->get('domain') !== null){
            return ((int)\Yii::$app->request->get('domain') > 0)? (int)\Yii::$app->request->get('domain'): null;
        }
        
        return ((int)\Yii::$app->session->get('_domain') > 0)? (int)\Yii::$app->session->get('_domain'): null;
    }
}
