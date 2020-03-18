<?php

namespace t2cms\menu\models\forms;

use yii\base\Model;

/**
 * Domain create form
 */
class MenuItemForm extends Model
{
    public $name;
    
    public $type;
    public $parent_id;
    
    public $data;

    public $status;
    public $target;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status', 'target'], 'boolean'],
            [['data'], 'string', 'max' => 255],
            [['type'], 'default', 'value' => \t2cms\menu\models\MenuItem::TYPE_URI]
        ];
    }
}
