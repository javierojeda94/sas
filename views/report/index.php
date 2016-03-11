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
                        'label'=>'<i class="glyphicon glyphicon-home"></i> Reports based on requests',
                        'items'=>[
                            [
                                'label'=>'Reports attended by personal of an area',
                                'encode'=>false,
                                'content'=>"Ningun reporte",
                                'linkOptions'=>['data-url'=>Url::to(['/report/attended'])]
                            ],
                            [
                                'label'=>'Reports by users',
                                'encode'=>false,
                                'content'=> "",
                            ],
                            [
                                'label' => 'Reports by area',
                                'encode' => false,
                                'content' => "",
                            ],
                            [
                                'label' => 'Reports by area',
                                'encode' => false,
                                'content' => "",
                            ],
                            [
                                'label' => 'Reports by category of an area',
                                'encode' => false,
                                'content' => "",
                            ],
                            [
                                'label' => 'Reports by area',
                                'encode' => false,
                                'content' => "",
                            ],
                        ],
                        'content'=>"", //$this->render('exportCSV', ['model' => new ReportForm()]),
                        'active'=>true,
                        'linkOptions'=>['data-url'=>Url::to(['/report/request-report'])]
                    ],
                    [
                        'label'=>'<i class="glyphicon glyphicon-user"></i> Reporst based on polls',
                        'linkOptions'=>['data-url'=>Url::to(['/report/polls'])]
                        //'visible' => Yii::$app->user->can('read_requests_created'),
                    ],
                    [
                        'label'=>'<i class="glyphicon glyphicon-user"></i> Advanced options',
                        'items' =>[
                            [
                                'label'=>'Export CSV',
                                'encode'=>false,
                                'content'=> Html::a('Export', ['export'], ['class'=>'btn btn-success pull-left']),
                            ],
                            [
                                'label'=>'Import CSV',
                                'encode'=>false,
                                'content'=> Html::a('Import', ['import'], ['class'=>'btn btn-success pull-left']),
                            ],
                        ],
                        'content'=>"Seleccione una opcion",
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