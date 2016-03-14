<?php
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
                    'attribute'=>Yii::t('app','User'),
                    'value'=>'user.first_name'
                ],
                [

                    'class'=>'\kartik\grid\DataColumn',
                    'attribute'=>Yii::t('app','Area name'),
                    'value'=>'areaname'
                ],
                [

                    'class'=>'\kartik\grid\DataColumn',
                    'attribute'=>Yii::t('app','Count'),
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
                'heading' => '<h4><i class="glyphicon glyphicon-list"></i> '.
                    Yii::t('app','Requests attended by personal of are')
                    .'</h4>',
            ]
        ]) ?>
    </div>
</div>
