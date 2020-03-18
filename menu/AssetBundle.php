<?php

namespace t2cms\menu;

/**
 * T2CMS Asset bundle
 * @since 0.1
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
        'css/menu.css',
    ];
    
    /**
     * @inherit
     */
    public $js = [
        'js/menu.js',
    ];
    
    public $depends = [
        't2cms\AssetBundle',
    ];

}
