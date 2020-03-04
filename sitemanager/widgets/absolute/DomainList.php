<?php

/**
 * @link https://github.com/startpl/t2cms
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/t2cms/blob/master/LICENSE
 */

namespace t2cms\sitemanager\widgets\absolute;

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Widget domains list, changes admin domain for controll content
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class DomainList extends \yii\base\Widget
{
    /**
     * @var array|string Link controller change domain
     */
    public $link = ['/manager/ajax/change-domain'];
    
    /**
     * @var array options of tag select
     */
    public $optionsList = ['class' => 'btn btn-default'];
    
    /**
     * @var array options for wrapper
     */
    public $options = ['class' => 'change-zone domain'];
    
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
        
        $view->registerJsVar('urlDomainChange', Url::to($this->link));
        
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
