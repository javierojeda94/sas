<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

return [
//    [
//        'class' => 'kartik\grid\CheckboxColumn',
//        'width' => '20px',
//    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
        'label' => Yii::t('app', 'Name')
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'email',
        'label' => Yii::t('app', 'Email')
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'area_name',
        'value' => 'area.name',
        'label' => Yii::t('app', 'Area')
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'subject',
        'label' => Yii::t('app', 'Subject')
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'description',
        'label' => Yii::t('app', 'Description')
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'status',
        'label' => Yii::t('app', 'Status')
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },
        'template' => '{view}',
        'viewOptions'=>['role'=>'page','title'=> Yii::t('app', 'View'),'data-toggle'=>'tooltip'],
    ],

];