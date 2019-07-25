<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%images}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%posts}}`
 */
class m190725_081600_create_images_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%images}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer()->notNUll(),
            'image' => $this->string(),
            'created_at' => $this->timestamp(),
        ]);

        // creates index for column `post_id`
        $this->createIndex(
            '{{%idx-images-post_id}}',
            '{{%images}}',
            'post_id'
        );

        // add foreign key for table `{{%posts}}`
        $this->addForeignKey(
            '{{%fk-images-post_id}}',
            '{{%images}}',
            'post_id',
            '{{%posts}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%posts}}`
        $this->dropForeignKey(
            '{{%fk-images-post_id}}',
            '{{%images}}'
        );

        // drops index for column `post_id`
        $this->dropIndex(
            '{{%idx-images-post_id}}',
            '{{%images}}'
        );

        $this->dropTable('{{%images}}');
    }
}
