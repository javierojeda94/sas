<?php
use app\models\Category;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Area;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\request */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="request-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(Yii::t('app', 'Name')) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label(Yii::t('app','Email')) ?>

    <?= $form->field($model, 'area_id')->dropDownList( ArrayHelper::map(
        Area::find()->all(),
        'id',
        'name'
    ), ['prompt' => '', 'onchange'=>'$.get( "'.Url::toRoute('/category/lists').'", { id: $(this).val() } )
            .done(function( data ) {
					$( "#'.Html::getInputId($model, 'category_id').'" ).html( data );
				}
            );'])->label(Yii::t('app', 'Area'))
    ?>

    <?= $form->field($model, 'category_id')->dropDownList(
        ArrayHelper::map(
            Category::find()->all(),
            'id',
            'name'
        ), array('prompt'=> ""))->label(Yii::t('app','Category')) ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true])->label(Yii::t('app','Subject')) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6])->label(Yii::t('app','Description')) ?>

    <?= $form->field($model, 'requestFiles[]')->fileInput(['multiple' => true])->label(Yii::t('app','Request files')) ?>


    <?php if(Yii::$app->user->isGuest) {
        $model->setScenario('captchaRequired');
        ?>
    <?= $form->field($model, 'verifyCode')->widget(
        Captcha::className(), [
        'template' => '<div class="row"><div class="col-lg-1.5">{image}</div><div class="col-lg-2">{input}</div></div>',
    ])->label(Yii::t('app','Captcha')) ?>

    <?php } ?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
