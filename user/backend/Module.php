<?php

/**
 * @link https://github.com/startpl/t2cms-core
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/t2cms-core/sitemanager/blob/master/LICENSE
 */

namespace t2cms\user\backend;

/**
 * Module
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class Module extends \yii\base\Module
{
    const MODULE_NAME = "user";
    
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 't2cms\user\backend\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        
        $this->registerTranslations();
    }
    
    private function registerTranslations()
    {
        if (!isset(\Yii::$app->i18n->translations[self::MODULE_NAME . '*'])) {
            
            \Yii::$app->i18n->translations[self::MODULE_NAME . '*'] = [
                'class'    => \yii\i18n\PhpMessageSource::class,
                'sourceLanguage' => 'en-US',
                'basePath' => __DIR__ . '/messages',
                'fileMap'  => [
                    self::MODULE_NAME . "/error" => "error.php", 
                ],
            ];
        }
    }
}
