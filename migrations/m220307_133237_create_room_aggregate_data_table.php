<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%room_aggregate_data}}`.
 */
class m220307_133237_create_room_aggregate_data_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%room_aggregate_data}}', [
            'id' => $this->primaryKey(),
            'room_id' => $this->integer(),
            'from' => $this->integer(),
            'to' => $this->integer(),
            'price' => $this->integer(),
            'status' => $this->integer()->defaultValue(0)->comment('0 - свободно, 1 - занято'),
        ]);

        $this->addForeignKey(
            'fk_room_aggregate_data_room',
            '{{%room_aggregate_data}}',
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
            'fk_room_aggregate_data_room',
            '{{%room_aggregate_data}}');
        $this->dropTable('{{%room_aggregate_data}}');
    }
}
