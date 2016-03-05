<?php
use app\models\ReportForm;
use kartik\tabs\TabsX;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Reports');
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
    <div class="report-index">
        <div id="tab">
            <?= TabsX::widget([
                'items' => [
                    [
                        'label'=>'<i class="glyphicon glyphicon-home"></i> Reports by request',
                        'content'=>"", //$this->render('exportCSV', ['model' => new ReportForm()]),
                        'active'=>true,
                        'linkOptions'=>['data-url'=>Url::to(['/report/request-report'])]
                    ],
                    [
                        'label'=>'<i class="glyphicon glyphicon-user"></i> Reporst by poll',
                        'linkOptions'=>['data-url'=>Url::to(['/report/report-poll'])],
                        //'visible' => Yii::$app->user->can('read_requests_created'),
                    ],
                    [
                        'label'=>'<i class="glyphicon glyphicon-user"></i> Advanced options',
                        'linkOptions'=>['data-url'=>Url::to(['/report/export'])],
                        //'visible' => Yii::$app->user->can('read_requests_in_own_area'),
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