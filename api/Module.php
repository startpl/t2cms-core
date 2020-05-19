<?php

/**
 * @link https://github.com/startpl/t2cms-core
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/t2cms-core/sitemanager/blob/master/LICENSE
 */

namespace t2cms\api;

/**
 * Module public API
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class Module extends \yii\base\Module
{
    const MODULE_NAME = "api";
    
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 't2cms\api\controllers';

}
