<?php

/**
 * @link https://github.com/t2cms/sitemanager
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/t2cms-core/sitemanager/blob/master/LICENSE
 */

namespace t2cms\sitemanager\widgets\local;

use yii\helpers\Html;

/**
 * Widget domains list, changes admin domain for controll content
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class DomainList extends \yii\base\Widget
{
    
    /**
     * @var array options of tag select
     */
    public $optionsList = ['class' => 'btn btn-default'];
    
    /**
     * @var array options for wrapper
     */
    public $options = ['class' => 'change-zone change-local-zone domain'];
    
    /**
     * select t2cms\sitemanager\widgets\base\DomainSelect
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
            'class'  => base\DomainList::className(),
            'select' => $this
        ]);
    }
}
