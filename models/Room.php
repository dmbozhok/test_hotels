<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%room}}".
 *
 * @property int $id
 * @property int|null $category_id
 *
 * @property RoomCategory $category
 * @property RoomData[] $roomData
 * @property RoomAggregateData[] $activeRoomAggregateData
 * @property Booking[] $bookings
 */
class Room extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%room}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => RoomCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(RoomCategory::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[RoomDatas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoomData()
    {
        return $this->hasMany(RoomData::className(), ['room_id' => 'id']);
    }

    /**
     * Связь для получения данных по доступным бронированиям
     * @return \yii\db\ActiveQuery
     */
    public function getActiveRoomAggregateData()
    {
        return $this->hasMany(RoomAggregateData::className(), ['room_id' => 'id'])->alias('activeRoomAggregateData')->andOnCondition(['status' => 0]);
    }

    /**
     * Gets query for [[Bookings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookings()
    {
        return $this->hasMany(Booking::className(), ['room_id' => 'id']);
    }

    /**
     * Вытаскивает из массива ключи между определенными числами
     * @param $array
     * @param $startTime
     * @param $tillTime
     * @return array
     */
    public static function getMiddlePartOfArray($array, $startTime, $tillTime)
    {
        $return = [];
        asort($array);
        foreach ($array as $key => $value) {
            if ($startTime >= $key && $key <= $tillTime) {
                $return[$key] = $value;
            }
        }
        return $return;
    }

    /**
     * Создание данных по занятости
     */
    public function calculateFullAggregateData()
    {
        $data = [];
        $cols = ['room_id', 'from', 'to', 'price', 'status'];
        RoomAggregateData::deleteAll(['room_id' => $this->id]);
        if ($this->roomData) {
            $insert = [];
            foreach ($this->roomData as $roomData) {
                $data[$roomData->date] = $roomData->toArray();
            }
            $today = (new \DateTime())->modify('midnight')->format('U');
            for ($date = 0; $date < 30; $date++) {
                $from = (int)$today + $date * 86400;
                for ($diff = 0; $diff < 31; $diff++) {
                    $to = $from + $diff * 86400;
                    $rooms = self::getMiddlePartOfArray($data, $from, $to);
                    $insert[] = [
                        $this->id,
                        $from,
                        $to,
                        array_sum(ArrayHelper::getColumn($rooms, 'price')),
                        array_sum(ArrayHelper::getColumn($rooms, 'status')) == 0 ? 0 : 1,
                    ];
                }
            }
            return \Yii::$app->db->createCommand()->batchInsert(
                'room_aggregate_data',
                $cols,
                $insert
            )->execute();
        }

        return 0;
    }

    /**
     * Обновление данных по бронированию по датам
     * @param $from
     * @param $to
     */
    public function setDataBookingStatus($from, $to)
    {
        $from = (int)$from;
        $to = (int)$to;
        RoomData::updateAll(['status' => 1], ['and', ['room_id' => $this->id], ['between', 'date', $from, $to - 86400]]);
        RoomAggregateData::updateAll(['status' => 1], "room_id = {$this->id} AND `from` < $to AND `to` > $from");
    }
}
