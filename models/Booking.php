<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%booking}}".
 *
 * @property int $id
 * @property int|null $room_id
 * @property int|null $room_data_id
 * @property int|null $time
 * @property string|null $name
 * @property string|null $email
 * @property int|null $status 1 - забронировано
 *
 * @property Room $room
 * @property RoomAggregateData $roomData
 */
class Booking extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%booking}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['room_id', 'room_data_id', 'time', 'status'], 'integer'],
            [['name', 'email'], 'string', 'max' => 255],
            [['room_id'], 'exist', 'skipOnError' => true, 'targetClass' => Room::className(), 'targetAttribute' => ['room_id' => 'id']],
            [['room_data_id'], 'exist', 'skipOnError' => true, 'targetClass' => RoomAggregateData::className(), 'targetAttribute' => ['room_data_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'room_id' => 'Room ID',
            'room_data_id' => 'Room Data ID',
            'time' => 'Time',
            'name' => 'Name',
            'email' => 'Email',
            'status' => '1 - забронировано',
        ];
    }

    /**
     * Gets query for [[Room]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoom()
    {
        return $this->hasOne(Room::className(), ['id' => 'room_id']);
    }

    /**
     * Gets query for [[RoomData]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoomData()
    {
        return $this->hasOne(RoomAggregateData::className(), ['id' => 'room_data_id']);
    }
}
