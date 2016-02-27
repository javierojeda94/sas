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
           Yii::$app->user->isGuest ?
            [
                'label' => Yii::t('app','Requests'),
                'url' => ['/request/create']

            ]:
            [
                'label' => Yii::t('app','Requests'),
                'url' => ['/request']
            ],

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
        <p><a href="http://www.matematicas.uady.mx/">Facultad de Matemáticas </a>&nbsp;  | &nbsp;<a href="/site/contact">Contactanos</a></p>
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
    $('#permissionsModal').on('show.bs.modal', function (event) {
        var target = $(event.relatedTarget);
        var user_id = target.data('user-id');
        var area_id = target.data('area-id');
        var modal = $(this);
        $.ajax({
            url: 'permissions?u_id='+user_id+'&a_id='+area_id,
            type: 'get',
            beforeSend: function(){
                modal.find('.modal-title').text('Cargando...');
                modal.find('#area_name').text('Area: ');
                modal.find('#personal_name').text('Personal: ');
                modal.find('#areapersonal-permission').val(0);
            },
            success: function(data){
                modal.find('.modal-title').text('Modificar permisos de personal');
                modal.find('#areapersonal-area_id').val(data.area.id);
                modal.find('#area_name').text('Area: ' + data.area.name);
                modal.find('#personal_name').text('Personal: ' + data.user.name);
                modal.find('#areapersonal-user_id').val(data.user.id);
                modal.find('#areapersonal-permission').val(data.permission);
            },
            error: function(){

            }
        });
    });
</script>
</body>
</html>
<?php $this->endPage() ?>
<script>
    // Filters
    $('#filter').keyup(function () {

        var rex = new RegExp($(this).val(), 'i');
        $('.searchable tr').hide();
        $('.searchable tr').filter(function () {
            return rex.test($(this).text());
        }).show();

    });
</script>