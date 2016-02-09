<?php

use yii\widgets\DetailView;
use app\models\Area;
use app\models\Category;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
?>
<div class="category-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'Father Category',
                'value' => isset($model->category) ? $model->category->name : "",
            ],
            [
                'label' => 'Area',
                'value' => $model->idArea->name,
            ],
            'name',
            'description',
            'service_level_agreement_asignment',
            'service_level_agreement_completion',
        ],
    ]) ?>

</div>
