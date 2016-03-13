<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
use yii\jui\DatePicker;
use app\models\Area;
use app\models\Category;
/* @var $this yii\web\View */
/* @var $request app\models\request */

$this->title = Yii::t('app', 'Advanced Options');
$this->params['breadcrumbs'][] = ['label' => 'Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', $this->title);//$this->title;
?>
<div class="request-advanced container">

    <h1><i class="glyphicon glyphicon-cog"></i> Opciones avanzadas de solicitud: <?= $request->id ?></h1>

    <div class="users-request-input request-form row">
        <div class="page-header">
            <h2><small>Calendarización de solicitud</small></h2>
        </div>
        <?php if (Yii::$app->user->can('create_scheduled_requests')) {

        $form = ActiveForm::begin(['action' => "scheduling"]); ?>
        <?= $form->field($request, 'request_id')->hiddenInput(['value' => $request->id])->label(false) ?>
        <div class="col-md-5 input_form">
            <?= $form->field($request, 'scheduled_start_date')->widget(DatePicker::classname(), [
                'dateFormat' => 'yyyy-MM-dd',
                'clientOptions' => [
                    'minDate' => '0',
                ],
            ]) ?>
        </div>
        <div class="col-md-5 input_form">
            <?= $form->field($request, 'scheduled_end_date')->widget(DatePicker::classname(), [
                'dateFormat' => 'yyyy-MM-dd',
                'clientOptions' => [
                    'minDate' => '0',
                ],
            ]) ?>
        </div>
        <div class="col-md-2">
            <?php if (!Yii::$app->request->isAjax) { ?>
                <div class="form-group">
                    <?= Html::submitButton('Calendarizar',
                        [
                            'class' => 'btn btn-success',
                            'data-confirm' => '¿Está seguro que quiere calendarizar la solicitud?',
                        ]) ?>
                </div>
            <?php } ?>
            <?php ActiveForm::end();
            } ?>
        </div>

    </div>

    <div class="users-request-input request-form row">
        <div class="page-header">
            <h2><small>Personal asignado</small></h2>
        </div>
        <?php $form = ActiveForm::begin(['action' => "asign"]); ?>

        <?= $form->field($request, 'request_id')->hiddenInput(['value' => $request->id])->label(false) ?>

        <div class="col-md-4">
            <?= $form->field($request, 'user_id')->dropDownList($users, ['class' => 'form-control']) ?>
        </div>

        <?php if (!Yii::$app->request->isAjax) { ?>
            <div class="form-group">
                <br>
                <?= Html::submitButton('Agregar', ['class' => 'btn btn-success']) ?>
            </div>
        <?php } ?>

        <?php ActiveForm::end(); ?>
    </div>

    <div>
        <?=
        Html::a(Yii::t('app', '<i class="glyphicon glyphicon-remove"></i>Unassing All '),
            ['unasign', 'r_id' => $request->id],
            [
                'id' => 'unasign_several',
                'data-request' => $request->id,
                'class' => 'btn btn-danger pull-right',
            ])
        ?>
        <br>
        <br>
        <table width="100%" border="1px solid grey"
               class="kv-grid-table table table-bordered table-striped table-condensed kv-table-wrap">
            <thead>
            <th class="kv-align-center kv-align-middle kv-merged-header"></th>
            <th class="kv-align-center kv-align-middle kv-merged-header">Id</th>
            <th class="kv-align-center kv-align-middle kv-merged-header">Nombre</th>
            <th class="kv-align-center kv-align-middle kv-merged-header text-center">Actions</th>
            </thead>
            <tbody>
            <?php foreach ($responsible as $resp) {
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
                    <td class="skip-export kv-align-center kv-align-middle text-center" style="width: 10%;">
                        <?=
                        Html::a(Yii::t('app', '<i class="glyphicon glyphicon-remove"></i>'),
                            ['unasign', 'u_id' => $user->id, 'r_id' => $request->id],
                            [
                                'class' => 'btn-danger btn-small',
                                'data-confirm' => '¿Está seguro que desea desasignar este usuario?',
                            ])
                        ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="users-request-input request-form row">
        <div class="page-header">
            <h2><small>Áreas asignadas</small></h2>
        </div>
        <?php $form = ActiveForm::begin(['action' => "asign-area"]); ?>

        <?= $form->field($request, 'request_id')->hiddenInput(['value' => $request->id])->label(false) ?>

        <div class="col-md-4">
            <?= $form->field($request, 'area_id')->dropDownList($areas, ['class' => 'form-control']) ?>
        </div>

        <?php if (!Yii::$app->request->isAjax) { ?>
            <div class="form-group">
                <br>
                <?= Html::submitButton('Agregar', ['class' => 'btn btn-success']) ?>
            </div>
        <?php } ?>

        <?php ActiveForm::end(); ?>
    </div>

    <div>
        <br>
        <br>
        <table width="100%" border="1px solid grey"
               class="kv-grid-table table table-bordered table-striped table-condensed kv-table-wrap">
            <thead>
            <th class="kv-align-center kv-align-middle kv-merged-header"></th>
            <th class="kv-align-center kv-align-middle kv-merged-header">Id de Área</th>
            <th class="kv-align-center kv-align-middle kv-merged-header">Nombre de Área</th>
            <th class="kv-align-center kv-align-middle kv-merged-header text-center">Actions</th>
            </thead>
            <tbody>
            <?php
                    foreach ($areasRequest as $areaRequest) {
                ?>
                <tr>
                    <td>
                        <input class="checkbox" type="checkbox" value="<?= $areaRequest['area_id'] ?>">
                    </td>
                    <td class="skip-export kv-align-center kv-align-middle">
                        <?= $areaRequest['area_id'] ?>

                    </td>
                    <td class="skip-export kv-align-center kv-align-middle">
                        <?php
                        $area = Area::findOne($areaRequest["area_id"]);
                        echo $area->name;
                        ?>
                    </td>
                    <td class="skip-export kv-align-center kv-align-middle text-center" style="width: 10%;">
                        <?=
                        Html::a(Yii::t('app', '<i class="glyphicon glyphicon-remove"></i>'),
                            ['unasign-area', 'r_id' => $request->id, 'a_id' => $areaRequest['area_id']],
                            [
                                'class' => 'btn-danger btn-small',
                                'data-confirm' => '¿Está seguro que desea desasignar esta área?',
                            ])
                        ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="users-request-input request-form row">
        <div class="page-header">
            <h2><small>Categorías asignadas</small></h2>
        </div>
        <?php $form = ActiveForm::begin(['action' => "asign-category"]); ?>

        <?= $form->field($request, 'request_id')->hiddenInput(['value' => $request->id])->label(false) ?>

        <div class="col-md-4">
            <?= $form->field($request, 'category_id')->dropDownList($categories, ['class' => 'form-control']) ?>
        </div>

        <?php if (!Yii::$app->request->isAjax) { ?>
            <div class="form-group">
                <br>
                <?= Html::submitButton('Agregar', ['class' => 'btn btn-success']) ?>
            </div>
        <?php } ?>

        <?php ActiveForm::end(); ?>
    </div>

    <div>
        <br>
        <br>
        <table width="100%" border="1px solid grey"
               class="kv-grid-table table table-bordered table-striped table-condensed kv-table-wrap">
            <thead>
            <th class="kv-align-center kv-align-middle kv-merged-header"></th>
            <th class="kv-align-center kv-align-middle kv-merged-header">Id de Categoría</th>
            <th class="kv-align-center kv-align-middle kv-merged-header">Nombre de Categoría</th>
            <th class="kv-align-center kv-align-middle kv-merged-header text-center">Actions</th>
            </thead>
            <tbody>
            <?php
            foreach ($categoriesRequest as $categoryRequest) {
                ?>
                <tr>
                    <td>
                        <input class="checkbox" type="checkbox" value="<?= $categoryRequest['category_id'] ?>">
                    </td>
                    <td class="skip-export kv-align-center kv-align-middle">
                        <?= $categoryRequest['category_id'] ?>

                    </td>
                    <td class="skip-export kv-align-center kv-align-middle">
                        <?php
                        $category =Category::findOne($categoryRequest['category_id']);
                        echo $category->name;
                        ?>
                    </td>
                    <td class="skip-export kv-align-center kv-align-middle text-center" style="width: 10%;">
                        <?=
                        Html::a(Yii::t('app', '<i class="glyphicon glyphicon-remove"></i>'),
                            ['unasign-category', 'r_id' => $request->id, 'c_id' => $categoryRequest['category_id']],
                            [
                                'class' => 'btn-danger btn-small',
                                'data-confirm' => '¿Está seguro que desea desasignar esta categoría?',
                            ])
                        ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

</div>
