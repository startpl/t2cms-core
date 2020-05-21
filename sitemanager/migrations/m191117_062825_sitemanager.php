<?php
use yii\db\Migration;
/**
 * Class m191117_062825_settings
 */
class m191117_062825_sitemanager extends Migration
{        
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
        return true;
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
        
        $settings = require (__DIR__ . DIRECTORY_SEPARATOR . '/settings.php');
        
        foreach($settings as $key => $value){
            $settingValue = $value['defaultValue'];
            unset($value['defaultValue']);
            $this->insert('{{%setting}}', $value);
            
            $settingID = $this->db->lastInsertID;
            $settingValue['src_id'] = $settingID;
            $this->insert('{{%setting_value}}', $settingValue);
        }
    }
}