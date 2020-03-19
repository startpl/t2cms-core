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
            ['name', 'filter', 'filter'=>'strtolower'],
            ['name', 'match', 'pattern' => '/^[a-z0-9\_]+$/i'],
            [['name'], 'string', 'max' => 120]
        ];
    }
}
