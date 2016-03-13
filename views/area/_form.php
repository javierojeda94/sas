<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Area;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Area */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="area-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'area_id')->dropDownList(
        ArrayHelper::map(Area::find()->all(), 'id', 'name'),
        array('prompt' => ''))->label(Yii::t('app', 'Area')) ?>

    <?= $form->field($model, 'id_responsable')->dropDownList(
        ArrayHelper::map(User::find()->all(), 'id', 'first_name'),
        array('prompt' => ''))->label(Yii::t('app','Area responsable')) ?>

    <?= $form->field($model, 'name')->textInput(
        ['maxlength' => true])->label(Yii::t('app','Name')) ?>

    <?= $form->field($model, 'description')->textInput(
        ['maxlength' => true])->label(Yii::t('app','Description')) ?>


    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
                ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>
