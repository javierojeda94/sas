<?php
use yii\helpers\Html;
use johnitvn\ajaxcrud\CrudAsset;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ReportForm*/

$this->title = Yii::t('app', 'Report based on requests by category');
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="reports-by-category-index container">
    <h2 class="page-header"><small><?php echo Yii::t('app','Based on requests by category')?></small></h2>

    <div id="form-Attend">
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'options' => ['class' => 'form-horizontal', 'role' => 'form'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ],
        ]) ?>

        <?= $form->field($model, 'startDate')->widget(DatePicker::classname(), [
            'dateFormat' => 'yyyy-MM-dd',
        ]) ?>

        <?= $form->field($model, 'endDate')->widget(DatePicker::classname(), [
            'dateFormat' => 'yyyy-MM-dd',
        ]) ?>

        <div>
            <?= Html::submitButton('Generate report', ['class' => 'btn btn-primary btn-margin']) ?>
        </div>

        <?php if(isset($error)){ ?>
            <br>
            <br>
        <div class="alert alert-danger">
            <?= $error ?>
        </div>
        <?php } ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>
