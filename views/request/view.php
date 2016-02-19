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
        ],
    ]) ?>
    <?php if($model->status != 'Atendiendo' && $model->status != 'Finalizado'){?>
        <p>
            <?php $form = ActiveForm::begin(['action' => "attend"]); ?>

                <?= $form->field($model, 'request_id')->hiddenInput(['value'=> $model->id])->label(false) ?>

            <?php if (!Yii::$app->request->isAjax){ ?>
                <div class="form-group">
                    <?= Html::submitButton('Atender', ['class' => 'btn btn-info']) ?>
                 </div>
            <?php } ?>

            <?php ActiveForm::end(); ?>
        </p>
    <?php } ?>

    <?php if($model->status == 'Atendiendo' && $model->status != 'Finalizado'){?>
        <p>
            <?php $form = ActiveForm::begin(['action' => "complete"]); ?>

            <?= $form->field($model, 'request_id')->hiddenInput(['value'=> $model->id])->label(false) ?>

            <?php if (!Yii::$app->request->isAjax){ ?>
                <div class="form-group">
                    <?= Html::submitButton('Finalizar', ['class' => 'btn btn-success']) ?>
                </div>
            <?php } ?>

            <?php ActiveForm::end(); ?>
        </p>
    <?php } ?>



</div>
