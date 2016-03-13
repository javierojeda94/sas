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

    <h1><i class="glyphicon glyphicon-cog"></i> <?= Yii::t('app', 'Advanced options for request:'), $request->id ?></h1>

    <div class="users-request-input request-form row">
        <div class="page-header">
            <h2><small><?= Yii::t('app', 'Schedule Request')?></small></h2>
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
            ])->label(Yii::t('app', 'Scheduled start date')) ?>
        </div>
        <div class="col-md-5 input_form">
            <?= $form->field($request, 'scheduled_end_date')->widget(DatePicker::classname(), [
                'dateFormat' => 'yyyy-MM-dd',
                'clientOptions' => [
                    'minDate' => '0',
                ],
            ])->label(Yii::t('app','Scheduled end date')) ?>
        </div>
        <div class="col-md-2">
            <?php if (!Yii::$app->request->isAjax) { ?>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app','Schedule'),
                        [
                            'class' => 'btn btn-success',
                            'data-confirm' => Yii::t('app','¿Are you sure you want to schedule this request?'),
                        ]) ?>
                </div>
            <?php } ?>
            <?php ActiveForm::end();
            } ?>
        </div>

    </div>

    <div class="users-request-input request-form row">
        <div class="page-header">
            <h2><small><?= Yii::t('app', 'Assigned Personal')?> </small></h2>
        </div>
        <?php $form = ActiveForm::begin(['action' => "asign"]); ?>

        <?= $form->field($request, 'request_id')->hiddenInput(['value' => $request->id])->label(false) ?>

        <div class="col-md-4">
            <?= $form->field($request, 'user_id')->dropDownList($users, ['class' => 'form-control'])->label('Personal') ?>
        </div>

        <?php if (!Yii::$app->request->isAjax) { ?>
            <div class="form-group">
                <br>
                <?= Html::submitButton(Yii::t('app','Add'), ['class' => 'btn btn-success']) ?>
            </div>
        <?php } ?>

        <?php ActiveForm::end(); ?>
    </div>

    <div>
        <?=
        Html::a(Yii::t('app', 'Unassing All'),
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
            <th class="kv-merged-header"></th>
            <th class="kv-merged-header"><?=Yii::t('app', 'Id')?></th>
            <th class="kv-merged-header"><?=Yii::t('app', 'Name')?></th>
            <th class="kv-merged-header text-center"><?= Yii::t('app', 'Actions')?></th>
            </thead>
            <tbody>
            <?php foreach ($responsible as $resp) {
                ?>
                <tr>
                    <td>
                        <input class="checkbox" type="checkbox" value="<?= $resp['user_id'] ?>">
                    </td>
                    <td>
                        <?= $resp['user_id'] ?>
                    </td>
                    <td>
                        <?php
                        $user = User::findOne($resp["user_id"]);
                        echo $user->first_name . ' ' . $user->lastname;
                        ?>
                    </td>
                    <td class="text-center" style="width: 10%;">
                        <?=
                        Html::a(Yii::t('app', '<i class="glyphicon glyphicon-remove"></i>'),
                            ['unasign', 'u_id' => $user->id, 'r_id' => $request->id],
                            [
                                'class' => 'btn btn-small',
                                'data-toggle'=> 'tooltip',
                                'title'=>Yii::t('app', 'Remove personal'),
                                'data-confirm' => Yii::t('app','¿Are you sure you want to unasign this user?'),
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
            <h2><small><?= Yii::t('app','Assigned Areas') ?></small></h2>
        </div>
        <?php $form = ActiveForm::begin(['action' => "asign-area"]); ?>

        <?= $form->field($request, 'request_id')->hiddenInput(['value' => $request->id])->label(false) ?>

        <div class="col-md-4">
            <?= $form->field($request, 'area_id')->dropDownList($areas, ['class' => 'form-control']) ->label(Yii::t('app','Area'))?>
        </div>

        <?php if (!Yii::$app->request->isAjax) { ?>
            <div class="form-group">
                <br>
                <?= Html::submitButton(Yii::t('app','Add'), ['class' => 'btn btn-success']) ?>
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
            <th class="kv-merged-header"></th>
            <th class="kv-merged-header"><?= Yii::t('app','Id') ?></th>
            <th class="kv-merged-header"><?= Yii::t('app','Area name') ?></th>
            <th class="kv-merged-header text-center"><?= Yii::t('app','Actions') ?></th>
            </thead>
            <tbody>
            <?php
                    foreach ($areasRequest as $areaRequest) {
                ?>
                <tr>
                    <td>
                        <input class="checkbox" type="checkbox" value="<?= $areaRequest['area_id'] ?>">
                    </td>
                    <td>
                        <?= $areaRequest['area_id'] ?>

                    </td>
                    <td>
                        <?php
                        $area = Area::findOne($areaRequest["area_id"]);
                        echo $area->name;
                        ?>
                    </td>
                    <td class="text-center" style="width: 10%;">
                        <?=
                        Html::a(Yii::t('app', '<i class="glyphicon glyphicon-remove"></i>'),
                            ['unasign-area', 'r_id' => $request->id, 'a_id' => $areaRequest['area_id']],
                            [
                                'class' => 'btn btn-small',
                                'data-toggle'=> 'tooltip',
                                'title'=>Yii::t('app', 'Remove area'),
                                'data-confirm' => Yii::t('app', '¿Are you sure you want to unassign this area?'),
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
            <h2><small><?= Yii::t('app','Assigned categories') ?></small></h2>
        </div>
        <?php $form = ActiveForm::begin(['action' => "asign-category"]); ?>

        <?= $form->field($request, 'request_id')->hiddenInput(['value' => $request->id])->label(false) ?>

        <div class="col-md-4">
            <?= $form->field($request, 'category_id')->dropDownList($categories, ['class' => 'form-control'])->label(Yii::t('app','Category')) ?>
        </div>

        <?php if (!Yii::$app->request->isAjax) { ?>
            <div class="form-group">
                <br>
                <?= Html::submitButton(Yii::t('app','Add'), ['class' => 'btn btn-success']) ?>
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
            <th class="kv-merged-header"></th>
            <th class="kv-merged-header"><?= Yii::t('app','Id') ?></th>
            <th class="kv-merged-header"><?= Yii::t('app','Category name') ?></th>
            <th class="kv-merged-header text-center"><?= Yii::t('app','Actions') ?></th>
            </thead>
            <tbody>
            <?php
            foreach ($categoriesRequest as $categoryRequest) {
                ?>
                <tr>
                    <td>
                        <input class="checkbox" type="checkbox" value="<?= $categoryRequest['category_id'] ?>">
                    </td>
                    <td>
                        <?= $categoryRequest['category_id'] ?>

                    </td>
                    <td>
                        <?php
                        $category =Category::findOne($categoryRequest['category_id']);
                        echo $category->name;
                        ?>
                    </td>
                    <td class="text-center" style="width: 10%;">
                        <?=
                        Html::a(Yii::t('app', '<i class="glyphicon glyphicon-remove"></i>'),
                            ['unasign-category', 'r_id' => $request->id, 'c_id' => $categoryRequest['category_id']],
                            [
                                'class' => 'btn btn-small',
                                'data-toggle'=> 'tooltip',
                                'title'=>Yii::t('app', 'Remove category'),
                                'data-confirm' =>Yii::t('app', '¿Are you sure you want to unassign this category?'),
                            ])
                        ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

</div>
