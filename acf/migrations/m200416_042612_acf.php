<?php

use yii\db\Migration;

/**
 * Class m200416_042612_acf
 */
class m200416_042612_acf extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%acf_group}}', [
            'id'   => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'description' => $this->string(255)
        ]);
        
        $this->createTable('{{%acf_field}}', [
            'id'       => $this->primaryKey(),
            'name'     => $this->string(100)->notNull(),
            'type'     => $this->integer(2)->notNull(),
            'group_id' => $this->integer()->notNull(),
            'data'     => $this->text()
        ]);
        
        $this->createTable('{{%acf_field_value}}', [
            'id'          => $this->primaryKey(),
            'field_id'    => $this->integer()->notNull(),
            'value'       => $this->text(),
            'src_type'    => $this->string(50)->notNull(),
            'src_id'      => $this->integer()->notNull(),
            'domain_id'   => $this->integer(),
            'language_id' => $this->integer()
        ]);
        
        $this->addForeignKey('fk-acf_field-group_id', '{{%acf_field}}', 'group_id', '{{%acf_group}}', 'id', 'CASCADE');
        
        $this->addForeignKey('fk-acf_field_value-field_id', '{{%acf_field_value}}', 'field_id', '{{%acf_field}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-acf_field_value-domain_id', '{{%acf_field_value}}', 'domain_id', '{{%domain}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-acf_field_value-language_id', '{{%acf_field_value}}', 'language_id', '{{%language}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%acf_field_value}}');
        $this->dropTable('{{%acf_field}}');
        $this->dropTable('{{%acf_group}}');
        
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200416_042612_acf cannot be reverted.\n";

        return false;
    }
    */
}
