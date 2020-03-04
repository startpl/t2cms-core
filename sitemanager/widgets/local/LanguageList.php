<?php

/**
 * @link https://github.com/startpl/t2cms
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/t2cms/blob/master/LICENSE
 */

namespace t2cms\sitemanager\widgets\local;

use yii\helpers\Html;
use yii\helpers\Url;


/**
 * Widget domains list, changes admin language for controll content
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class LanguageList extends \yii\base\Widget
{
    
    /**
     * @var array options of tag select
     */
    public $optionsList = ['class' => 'btn btn-default'];
    
    /**
     * @var array options for wrapper
     */
    public $options = ['class' => 'change-zone change-local-zone language'];
    
    /**
     * select t2cms\sitemanager\widgets\base\LanguageSelect
     */
    private $select;
    
    public function init()
    {
        parent::init();
        
        $this->initSelect();
    }

    public function run(): string
    {
        parent::run();
        $view = $this->getView();
        \t2cms\sitemanager\AssetBundle::register($view);
        
        return $this->renderList();
    }
    
    private function renderList(): string
    {
        $content  = Html::beginTag('div', $this->options);
        $content .= $this->select->render();
        $content .= Html::endTag('div');
        
        return $content;
    }
    
    private function initSelect(): void
    {
        $this->select = \Yii::createObject([
            'class'  => base\LanguageList::className(),
            'select' => $this
        ]);
    }
}
