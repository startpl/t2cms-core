<?php

namespace t2cms\menu\models\forms;

use yii\base\Model;

/**
 * Domain create form
 */
class MenuForm extends Model
{
    public $name;
    public $title;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'title'], 'required'],
            [['name', 'title'], 'string', 'max' => 120],
            ['name', 'unique', 'targetClass' => 't2cms\menu\models\Menu', 'message' => 'The Menu with that name already exists.'],
        ];
    }
}
