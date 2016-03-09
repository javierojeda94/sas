<?php
use yii\helpers\Html;
use johnitvn\ajaxcrud\CrudAsset;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ReportForm*/

$this->title = Yii::t('app', 'Reports attended');
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="reports-attended-index">
    <div id="form-Attend">
        <?php $form = ActiveForm::begin() ?>

        <?= $form->field($model, 'startDate')->widget(DatePicker::classname(), [
            'dateFormat' => 'yyyy-MM-dd',
        ]) ?>

        <?= $form->field($model, 'endDate')->widget(DatePicker::classname(), [
            'dateFormat' => 'yyyy-MM-dd',
        ]) ?>

        <p class="form-group">
            <?= Html::submitButton('Attend', ['class' => 'btn btn-success']) ?>
        </p>

        <?php ActiveForm::end(); ?>
    </div>
</div>
