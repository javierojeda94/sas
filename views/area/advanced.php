<?php

use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use app\models\User;
use app\models\AreaPersonal;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\request */

$this->title = Yii::t('app', 'Advanced Options');
$this->params['breadcrumbs'][] = ['label' => 'Areas', 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', $this->title);//$this->title;
?>
<div class="request-advanced container">

    <h1><i class="glyphicon glyphicon-cog"></i> <?=Yii::t('app', 'Area\'s personal:'.$area->id)?></h1>

    <div class="users-request-input request-form row">

        <?php $form = ActiveForm::begin(['action' => "add"]); ?>

        <?= $form->field($area, 'area_id')->hiddenInput(['value'=> $area->id])->label(false) ?>

        <div class="col-md-4">
            <?= $form->field($area, 'id_responsable')->dropDownList(
                $available_users,['class' => 'form-control'])->label(Yii::t('app','Area\'s personal')) ?>
        </div>

        <?php if (empty($available_users)){ ?>
            <div class="form-group">
                <br>
                <?= Html::button(Yii::t('app', 'Add'), ['class' => 'btn btn-success disabled']) ?>
            </div>
        <?php }else{ ?>
            <div class="form-group">
                <br>
                <?= Html::submitButton(Yii::t('app', 'Add'), ['class' => 'btn btn-success']) ?>
            </div>
        <?php } ?>

        <?php ActiveForm::end(); ?>
    </div>

    <div>
        <?php
        if(!empty($personal)){
            echo Html::a(Yii::t('app', 'Unassign All'),
                ['remove', 'r_id' => $area->id],
                ['id' => 'unasign_several-from-area',
                    'data-request' => $area->id,
                    'class' => 'btn btn-danger pull-right',]
            );
        }
        ?>
        <br>
        <br>
        <div class="input-group">
            <span class="input-group-addon"><?php echo Yii::t('app', 'Filter')?></span>
            <input id="filter" type="text" class="form-control" placeholder="<?php echo Yii::t('app', 'Search an user...')?>">
        </div>

        <table width="100%" border="1px solid grey" class="kv-grid-table table table-bordered table-striped table-condensed kv-table-wrap">
            <thead>
                <th></th>
                <th class="text-center"><?php echo Yii::t('app', 'ID')?></th>
                <th class="text-center"><?php echo Yii::t('app', 'Name')?></th>
                <th class="text-center"><?php echo Yii::t('app', 'Last name')?></th>
                <th class="text-center"><?php echo Yii::t('app', 'Permissions')?></th>
                <th class="text-center"><?php echo Yii::t('app', 'Actions')?></th>
            </thead>
            <tbody class="searchable">
                <?php foreach($personal as $pers){

                     ?>
                <tr>
                    <td class="text-center">
                        <input class="checkbox" type="checkbox" value="<?= $pers['user_id'] ?>">
                    </td>
                    <td class="text-center">
                        <?= $pers['user_id'] ?>
                    </td>
                    <td class="text-center">
                        <?php
                        $user = User::findOne($pers["user_id"]);
                        echo $user->first_name;
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                        echo $user->lastname;
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                        $relationship = AreaPersonal::find()->where(['user_id'=>$pers['user_id'],
                            'area_id'=>$area->id])->one();
                        echo $relationship->permission;
                        ?>
                    </td>
                    <td class="text-center">
                        <a data-toggle="modal" data-target="#permissionsModal"
                           data-user-id="<?= $user->id ?>" data-area-id="<?= $area->id ?>">
                            <span data-toggle="tooltip" title="<?php echo Yii::t('app', 'Modify permission')?>"
                                  class="glyphicon glyphicon-pencil"></span>
                        </a>
                        <a href="remove?u_id=<?=$user->id?>&a_id=<?=$area->id?>"
                           data-toggle="tooltip" title="<?php echo Yii::t('app', 'Remove user')?>"
                           data-confirm="<?php echo Yii::t('app', 'Are you sure you want to remove this user?')?>">
                           <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>

<?php
    require('permissions.php');
?>