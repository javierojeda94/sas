<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Area */
?>
<div class="area-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' =>Yii::t("app", "Father Area"),
                'value' => isset($model->area) ? $model->area->name : "" ,
            ],
            [
                'label' => 'Responsable',
                'value' => $model->idResponsable->first_name . " ". $model->idResponsable->lastname ,
            ],
            'name',
            'description',
        ],
    ]) ?>

</div>
