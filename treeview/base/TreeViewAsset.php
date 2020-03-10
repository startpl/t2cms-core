<?php

/**
 * @link https://github.com/koperdog/yii2-treeview
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/koperdog/yii2-treeview/blob/master/LICENSE
 */

namespace t2cms\treeview\base;

use yii\web\AssetBundle;

/**
 * This asset bundle provides the javascript files for the [[TreeView]] widget.
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 * @version 1.0.0
 */
class TreeViewAsset extends AssetBundle
{
    public $sourcePath = '@vendor/startpl/t2cms/treeview/assets';
    
    public $css = [
        'css/treeview.css',
    ];
    
    public $js = [
        'js/yii.gridView.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
