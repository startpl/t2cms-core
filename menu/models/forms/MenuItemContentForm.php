<?php

namespace t2cms\menu\models\forms;

use yii\base\Model;

/**
 * Domain create form
 */
class MenuItemContentForm extends Model
{
    public $name;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name',], 'required'],
            [['name'], 'string', 'max' => 255]
        ];
    }
}
