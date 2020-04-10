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
    public function bootstrap($app) 
    {
        \Yii::setAlias('@modules', '@app/../cms/modules');
        if(!$app->request->isConsoleRequest){
            \Yii::setAlias('@themes', '@app/../cms/themes');
            \Yii::setAlias('@theme', '@themes/'.$app->settings->get(design\Theme::SETTING_NAME));
        }
    }
}
