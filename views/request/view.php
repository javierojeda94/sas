<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\request */

$this->title = Yii::t('app', $model->subject);
$this->params['breadcrumbs'][] = ['label' => 'Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', $this->title);//$this->title;

?>
<div class="request-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Advanced options'), ['advanced', 'id' => $model->id],
            ['class' => 'btn btn-primary']) ?>
        <?php if($model->status != 'Rechazado'){ ?>
        <?= Html::a(Yii::t('app', 'Rechazar Solicitud'), ['reject', 'id' => $model->id],
            ['data-confirm' => 'Are you sure you want to reject this request?','class' => 'btn btn-primary']) ?>
        <?php } else { ?>
            <?= Html::a(Yii::t('app', 'Autorizar Solicitud'), ['authorize','id'=>$model->id],
            ['data-confirm' => 'Are you sure you want to authorize this request?','class' => 'btn btn-primary']) ?>
        <?php } ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'Area',
                'value' => isset($model->area) ? $model->area->name : "",
            ],
            [
                'label' => 'Name',
                'value' => $model->name,
            ],
            [
                'label' => 'Email',
                'value' => $model->email,
            ],
            [
                'label' => 'Responsible',
                'value' => strlen($responsible)>0 ? $responsible : 'Sin asignar',
            ],
            [
                'label' => 'Subject',
                'value' => $model->subject,
            ],
            [
                'label' => 'Description',
                'value' => $model->description,
            ],
            [
                'label' => 'Creation Date',
                'value' => $model->creation_date,
            ],
            [
                'label' => 'Status',
                'value' => $model->status,
            ],
            [
                'label' => 'Start Date',
                'value' => $model->scheduled_start_date,
            ],
            [
                'label' => 'End Date',
                'value' => $model->scheduled_end_date,
            ],
        ],
    ]) ?>
    <?php if($model->status != 'Atendiendo' && $model->status != 'Finalizado'){?>
        <p>
            <?= Html::a(Yii::t('app', 'Atender Solicitud'), ['attend', 'id' => $model->id],
                [
                    'class' => 'btn btn-info',
                    'data-confirm' => 'Seguro que quieres atender esta solicitud?',
                ]) ?>
        </p>
    <?php } ?>

    <?php if($model->status == 'Atendiendo' && $model->status != 'Finalizado'){?>
        <p>
            <?= Html::a(Yii::t('app', 'Finalizar Solicitud'), ['complete', 'id' => $model->id],
                [
                    'class' => 'btn btn-success',
                    'data-confirm' => 'Seguro que quieres finalizar esta solicitud?',
                ]) ?>
        </p>
    <?php } ?>



</div>
