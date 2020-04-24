<?php
use yii\db\Migration;
/**
 * Class m191117_062825_settings
 */
class m191117_062825_sitemanager extends Migration
{
    const STATUS = [
        'GENERAL' => 0, 
        'MAIN'    => 1, 
        'CUSTOM'  => 2,
        'SYSTEM'  => 3
    ];
    
    
    private $settings = [
        [
            'name' => '_disconnected', 
            'required' => true,
            'autoload' => true,
            'status'   => self::STATUS['GENERAL']
        ],
        [
            'name' => 'disconnected',
            'required' => true,
            'autoload' => true,
            'status'   => self::STATUS['MAIN']
        ],
        [
            'name' => '_site_name',
            'required' => true,
            'autoload' => true,
            'status'   => self::STATUS['GENERAL']
        ],
        [
            'name' => 'site_name',
            'required' => true,
            'autoload' => true,
            'status'   => self::STATUS['MAIN']
        ],
        [
            'name' => 'home_page_type',
            'required' => true,
            'autoload' => false,
            'status' => self::STATUS['GENERAL']
        ],
        [
            'name' => 'home_page',
            'required' => true,
            'autoload' => false,
            'status' => self::STATUS['GENERAL']
        ],
        [
            'name' => 'design',
            'required' => true,
            'autoload' => true,
            'status' => self::STATUS['SYSTEM']
        ]
    ];
    
    private $settingsValues = [
        '_disconnected' => [
            'value' => 0,
            'domain_id' => null,
            'language_id' => null
        ],
        'disconnected' => [
            'value' => 0,
            'domain_id' => null,
            'language_id' => null
        ],
        '_site_name' => [
            'value' => 'New site',
            'domain_id' => null,
            'language_id' => null
        ],
        'site_name' => [
            'value' => 'New site',
            'domain_id' => null,
            'language_id' => null
        ],
        'home_page_type' => [
            'value' => 0,
            'domain_id' => null,
            'language_id' => null
        ],
        'home_page' => [
            'value' => 1,
            'domain_id' => null,
            'language_id' => null
        ],
        'design' => [
            'value' => 'default',
            'domain_id' => null,
            'language_id' => null
        ]
    ];
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%setting}}', [
            'id'         => $this->primaryKey(),
            'name'       => $this->string(100)->notNull()->unique(),
            'required'   => $this->boolean()->notNull(),
            'autoload'   => $this->boolean()->notNull(),
            'status'     => $this->tinyInteger(4)->notNull(),
        ]);
        
        $this->createTable('{{%domain}}', [
            'id'     => $this->primaryKey(),
            'name'   => $this->string(100)->notNull(),
            'domain' => $this->string(255)->notNull()->unique(),
            'is_default'   => $this->boolean()->notNull()
        ]);
        
        $this->createTable('{{%language}}', [
            'id'         => $this->primaryKey(),
            'code'       => $this->char(2)->notNull()->unique(),
            'code_local' => $this->string(32)->notNull()->unique(),
            'name'       => $this->string(100)->notNull(),
            'status'     => $this->tinyInteger(2)->notNull(),
            'is_default' => $this->boolean()->notNull()
        ]);
        
        $this->createTable('{{%setting_value}}', [
            'id'          => $this->primaryKey(),
            'src_id'      => $this->integer()->notNull(),
            'domain_id'   => $this->integer(),
            'language_id' => $this->integer(),
            'value'       => $this->text()
        ]);
        
        $this->addForeignKey('fk-setting-src_id', '{{%setting_value}}', 'src_id', '{{%setting}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-setting-domain_id', '{{%setting_value}}', 'domain_id', '{{%domain}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-setting-language_id', '{{%setting_value}}', 'language_id', '{{%language}}', 'id', 'CASCADE');

        $this->baseFill();
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191117_062825_sitemanager cannot be reverted.\n";
        return false;
    }
    
    private function baseFill()
    {
        
        $this->insert('{{%domain}}', [
            'domain'     => 'main',
            'name'       => 'Main',
            'is_default' => true
        ]);
        
        $this->insert('{{%language}}',[
            'code' => 'en', 
            'code_local' => 'en-US', 
            'name' => 'English', 
            'status' => 1, 
            'is_default' => true
        ]);
        
        $this->insert('{{%language}}',[
            'code' => 'ru', 
            'code_local' => 'ru-RU', 
            'name' => 'Russian', 
            'status' => 1, 
            'is_default' => false
        ]);
        
        
        foreach($this->settings as $key => $value){
            $this->insert('{{%setting}}', $value);
            
            $settingID = $this->db->lastInsertID;
            
            $tmp = $this->settingsValues[$value['name']];
            $tmp['src_id'] = $settingID;
            $this->insert('{{%setting_value}}', $tmp);
        }
    }
}