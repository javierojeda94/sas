<?php
use yii\helpers\Url;
use app\models\Area;
use app\models\Category;

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
        'attribute'=>'category_name',
        'value' => 'category.name',
        'label'=> Yii::t('app','Category Name'),
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'area_name',
        'value' => 'idArea.name',
        'label'=> Yii::t('app','Area Name'),

    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
        'label'=> Yii::t('app','Name'),

    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'description',
        'label'=> Yii::t('app','Description'),

    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'service_level_agreement_asignment',
        'label'=> Yii::t('app','Service Level Agreement Asignment'),

    ],
    [
      'class'=>'\kartik\grid\DataColumn',
      'attribute'=>'service_level_agreement_completion',
        'label'=> Yii::t('app','Service Level Agreement Completion'),

    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>Yii::t('app', 'View'),'data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>Yii::t('app', 'Update'), 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>Yii::t('app', 'Delete'),
                            'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                            'data-request-method'=>'post',
                            'data-toggle'=>'tooltip',
                            'data-confirm-title'=>Yii::t('app', 'Are you sure?'),
                            'data-confirm-message'=>Yii::t('app', 'Are you sure you want to delete this item?')],
    ],

];   