<?php
/**
 * Created by PhpStorm.
 * User: cs_ab_000
 * Date: 11/03/2016
 * Time: 12:35 PM
 */
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
<div class="reports-by-requestuser-index container">
    <h2 class="page-header"><small><?php echo Yii::t('app','Based on users requests')?></small></h2>
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
        ])->label(Yii::t('app','Start Date')) ?>

        <?= $form->field($model, 'endDate')->widget(DatePicker::classname(), [
            'dateFormat' => 'yyyy-MM-dd',
        ])->label(Yii::t('app','End Date')) ?>

        <div>
            <?= Html::submitButton(Yii::t('app','Generate report'), ['class' => 'btn btn-primary btn-margin']) ?>
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
