<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\request */

if(Yii::$app->user->isGuest) {
    $this->title = Yii::t('app', 'Create Request');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Requests'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = Yii::t('app', 'Create Request');
}
?>
<div class="request-create">

    <?php if(Yii::$app->user->isGuest) {?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php } ?>

    <?php if (Yii::$app->session->hasFlash('requestFormSubmitted')): ?>
        <div class="alert alert-success">
            <p>Su solicitud fue registrada. <br>Utilice la siguiente url para darle seguimiento a su solicitud:
                <a href="<?= 'http://' . $_SERVER['HTTP_HOST'] . Url::base() . '/request/follow?token=' . $model->token ?>">
                    <?= 'http://' . $_SERVER['HTTP_HOST'] . Url::base() . '/request/follow?token=' . $model->token ?>
                </a>
            </p>
            <small>De igual manera, le hemos enviado esa url a su correo.</small>
        </div>
    <?php endif; ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
