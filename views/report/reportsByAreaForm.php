<?php
use yii\helpers\Html;
use johnitvn\ajaxcrud\CrudAsset;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ReportForm*/

$this->title = Yii::t('app', 'Report based on requests by area');
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="reports-by-area-index">
    <div id="form-Attend">
        <?php $form = ActiveForm::begin() ?>

        <?= $form->field($model, 'startDate')->widget(DatePicker::classname(), [
            'dateFormat' => 'yyyy-MM-dd',
        ]) ?>

        <?= $form->field($model, 'endDate')->widget(DatePicker::classname(), [
            'dateFormat' => 'yyyy-MM-dd',
        ]) ?>

        <p class="form-group">
            <?= Html::submitButton('Generate', ['class' => 'btn btn-success']) ?>
        </p>

        <?php if(isset($error)){ ?>
        <div class="alert alert-danger">
            <?= $error ?>
        </div>
        <?php } ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>
