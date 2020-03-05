<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace t2cms\blog\components\url;

use t2cms\blog\repositories\CategoryRepository;
use yii\helpers\ArrayHelper;
use t2cms\blog\models\Category;

/**
 * Description of CategoryUrl
 *
 * @author Koperdog <koperdog@github.com>
 * @version 1.0
 */
class CategoryUrl extends Url {
    
    protected $routeName = 'category_route';
    
    protected $urlPath   = 'blog/categories/view';
    
    public function __construct(CategoryRepository $repository, $config = [])
    {
        parent::__construct($config);
        
        $this->repository = $repository;
    }
    
    protected function getPath($category): string
    {
        $sections = ArrayHelper::getColumn($category->parents()->andWhere(['>=', 'depth', Category::OFFSET_ROOT])->all(), 'url');
        $sections[] = $category->url;
        return implode('/', $sections);
    }
    
    protected function isActive(Category $model): bool
    {
        $sections   = $model->parents()->andWhere(['>=', 'depth', Category::OFFSET_ROOT])->all();
        $sections[] = $model;
        
        foreach($sections as $category){
            if($category->status != Category::STATUS['PUBLISHED'] || strtotime($category->publish_at) > time()){
                return false;
            }
        }
                
        return true;
    }
}
