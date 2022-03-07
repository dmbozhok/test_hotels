<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%room_category}}`.
 */
class m220307_122758_create_room_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%room_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%room_category}}');
    }
}
