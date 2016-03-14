<?php
use app\models\AreaPersonal;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Reports attended');
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="reports-attended-index">
    <div id="gridView">
        <?= GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'pjax'=>true,
            'columns' => [
                [
                    'class' => 'kartik\grid\SerialColumn',
                    'width' => '30px',
                ],
                [

                    'class'=>'\kartik\grid\DataColumn',
                    'attribute'=>'User',
                    //'value'=>'user.first_name'
                    'value' => function($model){
                        return $model->user->first_name;
                    }
                ],
                [

                    'class'=>'\kartik\grid\DataColumn',
                    'attribute'=>'Area name',
                    //'value'=>'areaname'
                    'value' => function($model){
                        return $model->request->area->name;
                    }
                ],
                [

                    'class'=>'\kartik\grid\DataColumn',
                    'attribute'=>'Count',
                    'value'=>'cnt'
                ],
            ],
            'toolbar'=> [

            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'panel' => [
                'type' => 'default',
                'heading' => '<h4><i class="glyphicon glyphicon-list"></i> Requests attended by personal of area</h4>',
            ]
        ]) ?>
    </div>
</div>
