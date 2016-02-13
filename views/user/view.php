<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */
?>
<div class="user-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'first_name',
            'lastname',
            'hash_password',
            'user_name',
            'email:email',
            'status',
        ],
    ]) ?>

</div>
