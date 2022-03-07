<?php


namespace app\models;


class SearchRooms extends \yii\base\Model
{
    public $from;
    public $to;
    public $category;
    public $search = false;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['from', 'to', 'category', ], 'safe'],
        ];
    }

    /**
     * Подгрузка параметров
     */
    public function getParams()
    {
        $this->attributes = \Yii::$app->request->get('SearchRooms');
        if ($this->from || $this->to || $this->category) {
            $this->search = true;
        }
    }

    /**
     * Поиск по комнатам
     * @return array|null
     */
    public function search()
    {
        if ($this->search) {
            $fromTimestamp = strtotime($this->from);
            $toTimestamp = strtotime($this->to); // фикс брони на один день больше, чем надо
            return Room::find()->alias('room')
                ->select('category.name as room_name, activeRoomAggregateData.*')
                ->where(['room.category_id' => $this->category])
                ->innerJoinWith(['activeRoomAggregateData activeRoomAggregateData', 'category category'])
                //->with('activeRoomAggregateData')
                ->andWhere(['activeRoomAggregateData.from' => $fromTimestamp, 'activeRoomAggregateData.to' => $toTimestamp])
                //->limit(15)->offset(0)
                ->asArray()->all();
        } else {
            return null;
        }
    }
}