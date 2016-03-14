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
        'brandLabel' =>  $logo.' SAS',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [



            ['label' => 'Inicio', 'url' => Yii::$app->homeUrl],
           Yii::$app->user->isGuest?
            [
                'label' => Yii::t('app','Requests'),
                'url' => ['/request/create']
            ]:
            [
                'label' => Yii::t('app','Requests'),
                'url' => ['/request'],
            ],

            [
                'label' => Yii::t('app', 'Categories'),
                'url' => ['/category'],
                'visible' => Yii::$app->user->can('executive') || Yii::$app->user->can('administrator') ||
                    Yii::$app->user->can('responsibleArea')
            ],
            [
                'label' => Yii::t('app', 'Areas'),
                'url' => ['/area'],
                'visible' => Yii::$app->user->can('executive') || Yii::$app->user->can('administrator')
            ],
            [
                'label' => Yii::t('app', 'Reports'),
                'url' => ['/report'],
                'visible' => Yii::$app->user->can('executive') || Yii::$app->user->can('administrator')
            ],
            [
                'label' => Yii::t('app', 'Rbac'),
                'url' => ['/rbac/assignment'],
                'visible' => Yii::$app->user->can('executive') || Yii::$app->user->can('administrator')
            ],
            Yii::$app->user->isGuest ?
                ['label' => Yii::t('app','Iniciar Sesión'), 'url' => ['/site/login']] :
                [
                    'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post','data-confirm' => Yii::t('app','¿Are you sure you want to logout?')]
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
        <p><a href="http://www.matematicas.uady.mx/">Facultad de Matemáticas </a>&nbsp;</p>
        <p class="pull-left">&copy; SAS <?= date('Y') ?></p>

    </div>
</footer>
<?php $this->endBody() ?>
<script>
    var button = document.getElementById('unasign_several');
    if(button != null){
        button.addEventListener('click',function(e){
            e.preventDefault();
            if(confirm('Seguro que quieres deasignar estos usuarios?')){
                var checkboxes = document.getElementsByClassName('checkbox');
                var r_id = document.getElementById('unasign_several').getAttribute('data-request');
                var url = 'unasign?r_id='+r_id;
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].checked) {
                        var ajax_url = url + '&u_id=' + checkboxes[i].value;
                        $.ajax({
                            url: ajax_url,
                            method: 'get',
                        });
                    }
                }
            }
        });
    }
</script>
</body>
</html>
<?php $this->endPage() ?>