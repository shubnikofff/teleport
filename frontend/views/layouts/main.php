<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\rbac\SystemPermission;

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
    <meta http-equiv="X-UA-Compatible" content="IE=100" >
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
        $userMenu[] = ['label' => '<span class="glyphicon glyphicon-user"></span> ' . $identity->shortName, 'items' => [
            ['label' => '<span class="glyphicon glyphicon-cog"></span> Профиль', 'url' => ['/user/profile']],
            ['label' => '<span class="glyphicon glyphicon-list-alt"></span> Заявки', 'url' => ['/user/requests']],
            ['label' => 'Выход', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']]
        ]];
    }
    $userMenu[] = ['label' => '<span class="glyphicon glyphicon-question-sign"></span> Справка', 'url'=>['/site/about']]; ?>

    <?php if(Yii::$app->user->can(SystemPermission::CREATE_REQUEST)): ?>

    <?= Nav::widget([
        'encodeLabels' => false,
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => [
            ['label' => '<span class="glyphicon glyphicon-pencil"></span> Подать заявку', 'url' => ['/vks-request/create']]
        ],
    ]); ?>

    <?php endif; ?>

    <?= Nav::widget([
        'encodeLabels' => false,
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $userMenu
    ]); ?>

    <?php NavBar::end() ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy;&nbsp;<?= date('Y') ?> Отдел Системных Корпоративных Ресурсов АО"НИАЭП"</p>

        <p class="pull-right"><?= Html::a('oskr@niaep.ru', 'mailto:oskr@niaep.ru') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
