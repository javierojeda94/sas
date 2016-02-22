<?php

use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use app\models\User;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\request */
?>
<div class="request-advanced">

    <h1>Modificar permisos de usuario <?= $user->first_name ?> en area: <?= $area->id ?></h1>

    <div class="permissions-request-input request-form row">

        <?php $form = ActiveForm::begin(['action' => "addpermission"]); ?>

        <?= $form->field($relationship, 'area_id')->hiddenInput(['value'=> $area->id])->label(false) ?>
        <?= $form->field($relationship, 'user_id')->hiddenInput(['value'=> $user->id])->label(false) ?>

        <div class="col-md-4">
            <?= $form->field($relationship, 'permission')->dropDownList(
                ['Seleccion',1,2,3,4,5],
                ['class' => 'form-control']
            ) ?>
        </div>

        <?php if (!Yii::$app->request->isAjax){ ?>
            <div class="form-group">
                <br>
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
            </div>
        <?php } ?>

        <?php ActiveForm::end(); ?>
    </div>

</div>
