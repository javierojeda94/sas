<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Area;    
use app\models\Category;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList(
        ArrayHelper::map(
            Category::find()->all(),
            'id',
            'name'),array('prompt'=>'')) ?>

    <?= $form->field($model, 'id_area')->dropDownList(
        ArrayHelper::map(
            Area::find()->all(),
            'id',
            'name'),array('prompt'=>'')) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput([
        'maxlength' => true, 
        'required' => true]) ?>

    <?= $form->field($model, 'service_level_agreement_asignment')->dropDownList([
        '1' => '1', 
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5']) ?>

    <?= $form->field($model, 'service_level_agreement_completion')->dropDownList([
        '1' => '1', 
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5']) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
