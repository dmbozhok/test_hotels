<?php


namespace app\commands;


use app\models\Room;
use app\models\RoomAggregateData;
use app\models\RoomCategory;
use app\models\RoomData;

/**
 * Class DatabaseController - манипуляции с БД
 * @package app\commands
 */
class DatabaseController extends \yii\console\Controller
{
    /**
     * Создает определенное кол-во комнат каждого вида (ничего не удаляет)
     */
    public function actionAddRooms()
    {
        $data = [
            'Одноместный' => 2,
            'Двуместный' => 4,
            'Люкс' => 3,
            'Де-Люкс' => 5,
        ];
        foreach ($data as $name => $count) {
            $cat = RoomCategory::findOne(['name' => $name]);
            if (!$cat) {
                $cat = new RoomCategory(['name' => $name]);
                $cat->save();
            }
            $existedCount = Room::find()->where(['category_id' => $cat->id])->count();
            if ($existedCount < $count) {
                for ($i = $existedCount; $i < $count; $i++) {
                    $room = new Room(['category_id' => $cat->id]);
                    $room->save();
                }
            }
        }
    }

    /**
     * @throws \yii\db\Exception
     */
    public function actionAddRoomData()
    {
        RoomData::deleteAll();
        $insert = [];
        $rooms = Room::find()->all();
        if ($rooms) {
            foreach ($rooms as $room) {
                /**
                 * @var $room Room
                 */
                $today = new \DateTimeImmutable('midnight');
                for ($i = 0; $i < 31; $i++) {
                    $insert[] = [$room->id, 0, 100, $today->modify("+$i days")->format('U')];
                }
            }
        }
        if ($insert) {
            echo \Yii::$app->db->createCommand()->batchInsert(
                    'room_data',
                    ['room_id', 'status', 'price', 'date'],
                    $insert
                )->execute() . ' rows was inserted' . PHP_EOL;
        }
    }

    /**
     *
     */
    public function actionAddRoomAggregateData()
    {
        $rooms = Room::find()->all();
        if ($rooms) {
            RoomAggregateData::deleteAll();
            foreach ($rooms as $room) {
                /**
                 * @var $room Room
                 */
                echo('Room - ' . $room->id . ' - was inserted ' . $room->calculateFullAggregateData() . ' records' . PHP_EOL);
            }
        }
    }
}