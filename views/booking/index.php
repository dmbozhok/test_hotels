<?php
/**
 * @var yii\web\View $this
 * @var \app\models\Booking[] $bookings
 */
?>

<div>
    <?php if ($bookings) { ?>
        <table class="table table-striped table-hover table-bordered">
            <tr>
                <th>id брони</th>
                <th>id номера</th>
                <th>Клиент</th>
                <th>Даты заезда</th>
                <th>Забронировано</th>
            </tr>
            <?php foreach ($bookings as $booking) { ?>
                <tr>
                    <td><?= $booking->id ?></td>
                    <td><?= $booking->room_id ?></td>
                    <td><?= $booking->name ?><br><?= $booking->email ?></td>
                    <td><?= date('d.m.Y', $booking->roomData->from) ?> - <?= date('d.m.Y', $booking->roomData->to) ?></td>
                    <td><?= date('d.m.Y H:i:s', $booking->time) ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        Бронирований нет
    <?php } ?>
</div>

