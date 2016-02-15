<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\request */

?>
<div class="request-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Advanced options'), ['advanced', 'id' => $model->id],
            ['class' => 'btn btn-primary pull-right']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'area_id',
            'user_id',
            'name',
            'email:email',
            'subject',
            'description:ntext',
            'creation_date',
            'completion_date',
            'status',
            'scheduled_start_date',
            'scheduled_end_date',
            'token',
        ],
    ]) ?>

</div>
