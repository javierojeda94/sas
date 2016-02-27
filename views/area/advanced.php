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
?>
<div class="request-advanced">

    <h1>Area's personal: <?= $area->id ?></h1>

    <div class="users-request-input request-form row">

        <?php $form = ActiveForm::begin(['action' => "add"]); ?>

        <?= $form->field($area, 'area_id')->hiddenInput(['value'=> $area->id])->label(false) ?>

        <div class="col-md-4">
            <?= $form->field($area, 'id_responsable')->dropDownList($available_users,['class' => 'form-control']) ?>
        </div>

        <?php if (empty($available_users)){ ?>
            <div class="form-group">
                <br>
                <?= Html::button('Add', ['class' => 'btn btn-success disabled']) ?>
            </div>
        <?php }else{ ?>
            <div class="form-group">
                <br>
                <?= Html::submitButton('Add', ['class' => 'btn btn-success']) ?>
            </div>
        <?php } ?>

        <?php ActiveForm::end(); ?>
    </div>

    <div>

        <div class="input-group">
            <span class="input-group-addon">Filtro</span>
            <input id="filter" type="text" class="form-control" placeholder="Busca a un usuario...">
        </div>

        <table width="100%" border="1px solid grey" class="kv-grid-table table table-bordered table-striped table-condensed kv-table-wrap">
            <thead>
                <th class="kv-align-center kv-align-middle kv-merged-header"></th>
                <th class="kv-align-center kv-align-middle kv-merged-header">Id</th>
                <th class="kv-align-center kv-align-middle kv-merged-header">Nombre</th>
                <th class="kv-align-center kv-align-middle kv-merged-header">Apellido</th>
                <th class="kv-align-center kv-align-middle kv-merged-header">Permisos</th>
                <th class="kv-align-center kv-align-middle kv-merged-header">Actions</th>
            </thead>
            <tbody class="searchable">
                <?php foreach($personal as $pers){

                     ?>
                <tr>
                    <td>
                        <input class="checkbox" type="checkbox" value="<?= $pers['user_id'] ?>">
                    </td>
                    <td class="skip-export kv-align-center kv-align-middle">
                        <?= $pers['user_id'] ?>
                    </td>
                    <td class="skip-export kv-align-center kv-align-middle">
                        <?php
                        $user = User::findOne($pers["user_id"]);
                        echo $user->first_name;
                        ?>
                    </td>
                    <td class="skip-export kv-align-center kv-align-middle">
                        <?php
                        echo $user->lastname;
                        ?>
                    </td>
                    <td class="skip-export kv-align-center kv-align-middle">
                        <?php
                        $relationship = AreaPersonal::find()->where(['user_id'=>$pers['user_id'],
                            'area_id'=>$area->id])->one();
                        echo $relationship->permission;
                        ?>
                    </td>
                    <td class="skip-export kv-align-center kv-align-middle">
                        <a data-toggle="modal" data-target="#permissionsModal"
                           data-user-id="<?= $user->id ?>" data-area-id="<?= $area->id ?>">
                            <span data-toggle="tooltip" title="Modify permission"
                                  class="glyphicon glyphicon-pencil"></span>
                        </a>
                        <a href="remove?u_id=<?=$user->id?>&a_id=<?=$area->id?>"
                           data-toggle="tooltip" title="Remove user"
                           data-confirm="Seguro que quieres remover este usuario?">
                           <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
        if(!empty($personal)){
            echo Html::a(Yii::t('app', 'Unasign '),
                ['remove', 'r_id' => $area->id],
                ['id' => 'unasign_several-from-area',
                'data-request' => $area->id,
                'class' => 'btn btn-info',]
            );
        }
        ?>
    </div>

</div>

<?php
    require('permissions.php');
?>