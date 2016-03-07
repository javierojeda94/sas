<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Area;
use app\models\User;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [

        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'father_area',
        'value'=>'area.name'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'responsable_name',
        'value'=>'idResponsable.first_name'

        /*
        'value'=>function($model){
            $user = User::findOne($model->id_responsable);
            return isset($user)
                ? $user->first_name
                : 'Not Set';
        }
        */

    ],
    [

        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'father_area',
        'value'=>'area.name'
    ],

];   