<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\rbac\SystemPermission;
use yii\bootstrap\Alert as BootstrapAlert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
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
<div class="wrap">
    <?php NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    if (Yii::$app->user->isGuest) {
        $userMenu[] = ['label' => '<span class="glyphicon glyphicon-log-in"></span> Вход', 'url' => ['/site/login']];
        $userMenu[] = ['label' => 'Регистрация', 'url' => ['/site/signup']];
    } else {
        /** @var \common\models\User $identity */
        $identity = Yii::$app->user->identity;
        $leftMenuItems[] = ['label' => '<span class="glyphicon glyphicon-pencil"></span> Подать заявку', 'url' => ['/vks-request/create']];
        $userMenu[] = ['label' => '<span class="glyphicon glyphicon-user"></span> Личный кабинет', 'items' => [
            ['label' => '<span class="glyphicon glyphicon-cog"></span> Профиль', 'url' => ['/user/profile']],
            ['label' => '<span class="glyphicon glyphicon-list-alt"></span> Мои заявки', 'url' => ['/user/requests']],
            ['label' => '<span class="glyphicon glyphicon-earphone"></span> Аудиоконференция', 'url' => ['/audio-conference/index']],
            ['label' => 'Выход', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']]
        ]];
    }

    $leftMenuItems[] = ['label' => '<span class="glyphicon glyphicon-list-alt"></span> Формы заявок', 'url' => ['/site/request-forms']]; ?>

    <?= Nav::widget([
        'encodeLabels' => false,
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => $leftMenuItems,
    ]); ?>

    <?php $rightMenuItems = $userMenu;
    if (Yii::$app->user->can(SystemPermission::GENERATE_REPORTS)) {
        $rightMenuItems[] = ['label' => '<span class="glyphicon glyphicon-file"></span> Отчет', 'url' => ['/report']];
    }
    $rightMenuItems[] = ['label' => '<span class="glyphicon glyphicon-question-sign"></span> Справка', 'url' => ['/site/about']];
    $rightMenuItems[] = ['label' => '<span class="glyphicon glyphicon-envelope"></span> Написать в УСКР', 'url' => 'mailto:oskr@niaep.ru'] ?>

    <?= Nav::widget([
        'encodeLabels' => false,
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $rightMenuItems
    ]); ?>

    <?php NavBar::end() ?>

    <div class="container">
        <!--[if (lt IE 9)]>
        <div class="alert alert-danger" role="alert">Внимание! Ваш браузер не поддерживается. Для корректной работы
            портала воспользуйтесь другим браузером, например Google Chrome.
        </div>
        <![endif]-->
        <?php if (Yii::$app->user->isGuest && $this->context->id !== 'site'): ?>

            <?= BootstrapAlert::widget([
                'options' => [
                    'class' => 'alert-warning',
                ],
                'body' => 'Уважаемый Гость, Вы находитесь в режиме просмотра, для создания/редактирования заявок необходимо '
                    . Html::a('войти', ['/site/login']) . ' на портал под своей учетной записью или ' .
                    Html::a('зарегистрироваться', ['/site/register']) . '.',
            ]) ?>

        <?php endif; ?>


        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer" style="padding-bottom: 50px;">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div>0-0-0</div>
                <div><?= Html::a('oskr@niaep.ru', 'mailto:oskr@niaep.ru') ?></div>
            </div>
            <div class="col-md-3">
                <div>+7 (910) 100-80-00</div>
                <div>+7 (831) 421-79-90</div>
            </div>
            <div class="col-md-6">&copy;&nbsp;Управление системных корпоративных ресурсов АО ИК "АСЭ" <?= date('Y') ?>
                г.
            </div>
        </div>
    </div>

</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
