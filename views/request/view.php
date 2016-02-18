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

</div>
