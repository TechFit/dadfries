<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_product}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%product}}`
 * - `{{%order}}`
 */
class m190322_140933_create_order_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_product}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'order_id' => $this->integer()->notNull(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        // creates index for column `product_id`
        $this->createIndex(
            '{{%idx-order_product-product_id}}',
            '{{%order_product}}',
            'product_id'
        );

        // add foreign key for table `{{%product}}`
        $this->addForeignKey(
            '{{%fk-order_product-product_id}}',
            '{{%order_product}}',
            'product_id',
            '{{%product}}',
            'id',
            'CASCADE'
        );

        // creates index for column `order_id`
        $this->createIndex(
            '{{%idx-order_product-order_id}}',
            '{{%order_product}}',
            'order_id'
        );

        // add foreign key for table `{{%order}}`
        $this->addForeignKey(
            '{{%fk-order_product-order_id}}',
            '{{%order_product}}',
            'order_id',
            '{{%order}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%product}}`
        $this->dropForeignKey(
            '{{%fk-order_product-product_id}}',
            '{{%order_product}}'
        );

        // drops index for column `product_id`
        $this->dropIndex(
            '{{%idx-order_product-product_id}}',
            '{{%order_product}}'
        );

        // drops foreign key for table `{{%order}}`
        $this->dropForeignKey(
            '{{%fk-order_product-order_id}}',
            '{{%order_product}}'
        );

        // drops index for column `order_id`
        $this->dropIndex(
            '{{%idx-order_product-order_id}}',
            '{{%order_product}}'
        );

        $this->dropTable('{{%order_product}}');
    }
}
