<?php

use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\request */
?>
<div class="request-advanced">

    <h1>Opciones avanzadas de solicitud: <?= $request->id ?></h1>

    <div class="users-request-input request-form row">

        <?php $form = ActiveForm::begin(['action' => "asign"]); ?>

        <?= $form->field($request, 'request_id')->hiddenInput(['value'=> $request->id])->label(false) ?>

        <div class="col-md-4">
            <?= $form->field($request, 'user_id')->dropDownList($users,['class' => 'form-control']) ?>
        </div>

        <?php if (!Yii::$app->request->isAjax){ ?>
            <div class="form-group">
                <?= Html::submitButton('Agregar', ['class' => 'btn btn-success']) ?>
            </div>
        <?php } ?>

        <?php ActiveForm::end(); ?>
    </div>
    
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'users-request-datatable',
            'dataProvider' => $dataProvider,
            'pjax'=>true,
            'columns' => [
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'attribute'=>'id',
                    'value' => 'user_id'
                ],
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'attribute'=>'nombre',
                    'value' => function ($model, $key, $index, $column){
                        $user = User::find()->where(['id' => $model->user_id])->one();
                        return $user->first_name . ' ' . $user->lastname;
                    }
                ],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'dropdown' => false,
                    'vAlign'=>'middle',
                    'urlCreator' => function($action, $model, $key, $index) {
                            return Url::to([$action,'id'=>$key]);
                    },
                    'template' => '{unasignOption}',
                    'buttons' => [
                        'unasignOption' => function($url, $model){
                            $options = ['role'=>'modal-remote','title'=>'Unasign',
                            'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                            'data-request-method'=>'post',
                            'data-toggle'=>'tooltip',
                            'data-confirm-title'=>'Are you sure?',
                            'data-confirm-message'=>'Are you sure want to unasign this item'];
                            $title = Yii::t('app', 'Unasign');
                            $icon = '<span class="glyphicon glyphicon-remove"> Deasignar</span>';
                            $label = ArrayHelper::remove($options, 'label', $icon);
                            $options = ArrayHelper::merge(['title' => $title, 'data-pjax' => '0'], $options);
                            $url = Url::toRoute(['unasign','u_id'=> $model->user_id,'r_id' => $model->request_id]);
                            return Html::a($label, $url, $options);
                        }
                    ],
                ]
            ],         
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
        ])?>
    </div>

</div>
