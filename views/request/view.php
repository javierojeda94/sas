<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\request */
?>
<div class="request-view">

    <a href="advanced?id=<?= $model->id ?>">
        <button class="btn btn-primary pull-right">Opciones Avanzadas</button>
    </a>

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
