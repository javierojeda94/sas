<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Area;
use app\models\User;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [

        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'father_area',
        'value'=>'area.name'
        /*
        'value' => function($model){
            $area = Area::findOne($model->area_id);
            return isset($area)
                ? $area->name
                : 'Not set';
        }*/
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
        'attribute'=>'name',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'description',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'template' => '{view}{update}{delete}{addPersonalOption}',
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'],
        'buttons' => [
            'addPersonalOption'=>function($url, $model){
                $options = ['data-toggle'=>'tooltip'];
                $title = Yii::t('app', 'Advanced Options');
                $icon = '<span class="glyphicon glyphicon-wrench"></span>';
                $label = ArrayHelper::remove($options, 'label', $icon);
                $options = ArrayHelper::merge(['title' => $title, 'data-pjax' => '0'], $options);
                $url = Url::toRoute(['modify','id'=>$model->id]);
                return Html::a($label, $url, $options);
            }
        ],
    ],

];   