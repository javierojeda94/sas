<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

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
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'area_id',

    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'email',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'subject',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'description',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'creation_date',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'completion_date',
    // ],
     [
        'class'=>'\kartik\grid\DataColumn',
       'attribute'=>'status',
     ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'scheduled_start_date',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'scheduled_end_date',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'token',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },
        'template' => '{view}{update}{delete}{rejectOption}',
        'viewOptions'=>['role'=>'page','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'],
        'buttons' => [
        'rejectOption' => function ($url, $model) {
            $options = ['role'=>'modal-remote','title'=>'Reject',
                'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                'data-request-method'=>'post',
                'data-toggle'=>'tooltip',
                'data-confirm-title'=>'Are you sure?',
                'data-confirm-message'=>'Are you sure want to reject this item'];
            $title = Yii::t('app', 'Reject Request');
            $icon = '<span class="glyphicon glyphicon-remove"></span>';
            $label = ArrayHelper::remove($options, 'label', $icon);
            $options = ArrayHelper::merge(['title' => $title, 'data-pjax' => '0'], $options);
            $url = Url::toRoute(['reject','id'=>$model->id]);
            if($model->status === 'Rechazado'){
                return "";
            }else {
                return Html::a($label, $url, $options);
            }
        }],
    ],

];   