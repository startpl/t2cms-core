<?php

namespace t2cms\module\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%module}}".
 *
 * @property int $id
 * @property string $url
 * @property string $path
 * @property string|null $version
 * @property int|null $status
 * @property int $show_in_menu
 * @property string $created_at
 * @property string $updated_at
 */
class Module extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 0;
    
    const STATUS_INSTALL   = 1;
    const STATUS_UNINSTALL = 5;
    
    const STATUS_ACTIVE    = 2;
    const STATUS_INACTIVE  = 3;
            
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%module}}';
    }
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public static function find()
    {
        return new ModuleQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'path', 'show_in_menu'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['url'], 'string', 'max' => 100],
            [['show_in_menu'], 'boolean'],
            [['path'], 'string', 'max' => 255],
            [['version'], 'string', 'max' => 20],
            [['url', 'path'], 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'url' => Yii::t('app', 'Url'),
            'path' => Yii::t('app', 'Path'),
            'version' => Yii::t('app', 'Version'),
            'status' => Yii::t('app', 'Status'),
            'show_in_menu' => Yii::t('app', 'Show in menu'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public static function getStatuses(): array
    {
        return [
            self::STATUS_NEW => \Yii::t('app', 'Not installed'),
            self::STATUS_INSTALL => \Yii::t('app', 'Installed'),
            self::STATUS_ACTIVE  => \Yii::t('app', 'Active'),
            self::STATUS_INACTIVE => \Yii::t('app', 'Inactive'),
            self::STATUS_UNINSTALL => \Yii::t('app', 'Uninstalled')
        ];
    }
}
