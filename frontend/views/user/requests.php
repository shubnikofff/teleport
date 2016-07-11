<?php
/**
 * teleport
 * Created: 05.12.15 10:02
 * @copyright Copyright (c) 2015 OSKR NIAEP
 */
use kartik\helpers\Html;
use frontend\models\vks\Request;
use yii\grid\GridView;
use common\rbac\SystemPermission;
use yii\widgets\ActiveForm;

/**
 * @var $this \yii\web\View
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $model \frontend\models\vks\RequestSearch
 */
$this->title = "Заявки";
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Html::pageHeader($this->title) ?>

<div>

    <?php if (Yii::$app->user->identity->isRoomApprovePerson()): ?>

        <?= Html::a('Согласовать бронирования помещений', '/user/booking-approve-list', ['class' => 'btn btn-success', 'style' => 'margin-bottom: 20px']) ?>

    <?php endif; ?>

    <?php $form = ActiveForm::begin([
        'method' => 'get',
    ]) ?>

    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'searchKey')->textInput(['placeholder' => 'Введите текст заявки'])->label(false) ?>
        </div>
        <div class="col-md-4" style="vertical-align: bottom">
            <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> Найти', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end() ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table'
        ],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
            ],
            [
                'attribute' => 'topic',
                'content' => function ($model) {
                    return Html::a($model->topic, ['vks-request/view', 'id' => (string)$model->primaryKey]);
                },
                'contentOptions' => ['style' => 'width: 62%']
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return Request::statusName($model->status);
                },
                'contentOptions' => ['style' => 'width: 13%']
            ],
            [
                'attribute' => 'date',
                'content' => function ($model) {
                    return Yii::$app->formatter->asDate($model->date->sec) . " c {$model->beginTimeString} по {$model->endTimeString}";
                },
                'contentOptions' => ['style' => 'width: 20%']
            ],
            [
                'class' => \yii\grid\ActionColumn::className(),
                'controller' => 'vks-request',
                'template' => '{delete}',
                'visible' => Yii::$app->user->can(SystemPermission::DELETE_REQUEST)
            ]
        ]
    ]) ?>

</div>
