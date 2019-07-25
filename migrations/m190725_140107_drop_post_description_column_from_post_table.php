<?php

use yii\db\Migration;

/**
 * Handles dropping post_description from table `{{%post}}`.
 */
class m190725_140107_drop_post_description_column_from_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%posts}}', 'post_description');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%posts}}', 'post_description', $this->string(300));
    }
}
