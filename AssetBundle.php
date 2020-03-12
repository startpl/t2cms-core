<?php

namespace t2cms;

/**
 * T2CMS Asset bundle
 * @since 0.1
 */
class AssetBundle extends \yii\web\AssetBundle
{
    public $depends = [
        'rmrevin\yii\fontawesome\AssetBundle',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

}
