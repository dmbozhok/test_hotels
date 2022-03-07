<?php
/**
 * @var $this \yii\web\View
 * @var $booking \app\models\RoomAggregateData
 * @var $booked bool|null
 */

use app\models\Booking;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

?>

<div>
    <?php if ($booked === true) { ?>
        <div class="alert alert-success" role="alert">
            Забронировано успешно
        </div>
        <a href="/booking">Все бронирования</a>
    <?php } elseif ($booked === false) { ?>
        <div class="alert alert-success" role="alert">
            Ошибка при бронировании
        </div>
        <a href="/booking">Все бронирования</a>
    <?php } else { ?>
        <?php $form = ActiveForm::begin([
            'id' => 'search-rooms',
            'method' => 'post',
            //'enableClientValidation' => false,
            'enableAjaxValidation' => false,
        ]);
        $book = new Booking();
        ?>

        <?= $form->field($book, 'name')->textInput(['class' => 'form-control'])->label('Имя') ?>

        <?= $form->field($book, 'email')->input('email', ['class' => 'form-control'])->label('Email') ?>

        <?= Html::submitButton('Забронировать', ['class' => 'btn btn-success']); ?>

        <?php ActiveForm::end() ?>
    <?php } ?>
</div>
