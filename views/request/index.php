<?php
use kartik\tabs\TabsX;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Requests');
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="request-index">
    <div id="tab">
        <?= TabsX::widget([
            'items' => [
                [
                    'label'=>'<i class="glyphicon glyphicon-home"></i> My request',
                    'content'=>$this->render('GridViewMyRequest', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider,]),
                    'active'=>true,
                    'linkOptions'=>['data-url'=>Url::to(['/request/tab?tab=1'])]
                ],
                [
                    'label'=>'<i class="glyphicon glyphicon-user"></i> Request Assigned',
                    'linkOptions'=>['data-url'=>Url::to(['/request/tab?tab=2'])]
                ],
                [
                    'label'=>'<i class="glyphicon glyphicon-user"></i> Request For My Area',
                    'linkOptions'=>['data-url'=>Url::to(['/request/tab?tab=3'])]
                ],
                [
                    'label'=>'<i class="glyphicon glyphicon-user"></i> All Request',
                    'linkOptions'=>['data-url'=>Url::to(['/request/tab?tab=4'])]
                ],
                [
                    'label'=>'<i class="glyphicon glyphicon-user"></i> Scheduled Request',
                    'linkOptions'=>['data-url'=>Url::to(['/request/tab?tab=5'])]
                ],
            ],
            'position' => TabsX::POS_ABOVE,
            'encodeLabels' => false,
            'pluginOptions' => [
                'enableCache' => true,
            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
