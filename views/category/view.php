<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
?>
<div class="category-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'category_id',
            'id_area',
            'name',
            'description',
            'service_level_agreement_asignment',
            'service_level_agreement_completion',
        ],
    ]) ?>

</div>
