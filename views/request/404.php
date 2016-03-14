<?php
use sintret\chat\ChatRoom;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\request */

$this->title = Yii::t('app', 'Request not found');
$this->params['breadcrumbs'][] = ['label' => 'Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', $this->title);//$this->title;

?>
<div class="request-view">


        <h3><?= Yii::t('app',"Request not found (#404)") ?></h3>
    <div class="alert alert-danger">
        <?= Yii::t('app',"We couldn't find the request you were looking for.
        Feel free to send another request reporting this issue.") ?>
    </div>
    <?= Yii::t('app','Token: ' . $token) ?>

</div>
