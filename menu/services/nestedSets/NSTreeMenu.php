<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\menu\services\nestedSets;

use Yii;

/**
 * Description of NestedSetsTreeMenu
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 * @version 1.0
 */
class NSTreeMenu extends \startpl\yii2NestedSetsMenu\base\NestedSetsTree
{
    const ALLOW_ALWAYS = ['everyone', 'user'];

    /**
     * @var string
     */
    public $childrenOutAttribute = 'items'; //children

    /**
     * @var string
     */
    public $labelOutAttribute = 'label'; //title


    /**
     * Добавляет в массив дополнительные элементы
     * @param $node
     * @return array
     */
    public function addItem($node): array
    {
        $this->renameTitle($node); //переименование элемента массива
        $this->changeUrl($node);
        $this->visible($node); //видимость элементов меню
        $this->makeActive($node); //выделение активного пункта меню

        return $node;
    }
    
    protected function changeUrl(&$node){
        $node['url'] = \t2cms\menu\helpers\MenuUrl::to($node);
    }


    /**
     * Переименовываем элемент "name" в "label" (создаем label, удаляем name)
     * требуется для yii\widgets\Menu
     * @param $node
     * @return array
     */
    protected function renameTitle(&$node)
    {
        $img = $node['image']? \yii\helpers\Html::img($node['image'], ['alt' => $node['itemContent'][$this->labelAttribute]]) : '';
        $node[$this->labelOutAttribute] = $img . $node['itemContent'][$this->labelAttribute];
        unset($node['itemContent']);
    }


    /**
     * Видимость пункта меню (visible = false - скрыть элемент)
     * Проверяем только текущий пункт, а не все вверх по дереву.
     * Потому что если узел недоступен - дочерние пропускаются.
     * 
     * 
     * @param $node
     * @return array
     */
    protected function visible(&$node)
    {
        $node['visible'] = (bool)$node['status'] 
             && (in_array($node['access'], self::ALLOW_ALWAYS) || \Yii::$app->user->can($node['access']));
    }



    /**
     * Добавляет элемент "active" в массив с url соответствующим текущему запросу
     * для назначения отдельного класса активному пункту меню
     *
     * @param $node
     * @return array
     */
    private function makeActive(&$node)
    {
        $path = Yii::$app->request->pathInfo;
        if($path == $node['url']){
            $node['active'] = true;
        }
    }

}