<?php

use yii\db\Migration;

/**
 * Handles dropping post_image from table `{{%posts}}`.
 */
class m190725_083424_drop_post_image_column_from_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%posts}}', 'post_image');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%posts}}', 'post_image', $this->string());
    }
}
