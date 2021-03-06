<?php
/**
 * Teleport
 * Created: 28.01.16 14:07
 * @copyright Copyright (c) 2016 OSKR NIAEP
 */
use yii\helpers\Html;
use common\models\vks\Participant;

/**
 * @var $this \yii\web\View
 * @var $model \frontend\models\vks\Request
 */
$this->title = "Заявка на помещение";
\frontend\assets\AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=100">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div>

    <p style="font-size: 18px;"><?= $model->topic ?></p>

    <hr>

    <div style="font-size: 15px; display: inline-block">
        Время проведения <?= Yii::$app->formatter->asDate($model->date->toDateTime(), 'long') ?>
        c <?= $model->beginTimeString ?> до <?= $model->endTimeString ?>
    </div>

    <?php switch ($model->status) {
        case $model::STATUS_APPROVED:
            $statusCssClass = 'text-success';
            break;
        case $model::STATUS_CANCELED:
            $statusCssClass = 'text-danger';
            break;
    } ?>

    <p>Статус заявки: <b class="<?= $statusCssClass ?>"><?= $model->statusName ?></b></p>

    <?php if ($model->status === $model::STATUS_CANCELED): ?>

        <p class="text-danger" style="font-size: large"><?= $model->cancellationReason ?></p>

    <?php endif; ?>

    <p class="lead">Организатор</p>

    <dl class="dl-horizontal">
        <dt>Имя</dt>
        <dd><?= $model->owner->fullName ?></dd>
        <dt>Должность</dt>
        <dd><?= $model->owner->post ?></dd>
        <dt>Email</dt>
        <dd><?= $model->owner->email ?></dd>
        <dt>Контактный телефон</dt>
        <dd><?= $model->owner->phone ?></dd>
    </dl>

    <p>Совещание в режиме ВКС: <b><?= Yii::$app->formatter->asBoolean($model->mode === $model::MODE_WITH_VKS) ?></b></p>

    <?php if ($model->mode === $model::MODE_WITHOUT_VKS && is_array($model->equipment)): ?>

        <p><b>Дополнительное оборудование:</b> <?= implode(', ', $model->equipment) ?></p>

    <?php endif; ?>


    <p class="lead">Участники</p>

    <table class="table table-condensed">

        <tr>
            <th>#</th>
            <th>Название</th>
            <th>Организация</th>
            <th>Контактное лицо</th>
            <th>Контактный телефон</th>
            <th>Статус</th>

        </tr>
        <?php $counter = 1 ?>

        <tbody>

        <?php foreach ($model->participants as $participant): ?>

            <?php switch ($model->getRoomStatus($participant->_id)) {
                case Participant::STATUS_CONSIDIRATION:
                    $roomStatus = "На рассмотрении";
                    break;
                case Participant::STATUS_CANCEL:
                    $roomStatus = "Отменено";
                    break;
                default:
                    $roomStatus = "Согласовано";
                    break;
            } ?>

            <tr>
                <td><?= $counter ?></td>
                <td><?= $participant->name ?></td>
                <td><?= $participant->company->name ?></td>
                <td><?= $participant->contact ?></td>
                <td><?= $participant->phone ?></td>
                <td><?= $roomStatus ?></td>
            </tr>
            <?php $counter++ ?>
        <?php endforeach; ?>

        </tbody>

    </table>

    <?php if ($model->note): ?>

        <p><b style="font-size: 14px">Примечание</b><p><?= $model->note ?></p>

    <?php endif; ?>

    <p>Заявка подана <?= Yii::$app->formatter->asDatetime($model->createdAt->toDateTime(), 'long') ?></p>

</div>

<?php $this->registerJs('window.print()') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

