<?php
/**
 * Created by PhpStorm.
 * User: Kev'
 * Date: 05/03/2016
 * Time: 12:22 PM
 */

namespace app\controllers;


use app\models\importForm;
use app\models\ReportForm;
use app\models\Request;
use app\models\UsersRequest;
use app\models\CategoryRequest;
use app\models\AreasRequest;
use app\models\UsersRequestSearch;
use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use DateTime;

class ReportController extends Controller
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
                        'actions' => ['index','export', 'attended','areas','categories','user','polls',
                            'import'],
                        'roles' => ['administrator', 'responsibleArea','executive'],
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

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionExport()
    {
        $model = new ReportForm();

        if ($model->load(Yii::$app->request->post()) && $model) {
            $init = $model->startDate;
            $finish = $model->endDate;

            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=data.csv');

            // create a file pointer connected to the output stream
            $output = fopen('php://output', 'w');

            // output the column headings
            fputcsv($output, array('tid', 'firstname', 'lastname', 'email', 'emailstatus', 'token', 'language', 'validfrom', 'validuntil',
                'invited', 'reminded', 'remindercount', 'completed', 'usesleft', 'attribute_1 <ID_Reporte>', 'attribute_2 <Categoría>',
                'attribute_3 <Área>', 'attribute_4 <Título>', 'attribute_5 <dtSolicitud>'));

            // fetch the data
            $rows = Request::find()->andFilterWhere(['between', 'creation_date', $init, $finish])->all();

            // loop over the rows, outputting them
            foreach ($rows as $row) {
                $request = $this->findModel($row->getAttribute('id'));

                $data = array(
                    $row->getAttribute('id'),
                    $row->getAttribute('name'),
                    '\'\'',
                    $row->getAttribute('email'),
                    'OK',
                    '\'\'',
                    'es',
                    '\'\'',
                    '\'\'',
                    'N',
                    'N',
                    $row->getAttribute('status'),
                    'N',
                    '1',
                    $row->getAttribute('id'),
                    $request->getStringOfCategories(),
                    $request->area->name,
                    $row->getAttribute('subject'),
                    $row->getAttribute('description'));

                fputcsv($output, $data);
            }

            fclose($output);
        } else {
            return $this->render('exportCSV', ['model' => $model]);
            //return JSON::encode($html);
        }
    }

    public function actionAttended()
    {
        if(Yii::$app->request->isAjax){
            $model = new ReportForm();

            //$query = UsersRequest::find()->joinWith('request')->Where(['>=', 'completion_date', $model->startDate])
            //    ->andWhere(['<=', 'completion_date', $model->endDate])->groupBy('user_id');
            //$dataProvider = $searchModel->search(Yii::$app->request->queryParams, $query);

            $html = $this->renderAjax('reportsAttendedForm', [
                'model' => $model,
            ]);

            return JSON::encode($html);
        }else{
            $model = new ReportForm();
            $request = Yii::$app->request;
            $model->load($request->post());

            $dataProvider = new ArrayDataProvider([
                'allModels' => UsersRequest::find()->select(['users_request.request_id', 'users_request.user_id', 'COUNT(*) AS cnt'])
                    ->Join('JOIN','request')
                    ->Where(['between', 'request.completion_date', $model->startDate, $model->endDate])
                    ->groupBy('users_request.user_id')->all(),
                'pagination' => [
                    'pageSize' => 20,
                ],
            ]);

            return $this->render('reportsAttendedGrid', [
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionAreas()
    {
        if(Yii::$app->request->isAjax){
            $model = new ReportForm();

            $html = $this->renderAjax('reportsByAreaForm', [
                'model' => $model,
            ]);

            return JSON::encode($html);
        }else{
            $model = new ReportForm();
            $request = Yii::$app->request;
            $model->load($request->post());
            $start = new DateTime($model->startDate);
            $end = new DateTime($model->endDate);
            if($start <= $end){
                $dataProvider = new ArrayDataProvider([
                    'allModels' => AreasRequest::find()
                        ->select(['areas.name AS areaname', 'COUNT(`areas_request`.`area_id`) AS cnt'])
                        ->leftJoin('areas','areas_request.area_id = areas.id')
                        ->leftJoin('request','areas_request.request_id = request.id')
                        ->Where(['between', 'request.creation_date', $model->startDate, $model->endDate])
                        ->groupBy('areas_request.area_id')
                        ->all(),
                    'pagination' => [
                        'pageSize' => 20,
                    ],
                ]);
                if($dataProvider->count == 0){
                    return $this->render('reportsByAreaForm', [
                        'model' => $model,
                        'error' => 'No existen datos para generar el reporte'
                    ]);
                }
                return $this->render('reportsByAreaGrid', [
                    'dataProvider' => $dataProvider,
                ]);
            }
            else{
                return $this->render('reportsByAreaForm', [
                    'model' => $model,
                    'error' => 'Las fechas son incorrectas'
                ]);
            }

        }
    }

    public function actionCategories()
    {
        if(Yii::$app->request->isAjax){
            $model = new ReportForm();

            $html = $this->renderAjax('reportsByCategoryForm', [
                'model' => $model,
            ]);

            return JSON::encode($html);
        }else{
            $model = new ReportForm();
            $request = Yii::$app->request;
            $model->load($request->post());
            $start = new DateTime($model->startDate);
            $end = new DateTime($model->endDate);
            if($start <= $end){
                $dataProvider = new ArrayDataProvider([
                    'allModels' => CategoryRequest::find()
                        ->select(['categories.name AS categoryname', 'COUNT(`category_request`.`category_id`) AS cnt'])
                        ->leftJoin('categories','category_request.category_id = categories.id')
                        ->leftJoin('request','category_request.request_id = request.id')
                        ->Where(['between', 'request.creation_date', $model->startDate, $model->endDate])
                        ->groupBy('category_request.category_id')
                        ->all(),
                    'pagination' => [
                        'pageSize' => 20,
                    ],
                ]);
                if($dataProvider->count == 0){
                    return $this->render('reportsByCategoryForm', [
                        'model' => $model,
                        'error' => 'No existen datos para generar el reporte'
                    ]);
                }
                return $this->render('reportsByCategoryGrid', [
                    'dataProvider' => $dataProvider,
                ]);
            }
            else{
                return $this->render('reportsByCategoryForm', [
                    'model' => $model,
                    'error' => 'Las fechas son incorrectas'
                ]);
            }

        }
    }

    public function actionUser()
    {

        if(Yii::$app->request->isAjax){
            $model = new ReportForm();
            $html = $this->renderAjax('reportsUserForm', [
                'model' => $model,
            ]);

            return JSON::encode($html);
        }else{
            $model = new ReportForm();
            $request = Yii::$app->request;
            $model->load($request->post());

            $dataProvider = new ArrayDataProvider([
                'allModels' => Request::find()->select(['*', 'COUNT(*) AS cnt'])
                    ->Where(['between', 'creation_date', $model->startDate, $model->endDate])
                    ->groupBy('name')->all(),
                'pagination' => [
                    'pageSize' => 20,
                ],
            ]);

            return $this->render('reportsUserGrid', [
                'dataProvider' => $dataProvider,
            ]);
        }

    }
    public function actionPolls()
    {
        if(Yii::$app->request->isAjax){
            $model = new ReportForm();

            $html = $this->renderAjax('reportsByPollForm', [
                'model' => $model,
            ]);

            return JSON::encode($html);
        }else{
            $model = new ReportForm();
            $request = Yii::$app->request;
            $model->load($request->post());

            $dataProvider = new ArrayDataProvider([
                'allModels' => Request::find()->Where(['between', 'request.completion_date', $model->startDate, $model->endDate])->all(),
                'pagination' => [
                    'pageSize' => 20,
                ],
            ]);

            return $this->render('reportsByPoll', [
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionImport(){
        if(Yii::$app->request->isGet){
            $model = new importForm();

            //$query = UsersRequest::find()->joinWith('request')->Where(['>=', 'completion_date', $model->startDate])
            //    ->andWhere(['<=', 'completion_date', $model->endDate])->groupBy('user_id');
            //$dataProvider = $searchModel->search(Yii::$app->request->queryParams, $query);

            return $this->render('importForm', [
                'model' => $model,
            ]);
        }else{
            $model = new importForm();
            //$model->load(Yii::$app->request->post());

            $model->csv = UploadedFile::getInstance($model, 'csv');

            if($model->upload()){
                $i=0; $keys=array();$output=array();
                $handle=fopen("uploads/".$model->csv, "r");
                if ($handle){
                    while(($line = fgetcsv($handle)) !== false) {
                        $i++;
                        if ($i==1) {
                            $keys=$line;
                        }
                        elseif ($i>1){
                            $attr=array();
                            foreach($line as $k=>$v){
                                $attr[$keys[$k]]=$v;
                            }
                            $output[]=$attr;
                        }
                    }
                    fclose($handle);
                }

                $this->saveData($output);
                return $this->render('index');
            }

            return $this->render('index');
        }
    }


    private function saveData($data){
        foreach($data as $line){
            $request = $this->findModel($line['id']);
            $request->satisfaccion = $line['satisfaccion'];
            $request->level = $line['level'];
            $request->save();
        }
    }

    /**
     * Finds the Request model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Request the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Request::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}