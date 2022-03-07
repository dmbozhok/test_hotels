<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking}}`.
 */
class m220307_171440_create_booking_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking}}', [
            'id' => $this->primaryKey(),
            'room_id' => $this->integer(),
            'room_data_id' => $this->integer(),
            'time' => $this->integer(),
            'name' => $this->string(),
            'email' => $this->string(),
            'status' => $this->tinyInteger()->defaultValue(1)->comment('1 - забронировано'),
        ]);

        $this->addForeignKey(
            'fk_booking_room',
            '{{%booking}}',
            'room_id',
            '{{%room}}',
            'id'
        );

        $this->addForeignKey(
            'fk_booking_room_aggregate_data',
            '{{%booking}}',
            'room_data_id',
            '{{%room_aggregate_data}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk_booking_room',
            '{{%booking}}');
        $this->dropForeignKey(
            'fk_booking_room_aggregate_data',
            '{{%booking}}');
        $this->dropTable('{{%booking}}');
    }
}
