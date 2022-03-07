<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%room_aggregate_data}}".
 *
 * @property int $id
 * @property int|null $room_id
 * @property int|null $from
 * @property int|null $to
 * @property int|null $price
 * @property int|null $status 0 - свободно, 1 - занято
 *
 * @property Room $room
 */
class RoomAggregateData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%room_aggregate_data}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['room_id', 'from', 'to', 'price', 'status'], 'integer'],
            [['room_id'], 'exist', 'skipOnError' => true, 'targetClass' => Room::className(), 'targetAttribute' => ['room_id' => 'id']],
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
            'from' => 'From',
            'to' => 'To',
            'price' => 'Price',
            'status' => '0 - свободно, 1 - занято',
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
     * Бронирование записи
     * @return bool
     */
    public function book($data)
    {
        if ($this->status == 1) {
            return false;
        }
        $this->status = 1;
        if ($this->save()) {
            $this->room->setDataBookingStatus($this->from, $this->to);
            $booking = new Booking([
                'name' => $data['name'] ?? '',
                'email' => $data['email'] ?? '',
                'room_id' => $this->room_id,
                'room_data_id' => $this->id,
                'time' => time(),
                'status' => 1,
            ]);
            $booking->save();
            return true;
        } else {
            Yii::warning($this->errors);
            return false;
        }
    }
}
