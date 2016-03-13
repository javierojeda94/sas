<?php

use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use app\models\User;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\request */
?>
<div class="modal fade" id="permissionsModal" tabindex="-1" role="dialog" aria-labelledby="permissionsModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="permissionsModalLabel"><?php echo Yii::t('app', 'Permissions')?></h4>
            </div>
            <?php $form = ActiveForm::begin(['action' => "addpermission"]); ?>
            <div class="modal-body">
                <h4 id="area_name">Area:</h4>
                <h4 id="personal_name">Personal:</h4>
                <input type="hidden" id="areapersonal-user_id" name="AreaPersonal[user_id]">
                <input type="hidden" id="areapersonal-area_id" name="AreaPersonal[area_id]">
                <label for="areapersonal-permission">Permission</label>
                <select required id="areapersonal-permission" class="form-control" name="AreaPersonal[permission]">
                    <option value="0" selected disabled><?php echo Yii::t('app', 'Selection')?></option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>