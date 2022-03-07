<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%room_data}}`.
 */
class m220307_125216_create_room_data_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%room_data}}', [
            'id' => $this->primaryKey(),
            'room_id' => $this->integer(),
            'status' => $this->tinyInteger()->defaultValue(0)->comment('0 - свободно, 1 - занято'),
            'price' => $this->integer()->defaultValue(0),
            'date' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk_room_data_room',
            '{{%room_data}}',
            'room_id',
            '{{%room}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk_room_data_room',
            '{{%room_data}}');
        $this->dropTable('{{%room_data}}');
    }
}
