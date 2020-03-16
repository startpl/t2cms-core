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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['data'], 'string', 'max' => 255],
            [['type'], 'default', 'value' => \t2cms\menu\MenuItems::TYPE_URI]
        ];
    }
}
