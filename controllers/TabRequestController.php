<?php
/**
 * Created by PhpStorm.
 * User: Kev'
 * Date: 04/03/2016
 * Time: 05:32 PM
 */

namespace app\controllers;


use app\models\Area;
use app\models\Request;
use app\models\RequestSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;

class TabRequestController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['tab-my-request'],
                        'roles' => ['administrator', 'responsibleArea','executive','employeeArea','@','?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['tab-request-assigned'],
                        'roles' => ['responsibleArea', 'administrator', 'employeeArea','executive'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['tab-request-area'],
                        'roles' => ['responsibleArea', 'administrator','executive'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['tab-all-request', 'tab-scheduled'],
                        'roles' => ['administrator','executive'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionTabMyRequest(){
        $searchModel = new RequestSearch();
        $query = Request::find()->where(['user_id' => Yii::$app->user->id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $query);
        $html = $this->renderPartial('GridViewMyRequest', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider,]);

        return JSON::encode($html);
    }

    public function actionTabRequestAssigned(){
        $searchModel = new RequestSearch();
        $query = Request::find()->joinWith('usersRequests')->where(['users_request.user_id' => Yii::$app->user->id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $query);
        $html = $this->renderPartial('GridViewRequestAssigned', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider,]);

        return JSON::encode($html);
    }

    public function actionTabRequestArea(){
        $searchModel = new RequestSearch();
        $area = Area::find()->where(['id_responsable' => Yii::$app->user->id])->one();
        $query = Request::find()->joinWith('areasRequests')->where(['areas_request.area_id' => $area->id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $query);
        $html = $this->renderPartial('GridViewRequestForArea', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider,]);

        return JSON::encode($html);
    }

    public function actionTabAllRequest(){
        $searchModel = new RequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, null);
        $html = $this->renderPartial('GridViewAllRequest', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider,]);

        return JSON::encode($html);
    }

    public function actionTabScheduled(){
        $searchModel = new RequestSearch();
        $query = Request::find()->where(['status' => 'Calendarizada']);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $query);
        $html = $this->renderPartial('GridViewRequestScheduled', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider,]);

        return JSON::encode($html);
    }
}