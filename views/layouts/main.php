<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
$logo = "<img id='logo_nav' src='".Yii::$app->homeUrl."../images/UADY_w.png'/>";
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href=" <?= Yii::$app->homeUrl?>../images/favicon.png" type="image/x-png">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' =>  $logo.'SAS',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Inicio', 'url' => Yii::$app->homeUrl],
            // ['label' => 'About', 'url' => ['/site/about']],
            // ['label' => 'Contact', 'url' => ['/site/contact']],
            [
                'label' => Yii::t('app', 'Categories'),
                'url' => ['/category'],
                'visible' => !Yii::$app->user->isGuest
            ],
            [
                'label' => Yii::t('app', 'Areas'),
                'url' => ['/area'],
                'visible' => !Yii::$app->user->isGuest
            ],
            Yii::$app->user->isGuest ?
                ['label' => Yii::t('app','Iniciar Sesión'), 'url' => ['/site/login']] :
                [
                    'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ],
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p><a href="/site/about">Acerca &nbsp; </a> | &nbsp;<a href="/site/contact">Contactanos</a></p>
        <p class="pull-left">&copy; SAS <?= date('Y') ?></p>

    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
