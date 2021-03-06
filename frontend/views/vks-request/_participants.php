<?php
/**
 * teleport
 * Created: 27.10.15 9:32
 * @copyright Copyright (c) 2015 OSKR NIAEP
 */
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\components\MinuteFormatter;
use common\models\Company;
use yii\helpers\BaseHtml;
use common\models\vks\Participant;
/**
 * @var $form \kartik\form\ActiveForm
 * @var $this \yii\web\View
 * @var $model \frontend\models\vks\RequestForm
 */
$participants = Participant::findAllByRequest($model)
?>

<div id="vks-participants">

    <div id="checked-rooms-container" class="form-group">

        Выбрано:

        <?php if ($model->participantsId): ?>

            <?php foreach ($participants as $participant): ?>

                <?php if (!$participant->isBusy && in_array($participant->primaryKey, $model->participantsId)): ?>

                    <?= Html::beginTag('div', ['class' => 'btn-group checked-room', 'data' => ['room-id' => (string)$participant->getPrimaryKey()]]) ?>

                    <?php $popoverContent = Html::beginTag('dl') .
                        Html::tag('dt', 'Название') . Html::tag('dd', $participant->name) .
                        Html::tag('dt', 'Организация') . Html::tag('dd', $participant->company->name) .
                        Html::tag('dt', 'Технический специалист') . Html::tag('dd', $participant->contact) .
                        Html::tag('dt', 'IP адрес') . Html::tag('dd', $participant->dialString) .
                        Html::endTag('dl'); ?>

                    <?= Html::button($participant->shortName, ['class' => 'btn btn-default btn-room-info', 'data' => [
                        'toggle' => 'popover',
                        'placement' => 'top',
                        'container' => '#vks-participants',
                        'content' => $popoverContent
                    ]]) ?>

                    <?= Html::beginTag('button', ['class' => 'btn btn-default btn-uncheck', 'type' => 'button']) ?>

                    <span class="glyphicon glyphicon-remove text-danger"></span>

                    <?= Html::endTag('button') ?>

                    <?= Html::endTag('div') ?>

                <?php endif; ?>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>

    <div class="row">
        <div class="col-lg-3">
            <!--[if lt IE 9]><label for="room-filter">Поиск помещений</label><![endif]-->
            <div class="input-group">
                <input id="room-filter-input" type="text" class="form-control" placeholder="Поиск помещений"/>
                <span class="input-group-btn">
                    <button id="room-filter-reset" class="btn btn-default" type="button"><span
                            class="glyphicon glyphicon-remove"></span></button>
                </span>
            </div>
        </div>
    </div>

    <p class="help-block"><span class="glyphicon glyphicon-info-sign"></span> Для получения информации о занятости
        переговрных помещений в других ВКС, дата и время совещания должны быть указаны полностью. Помещения с пометкой VIP необходимо согласовать с Н.П. Шешокиным
    </p>

    <div class="form-group">

        <div class="row">

            <div class="col-lg-5">

                <div class="btn-group-vertical btn-block"
                     style="overflow-x: hidden; overflow-y: scroll; max-height: 300px">

                    <?php foreach (Company::find()->orderBy('order')->all() as $company): ?>

                        <?= Html::button($company->name, [
                            'class' => 'btn btn-default vks-company',
                            'data' => [
                                'id' => (string)$company->primaryKey,
                                'toggle' => 'tooltip',
                                'placement' => 'left',
                                'container' => '#vks-participants',
                                'title' => $company->address
                            ]
                        ]) ?>

                    <?php endforeach; ?>

                </div>

            </div>

            <div class="col-lg-7">

                <div class="row">


                    <?php $userId = Yii::$app->user->identity['_id'] ?>

                    <?= BaseHtml::activeCheckboxList($model, 'participantsId', ArrayHelper::map($participants, function ($item) {
                        /** @var $item \common\models\vks\Participant */
                        return (string)$item->primaryKey;
                    }, 'name'), [
                        'item' => function ($index, $label, $name, $checked, $value) use ($participants, $userId) {
                            /** @var Participant $participant */
                            $participant = $participants[$index];

                            if(is_array($participant->observerList) && !in_array($userId, $participant->observerList)) {
                                return '';
                            }

                            $defaultOptions = [
                                'value' => $value,
                                'data' => ['company-id' => (string)$participant->companyId]
                            ];

                            $label .= $participant->ahuConfirmation ? '&nbsp;<span class="glyphicon glyphicon-star text-warning"></span>' : '';

                            $options = array_merge_recursive($defaultOptions, ($participant->isBusy) ? [
                                'label' => $label . '<p><small>занято с ' . MinuteFormatter::asString($participant->busyFrom) . ' до ' .
                                    MinuteFormatter::asString($participant->busyTo) . '</small></p>',
                                'labelOptions' => ['class' => 'disabled'],
                                'disabled' => true
                            ] : [
                                'label' => $label,
                                'data' => [
                                    'name' => $participant->name,
                                    'short-name' => $participant->shortName,
                                    'company-name' => $participant->company->name,
                                    'contact' => $participant->contact,
                                    'ip-address' => $participant->dialString,
                                ],
                            ]);

                            $tooltip = $participant->ahuConfirmation ? ['data' => [
                                'toggle' => 'tooltip',
                                'html' => true,
                                'placement' => 'top',
                                'container' => '#vks-participants',
                                'title' => Html::tag('div', 'Бронь необходимо согласовать с')
                                    . Html::tag('div', $participant->confirmPerson->fullName)
                                    . Html::tag('div', $participant->confirmPerson->post)
                                    . Html::tag('div', 'тел: '. $participant->confirmPerson->phone . ', ' . $participant->confirmPerson->email)

                            ]] : [];

                            return Html::beginTag('div', array_merge(['class' => 'col-lg-4 vks-room', 'style' => 'display:none'], $tooltip)) . Html::checkbox($name, $checked, $options) . Html::endTag('div');
                        }
                    ]) ?>

                </div>

            </div>

        </div>

    </div>

    <small class="help-block"><span class="glyphicon glyphicon-info-sign"></span> Если участник отсутствует в списке,
        укажите информацию о нем в примечании:
        название, контакты технического специалиста, ip-адрес
    </small>

</div>

<?php
$options = \yii\helpers\Json::encode([
    'companyButtonsSelector' => 'button.vks-company',
    'vksRoomsSelector' => 'div.vks-room',
    'uncheckButtonsSelector' => 'button.btn-uncheck',
    'infoButtonsSelector' => 'button.btn-room-info',
    'checkedRoomsSelector' => 'div.checked-room',
    'checkedRoomsContainerSelector' => '#checked-rooms-container'
]);
$this->registerJs("$('#vks-participants').participants({$options})");
?>

