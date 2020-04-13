<?php

/**
 * @link https://github.com/t2cms/sitemanager
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/t2cms-core/sitemanager/blob/master/LICENSE
 */

namespace t2cms\module\widgets;

use yii\helpers\Html;
use t2cms\module\models\Module;

/**
 * Widget domains list, changes admin language for controll content
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class ModuleActions extends \yii\base\Widget
{
    public $id;
    public $model;
    public $buttonText = '<i class="fa fa-bars"></i>';
    
    public function init() {
        parent::init();
    }

    public function run(): string
    {
        parent::run();
        
        return $this->renderDropdown();
    }
    
    private function renderDropdown(): string
    {
        $dropdown  = Html::beginTag('div', ['class' => 'dropdown']);
        $dropdown .= Html::button($this->buttonText, [
            'class' => 'btn btn-default dropdown-toggle',
            'id' => $this->id,
            'data' => [
                    'toggle' => 'dropdown'
                ]
            ]);
        $dropdown .= $this->renderItems();
        $dropdown .= Html::endTag('div');
        
        return $dropdown;
    }
    
    private function renderItems(): string
    {
        return Html::ul($this->getItems(), [
            'item' => [$this, 'renderItem'],
            'encode' => false,
            'class' => 'dropdown-menu'
            ]);
    }
    
    private function getItems(): array
    {
        $result  = [];
        $actions = $this->getActions();
        
        foreach($actions as $action){
            
            if($action['type'] == 'separator'){
                $result[] = $action;
                continue;
            }
            
            $result[] = Html::a($action['anchor'], $action['href'], [
                'data' => [
                    'pjax' => true,
                    'confirm' => \Yii::t('app', '{action} this Module?', ['action' => $action['anchor']])
                ]
            ]);
        }
        
        return $result;       
    }
    
    private function getActions(): array
    {
        $actions = [];
        switch($this->model->status){
            case Module::STATUS_NEW:
                $actions[] = ['anchor' => \Yii::t('app', 'Install'), 'href' => ['install', 'path' => $this->model->path]];
                break;
            case Module::STATUS_INSTALL:
            case Module::STATUS_INACTIVE:
                $actions[] = ['anchor' => \Yii::t('app', 'Activate'), 'href' => ['activate', 'path' => $this->model->path]];
                $actions[] = ['anchor' => \Yii::t('app', 'Uninstall'), 'href' => ['uninstall', 'path' => $this->model->path]];
                break;
            case Module::STATUS_ACTIVE:
                $actions[] = ['anchor' => \Yii::t('app', 'Deactivate'), 'href' => ['deactivate', 'path' => $this->model->path]];
                break;
            default:
                $actions[] = ['anchor' => \Yii::t('app', 'Install'), 'href' => ['install', 'path' => $this->model->path]];
        }
        
        if($this->model->currentVersion < $this->model->version 
            && $this->model->status == Module::STATUS_ACTIVE){
            $actions[] = ['type' => 'separator'];
            $actions[] = ['anchor' => \Yii::t('app', 'Update'), 'href' => ['update', 'path' => $this->model->path]];
        }
        
        return $actions;
    }
    
    public function renderItem($item, $index): string
    {
        $options = [];
        
        if(isset($item['type'])){
            $options = [
                'role' => 'separator',
                'class' => 'divider'
            ];
        }
        
        return Html::tag('li', isset($item['type']) === false? $item : '' , $options);
    }
}
