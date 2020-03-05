<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\blog\components\url;

use yii\base\InvalidParamException;

/**
 *
 * @author Koperdog <koperdog@github.com>
 */
abstract class Url extends \yii\base\BaseObject{
    
    protected $routeName = "route";
    protected $urlPath   = 'blog/index';
    
    protected $repository;
    
    public $owner;
    
    public function createUrl($params): string
    {
        if (empty($params['id'])) throw new InvalidParamException('Empty id.');
        $id = $params['id'];

        $url = \Yii::$app->cache->getOrSet([$this->routeName, 'id' => $id], function() use ($id) {
            if (!$model = $this->repository->get($id)) {
                return null;
            }
            return $this->getPath($model);
        });

        if (!$url) {
            throw new InvalidParamException('Undefined id.');
        }

        $url = $this->owner->prefix . '/' . $url;

        unset($params['id']);
        if (!empty($params) && ($query = http_build_query($params)) !== '') {
            $url .= '?' . $query;
        }
        return $url;
    }
    
    public function parseRequest($path)
    {
        $result = \Yii::$app->cache->getOrSet([$this->routeName, 'path' => $path], function () use ($path) {

            if (!$model = $this->repository->getByPath($path)) {
                return ['id' => null, 'path' => null];
            }
            
            if(!$this->isActive($model)) return false;
            
            return ['id' => $model->id];
        });

        if (empty($result['id'])) {
            return false;
        }

        return [$this->urlPath, ['id' => $result['id']]];
    }
    
    abstract protected function getPath($model): string;
}
