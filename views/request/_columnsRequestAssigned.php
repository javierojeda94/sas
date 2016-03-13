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
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'area_name',
        'value' => 'area.name',
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
        'attribute'=>'status',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },
        'template' => '{view}{rejectOption}',
        'viewOptions'=>['role'=>'page','title'=>Yii::t('app', 'View'),'data-toggle'=>'tooltip'],
        'buttons' => [
        'rejectOption' => function ($url, $model) {
            if($model->status === 'Rechazado'){
                $options = ['role'=>'modal-remote','title'=>Yii::t('app', 'Authorize'),
                'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                'data-request-method'=>'post',
                'data-toggle'=>'tooltip',
                'data-confirm-title'=>Yii::t('app', 'Are you sure?'),
                'data-confirm-message'=>Yii::t('app', 'Are you sure want to authorize this item')];
                $title = Yii::t('app', 'Authorize Request');
                $icon = '<span class="glyphicon glyphicon-open"></span>';
                $label = ArrayHelper::remove($options, 'label', $icon);
                $options = ArrayHelper::merge(['title' => $title, 'data-pjax' => '0'], $options);
                $url = Url::toRoute(['authorize','id'=>$model->id]);
            }else {
                $options = ['role'=>'modal-remote','title'=>Yii::t('app', 'Reject'),
                'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                'data-request-method'=>'post',
                'data-toggle'=>'tooltip',
                'data-confirm-title'=>Yii::t('app', 'Are you sure?'),
                'data-confirm-message'=>Yii::t('app', 'Are you sure want to reject this item')];
                $title = Yii::t('app', 'Reject Request');
                $icon = '<span class="glyphicon glyphicon-remove"></span>';
                $label = ArrayHelper::remove($options, 'label', $icon);
                $options = ArrayHelper::merge(['title' => $title, 'data-pjax' => '0'], $options);
                $url = Url::toRoute(['reject','id'=>$model->id]);
            }
            return Html::a($label, $url, $options);
        }],
    ],

];   