<?php

/**
 * @link https://github.com/t2cms/t2cms-core
 * @copyright Copyright (c) 2020 Koperdog
 * @license https://github.com/startpl/t2cms-core/blob/master/LICENSE
 */

namespace t2cms\acf;

/**
 * Advanced Custom Fields module
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class Module extends \yii\base\Module
{
    const MODULE_NAME = "acf";
    
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 't2cms\acf\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }
}
