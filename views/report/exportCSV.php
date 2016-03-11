<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ReportForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app', 'Reports');
$this->params['breadcrumbs'][] = Yii::t('app', 'Reports');
?>

<?php $this->registerJs('
    $(\'#w0\').on(\'submit\', function(e) {
        var dateInit = $(\'#reportform-startdate\').val();
        var dateFinish = $(\'#reportform-enddate\').val();

        if (!/Invalid|NaN/.test(new Date(dateInit))) {
            if(new Date(dateFinish) > new Date(dateInit)){
                return true;
            }else{
                alert("Porfavor ingrese bien la fecha");
                return false;
            }
        }else{
            alert(\'Date not valid\');
            return false;
        }
    });
'); ?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="reports-form">
    <h4>Export CSV</h4>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal', 'role' => 'form'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]) ?>

    <?= $form->field($model, 'startDate')->widget(\yii\jui\DatePicker::classname(), [
        'dateFormat' => 'yyyy-MM-dd',
    ]) ?>

    <?= $form->field($model, 'endDate')->widget(\yii\jui\DatePicker::classname(), [
        'dateFormat' => 'yyyy-MM-dd',
    ]) ?>

    <p class="form-group">
        <?= Html::submitButton('Export', ['class' => 'btn btn-success']) ?>
    </p>

    <?php ActiveForm::end(); ?>

    <!--<?= Html::a(Yii::t('app','Export CSV'), ['export'], ['class' => 'btn btn-success']) ?> -->
</div>
