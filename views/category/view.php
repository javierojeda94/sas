<?php

use yii\widgets\DetailView;
use app\models\Area;
use app\models\Category;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
?>
<div class="category-view">

    <?php
        $category = Category::findOne($model->category_id);
        $father_category = isset($category)
                            ? $category->name
                            : 'Not set';
    ?>
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'Father Category',
                'value' => $father_category,
            ],
            [
                'label' => 'Area',
                'value' => Area::findOne($model->id_area)->name,
            ],
            'name',
            'description',
            'service_level_agreement_asignment',
            'service_level_agreement_completion',
        ],
    ]) ?>

</div>
