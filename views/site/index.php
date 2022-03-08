<?php
/**
 * @var yii\web\View $this
 * @var \app\models\SearchRooms $searchModel
 * @var array|null $models
 */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;

$this->title = 'Главная';
$cats = ArrayHelper::map(\app\models\RoomCategory::find()->asArray()->all(), 'id', 'name');
?>
<div class="site-index">
    <?php $form = ActiveForm::begin([
        'id' => 'search-rooms',
        'method' => 'get',
        //'enableClientValidation' => false,
        'enableAjaxValidation' => false,
    ]);
    ?>
    <div class="">
        <?= $form->field($searchModel, 'from')->input('date', [
            'class' => 'form-control', 'required' => 'required', 'autocomplete' => 'off',
        ])->label('Дата с') ?>

        <?= $form->field($searchModel, 'to')->input('date', [
            'class' => 'form-control', 'required' => 'required', 'autocomplete' => 'off',
        ])->label('Дата по') ?>

        <?= $form->field($searchModel, 'category')->dropDownList($cats,
            ['prompt' => '', 'class' => 'form-control', 'autocomplete' => 'off',
        ])->label('Категория номера');
        ?>

        <?= Html::submitButton('Поиск', ['class' => 'btn btn-success']); ?>
    </div>
    <?php ActiveForm::end() ?>
    <div class="mt-4">
        <?php if ($models) { ?>
            <?php foreach ($models as $data) { ?>
                <div class="border rounded mb-2 row">
                    <div class="col-3">
                        <div>Номер № <?= $data['room_id'] ?></div>
                        <div><?= $data['room_name'] ?></div>
                        <?php if ($data['status'] == 0) { ?>
                            <a href="/booking/book?id=<?= $data['id']?>" class="btn btn-info">Забронировать</a>
                        <?php } ?>
                    </div>
                    <div class="col-9">
                        <table class="table table-striped table-hover table-bordered">
                            <tr><td>С</td><td><?= date('d.m.Y', $data['from']); ?></td></tr>
                            <tr><td>По</td><td><?= date('d.m.Y', $data['to']); ?></td></tr>
                            <tr><td>Цена</td><td><?= $data['price'] ?></td></tr>
                            <tr><td>Статус</td><td><?= $data['status'] == 0 ? 'Свободно' : 'Занято' ?></td></tr>
                        </table>
                    </div>
                </div>
            <?php }  ?>
        <?php } else if ($searchModel->search) { ?>
            Ничего не найдено
        <?php } ?>
    </div>
</div>
