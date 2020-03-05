<?php

/**
 * AssetBundle.php
 * @author Koperdog <koperdog.dev@gmail.com>
 */

namespace t2cms\blog;

/**
 * Class AssetBundle
 */
class AssetBundle extends \yii\web\AssetBundle
{
    /**
     * @inherit
     */
    public $sourcePath = __DIR__. '/assets';
    
    /**
     * @inherit
     */
    public $css = [
        'css/blog.css',
    ];
    
    /**
     * @inherit
     */
    public $js = [
        'js/blog.js',
    ];
    
    /**
     * @inherit
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\jui\JuiAsset'
    ];
}
