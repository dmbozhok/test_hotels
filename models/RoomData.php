<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%room_data}}".
 *
 * @property int $id
 * @property int|null $room_id
 * @property int|null $status 0 - свободно, 1 - занято
 * @property int|null $price
 * @property int|null $date
 *
 * @property Room $room
 */
class RoomData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%room_data}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['room_id', 'status', 'price', 'date'], 'integer'],
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
            'status' => '0 - свободно, 1 - занято',
            'price' => 'Price',
            'date' => 'Date',
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
}
