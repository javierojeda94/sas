<?php
use sintret\chat\ChatRoom;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\request */

$this->title = Yii::t('app', $model->subject);
$this->params['breadcrumbs'][] = ['label' => 'Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', $this->title);//$this->title;

?>
<div class="request-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-9">
            <?= (Yii::$app->user->can('create_scheduled_requests') || Yii::$app->user->can('assign_request_to_personal_of_own_area') && $model->status != 'Finalizado') ?
                Html::a(Yii::t('app', 'Advanced options'), ['advanced', 'id' => $model->id], ['class' => 'btn btn-primary']) : "" ?>

            <?php if ((Yii::$app->user->can('reject_requests_in_own_area') || Yii::$app->user->can('reject_requests_assigned_to_self', ['request' => $model])) &&
                $model->status != 'Finalizado'
            ) {
                if ($model->status != 'Rechazado') { ?>
                    <?= Html::a(Yii::t('app', 'Reject Request'), ['reject', 'id' => $model->id],
                        ['data-confirm' => Yii::t('app','Are you sure you want to reject this request?'), 'class' => 'btn btn-primary']) ?>
                <?php } else { ?>
                    <?= Html::a(Yii::t('app', 'authorize request'), ['authorize', 'id' => $model->id],
                        ['data-confirm' => Yii::t('app','Are you sure you want to authorize this request?'), 'class' => 'btn btn-primary']) ?>
                <?php }
            } ?>
        </div>
        <div class="col-md-3">
            <?php if ($model->status != 'Atendiendo' && $model->status != 'Finalizado' &&
                Yii::$app->user->can('attend_requests_assigned_to_self', ['request' => $model])
            ) { ?>
                <p>
                    <?= Html::a(Yii::t('app', 'Attend request'), ['attend', 'id' => $model->id],
                        [
                            'class' => 'btn btn-primary pull-right',
                            'data-confirm' => Yii::t('app','Are you sure you want to attend this request?'),
                        ]) ?>
                </p>
            <?php } ?>

            <?php if ($model->status == 'Atendiendo' && $model->status != 'Finalizado') { ?>
                <p>
                    <?php if (Yii::$app->user->can('attend_requests_assigned_to_self', ['request' => $model])) { ?>
                        <?= Html::a(Yii::t('app', '<i class="glyphicon glyphicon-ok"></i> Finalizar Solicitud'), ['complete', 'id' => $model->id],
                            [
                                'class' => 'btn btn-success pull-right',
                                'data-confirm' => Yii::t('app','Are you sure you want to end this request?'),
                            ]) ?>
                    <?php } ?>
                </p>
            <?php } ?>
        </div>
    </div>
    <br>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => Yii::t('app','Area'),
                'value' => isset($model->area) ? $model->area->name : "",
            ],
            [
                'label' => Yii::t('app','Name'),
                'value' => $model->name,
            ],
            [
                'label' => Yii::t('app','Email'),
                'value' => $model->email,
            ],
            [
                'label' => Yii::t('app','Responsable'),
                'value' => strlen($responsible) > 0 ? $responsible : Yii::t('app','Not assigned'),
            ],
            [
                'label' => Yii::t('app','Subject'),
                'value' => $model->subject,
            ],
            [
                'label' => Yii::t('app','Description'),
                'value' => $model->description,
            ],
            [
                'label' => Yii::t('app','Creation Date'),
                'value' => $model->creation_date,
            ],
            [
                'label' => Yii::t('app','Status'),
                'value' => $model->status,
            ],
            [
                'label' => Yii::t('app','Start Date'),
                'value' => $model->scheduled_start_date,
            ],
            [
                'label' => Yii::t('app','End Date'),
                'value' => $model->scheduled_end_date,
            ],
        ],
    ]) ?>
    <?php if ($model->status == 'Atendiendo' && $model->status != 'Finalizado') { ?>
    <div>
        <?= ChatRoom::widget([
                'url' => \yii\helpers\Url::toRoute(['/request/chat']),
                //'requestModel'=> \app\models\Request::className(),
                'userModel' => \app\models\User::className(),
                'userField' => 'avatarImage',
                'idRequest' => $model->id,
                'userName' => $model->name
            ]
        );
        ?>
    </div>
    <?php }?>

</div>
