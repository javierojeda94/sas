<?php

use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
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
