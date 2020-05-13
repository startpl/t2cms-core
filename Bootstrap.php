<?php

/**
 * @link https://github.com/t2cms/sitemanager
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/t2cms-core/sitemanager/blob/master/LICENSE
 */

namespace t2cms;
/**
 * Modulegithub.com/t2cms/sitemanager
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class Bootstrap implements \yii\base\BootstrapInterface
{
    /**
     * @var array Bootstraps list, order by index
     */
    private $bootstraps = [
        't2cms\module\ModuleBootstrap'
    ];
    
    public function bootstrap($app) 
    {
        \Yii::setAlias('@www', '@app/../www');
        \Yii::setAlias('@cms', '@app/../cms');
        \Yii::setAlias('@modules', '@cms/modules');
        \Yii::setAlias('@themes', '@cms/themes');
        
        if(!$app->request->isConsoleRequest){
            \Yii::setAlias('@theme', '@themes/'.$app->settings->get(design\Theme::SETTING_NAME));
        }
        
        $this->registerI18N();
        
        $this->runBootstraps($app);
    }
    
    private function registerI18N()
    {
        \Yii::$app->i18n->translations['t2cms'] = [
            'class'    => \yii\i18n\PhpMessageSource::class,
            'sourceLanguage' => 'en-US',
            'basePath' => __DIR__ . '/base/messages',
            'fileMap'  => [
                "t2cms" => "app.php",
                "t2cms/error" => "error.php", 
            ],
        ];
        
        \Yii::$app->language = 'ru-RU';
        
    }
    
    private function runBootstraps($app)
    {
        foreach($this->bootstraps as $bootstrapClass){
            $bootstrap = \Yii::createObject($bootstrapClass);
            $bootstrap->bootstrap($app);
        }
    }
}