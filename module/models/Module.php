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
 * @property string $settings
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
    public function rules()
    {
        return [
            [['url', 'path', 'settings'], 'required'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['url'], 'string', 'max' => 100],
            [['path', 'settings'], 'string', 'max' => 255],
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
            'settings' => Yii::t('app', 'Settings'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
