<?php
use yii\helpers\Html;
use johnitvn\ajaxcrud\CrudAsset;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ReportForm*/

$this->title = Yii::t('app', 'Reports by poll');
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

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

<div class="reports-attended-form">
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

        <p class="form-group">
            <?= Html::submitButton('Make report', ['class' => 'btn btn-success']) ?>
        </p>

        <?php ActiveForm::end(); ?>
    </div>
</div>
