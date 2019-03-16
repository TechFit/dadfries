<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m190315_132122_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'type' => $this->smallInteger()->notNull(),
            'title' => $this->string(255)->notNull()->unique(),
            'description' => $this->string(1024)->null(),
            'price' => $this->integer()->notNull(),
            'photo_base_url' => $this->string()->null(),
            'photo_path' => $this->string()->null(),
            'status' => $this->smallInteger()->defaultValue(10),
            'created_at' => $this->integer()->null(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product}}');
    }
}
