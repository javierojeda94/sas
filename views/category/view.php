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
                'label' => Yii::t('app', 'Father Category'),
                'value' => isset($model->category) ? $model->category->name : "",
            ],
            [
                'label' => Yii::t('app', 'Area'),
                'value' => $model->idArea->name,
            ],
            [
                'label' => Yii::t("app", "name"),
                'value' => $model->name,
            ],
            [
                'label' => Yii::t("app", "description"),
                'value' => $model->description,
            ],
            [
                'label' => Yii::t("app", "service_level_agreement_asignment"),
                'value' => $model->service_level_agreement_asignment,
            ],
            [
                'label' => Yii::t("app", "service_level_agreement_completion"),
                'value' => $model->service_level_agreement_completion,
            ],
        ],
    ]) ?>

</div>
