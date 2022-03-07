<?php

namespace app\controllers;

use app\models\Booking;
use app\models\RoomAggregateData;
use app\models\SearchRooms;
use yii\web\HttpException;

class BookingController extends \yii\web\Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $bookings = Booking::find()->all();
        return $this->render('index', ['bookings' => $bookings]);
    }

    /**
     * @return string
     * @throws HttpException
     */
    public function actionBook()
    {
        $bookTo = RoomAggregateData::findOne(['id' => (int)\Yii::$app->request->get('id')]);
        if (!$bookTo) {
            throw new HttpException(404, 'Не найдено');
        }
        $booked = null;
        if (\Yii::$app->request->isPost) {
            $booked = $bookTo->book(\Yii::$app->request->post('Booking'));
        }

        return $this->render('book', ['booking' => $bookTo, 'booked' => $booked]);
    }
}