<?php
/**
 * @var $this \yii\web\View
 * @var $bookings \app\models\RoomAggregateData
 * @var $booked bool|false
 */

?>

<div class="">
    <?php if ($booked === true) { ?>
        <div class="alert alert-success" role="alert">Бронирование добавлено!</div>
    <?php } elseif ($booked === false) { ?>
        <div class="alert alert-danger" role="alert">Ошибка при добавлении бронирования!</div>
    <?php } ?>
</div>
