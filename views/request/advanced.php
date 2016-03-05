<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $request app\models\request */

$this->title = Yii::t('app', 'Advanced Options');
$this->params['breadcrumbs'][] = ['label' => 'Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', $this->title);//$this->title;
?>
<div class="request-advanced">

    <h1>Opciones avanzadas de solicitud: <?= $request->id ?></h1>

    <div class="users-request-input request-form row">
    <?php if(Yii::$app->user->can('create_scheduled_requests')){

    $form = ActiveForm::begin(['action' => "scheduling"]); ?>
        <?= $form->field($request, 'request_id')->hiddenInput(['value'=> $request->id])->label(false) ?>

        <?= $form->field($request, 'scheduled_start_date')->widget(DatePicker::classname(), [
            'dateFormat' => 'yyyy-MM-dd',
            'clientOptions' => [
                'minDate' =>'0',
            ],
        ]) ?>
        <?= $form->field($request, 'scheduled_end_date')->widget(DatePicker::classname(), [
            'dateFormat' => 'yyyy-MM-dd',
            'clientOptions' => [
                'minDate' =>'0',
            ],
        ])  ?>

        <?php if (!Yii::$app->request->isAjax){ ?>
            <div class="form-group">
                <?= Html::submitButton('Calendarizar',
                    [
                        'class' => 'btn btn-success',
                        'data-confirm' => 'Estás seguro que quiere calendarizar está solicitud?',
                    ]) ?>
            </div>
        <?php } ?>
        <?php ActiveForm::end(); }?>

    </div>

    <div class="users-request-input request-form row">

        <?php $form = ActiveForm::begin(['action' => "asign"]); ?>

        <?= $form->field($request, 'request_id')->hiddenInput(['value'=> $request->id])->label(false) ?>

        <div class="col-md-4">
            <?= $form->field($request, 'user_id')->dropDownList($users,['class' => 'form-control']) ?>
        </div>

        <?php if (!Yii::$app->request->isAjax){ ?>
            <div class="form-group">
                <br>
                <?= Html::submitButton('Agregar', ['class' => 'btn btn-success']) ?>
            </div>
        <?php } ?>

        <?php ActiveForm::end(); ?>
    </div>

    <div>

        <table width="100%" border="1px solid grey" class="kv-grid-table table table-bordered table-striped table-condensed kv-table-wrap">
            <thead>
                <th class="kv-align-center kv-align-middle kv-merged-header"></th>
                <th class="kv-align-center kv-align-middle kv-merged-header">Id</th>
                <th class="kv-align-center kv-align-middle kv-merged-header">Nombre</th>
                <th class="kv-align-center kv-align-middle kv-merged-header">Actions</th>
            </thead>
            <tbody>
                <?php foreach($responsible as $resp){
                     ?>
                <tr>
                    <td>
                        <input class="checkbox" type="checkbox" value="<?= $resp['user_id'] ?>">
                    </td>
                    <td class="skip-export kv-align-center kv-align-middle">
                        <?= $resp['user_id'] ?>
                    </td>
                    <td class="skip-export kv-align-center kv-align-middle">
                        <?php
                        $user = User::findOne($resp["user_id"]);
                        echo $user->first_name . ' ' . $user->lastname;
                        ?>
                    </td>
                    <td class="skip-export kv-align-center kv-align-middle">
                        <?=
                            Html::a(Yii::t('app', 'Unasign '),
                                ['unasign', 'u_id' => $user->id,'r_id' => $request->id],
                            [
                                'class' => 'btn btn-danger',
                                'data-confirm' => 'Seguro que quieres deasignar este usuario?',
                            ])
                        ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?=
        Html::a(Yii::t('app', 'Unasign '),
            ['unasign', 'r_id' => $request->id],
            [
                'id' => 'unasign_several',
                'data-request' => $request->id,
                'class' => 'btn btn-info',
            ])
        ?>
    </div>

</div>
