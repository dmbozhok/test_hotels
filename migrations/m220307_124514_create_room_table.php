<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%room}}`.
 */
class m220307_124514_create_room_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%room}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk_room_category',
            '{{%room}}',
            'category_id',
            '{{%room_category}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk_room_category',
            '{{%room}}'
        );
        $this->dropTable('{{%room}}');
    }
}
