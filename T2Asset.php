<?php

namespace t2cms;

/**
 * T2CMS Asset bundle
 * @since 0.1
 */
class T2Asset extends \yii\web\AssetBundle
{
    /**
     * @inherit
     */
    public $sourcePath = __DIR__. '/base/assets';
    
    /**
     * @inherit
     */
    public $css = [
        'css/style.css',
    ];
    
    /**
     * @inherit
     */
    public $js = [
        //'js/script.js',
    ];
    
    public $depends = [
        'rmrevin\yii\fontawesome\AssetBundle',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

}
