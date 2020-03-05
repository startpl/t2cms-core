<?php

namespace t2cms\blog\models\forms;

use yii\base\Model;
use t2cms\blog\models\{
    Category
};

/**
 * Setting create form
 */
class CategoryContentForm extends Model
{        
    public $name;
    public $category_id;
    public $h1;
    public $image;
    public $preview_text;
    public $full_text;
    
    public $language_id;
    public $domain_id;

    public $title;
    public $keywords;
    public $description;
    public $og_title;
    public $og_description;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'h1', 'image', 'preview_text', 'full_text', 'title', 'og_title', 'keywords', 'description', 'og_description'], 'required'],
            [['category_id', 'language_id'], 'integer'],
            [['preview_text', 'full_text', 'description', 'og_description'], 'string'],
            [['name', 'h1', 'image', 'title', 'og_title', 'keywords'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            
            
        ];
    }
        
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'category_id' => \Yii::t('app', 'Category ID'),
            'name' => \Yii::t('app', 'Name'),
            'h1' => \Yii::t('app', 'H1'),
            'image' => \Yii::t('app', 'Image'),
            'preview_text' => \Yii::t('app', 'Preview Text'),
            'full_text' => \Yii::t('app', 'Full Text'),
            'title' => \Yii::t('app', 'Title'),
            'og_title' => \Yii::t('app', 'Og Title'),
            'keywords' => \Yii::t('app', 'Keywords'),
            'description' => \Yii::t('app', 'Description'),
            'og_description' => \Yii::t('app', 'Og Description'),
        ];
    }
}
