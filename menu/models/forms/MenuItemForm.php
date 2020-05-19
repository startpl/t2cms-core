<?php

namespace t2cms\menu\models\forms;

use yii\base\Model;

/**
 * Domain create form
 */
class MenuItemForm extends Model
{
    public $type;
    public $parent_id;
    
    public $data;

    public $status;
    public $target;
    
    public $image;
    public $access;
    public $render_js;
    
    public $itemContent;
    
    public function __construct($config = array()) {
        parent::__construct($config);
        
        $this->itemContent = new MenuItemContentForm();
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['status', 'target', 'render_js'], 'boolean'],
            [['data', 'access', 'image'], 'string', 'max' => 255],
            [['type'], 'default', 'value' => \t2cms\menu\models\MenuItem::TYPE_URI]
        ];
    }
}
