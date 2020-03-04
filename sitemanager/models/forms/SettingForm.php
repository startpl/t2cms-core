<?php

namespace t2cms\sitemanager\models\forms;

use yii\base\Model;

/**
 * Setting create form
 */
class SettingForm extends Model
{    
    public $name;
    public $required;
    public $autoload;
    public $value;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['name', 'trim'],
            [['name', 'value'], 'required'],
            ['name', 'unique', 'targetClass' => 't2cms\sitemanager\models\Setting', 'message' => 'This name has already been taken.'],
            ['name', 'string', 'min' => 2, 'max' => 255],

            [['required', 'autoload'], 'boolean'],
        ];
    }
}
