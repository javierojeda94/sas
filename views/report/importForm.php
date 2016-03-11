<?php
use yii\helpers\Html;
use johnitvn\ajaxcrud\CrudAsset;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\importForm*/

$this->title = Yii::t('app', 'Import CSV');
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>

<div class="reports-attended-form">
    <div id="form-import">
        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
        ]) ?>

        <?= $form->field($model, 'csv')->fileInput() ?>

        <p class="form-group">
            <?= Html::submitButton('Import', ['class' => 'btn btn-success']) ?>
        </p>

        <?php ActiveForm::end(); ?>
    </div>
</div>
