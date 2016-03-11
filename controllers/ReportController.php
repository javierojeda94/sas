<?php
/**
 * Created by PhpStorm.
 * User: Kev'
 * Date: 05/03/2016
 * Time: 12:22 PM
 */

namespace app\controllers;


use app\models\ReportForm;
use app\models\Request;
use app\models\UsersRequest;
use app\models\UsersRequestSearch;
use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;

class ReportController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
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
            $init = $model->dateInit;
            $finish = $model->dateFinish;

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
            $html = $this->renderAjax('exportCSV', ['model' => $model]);
            return JSON::encode($html);
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
                'allModels' => UsersRequest::find()->select(['*','areas.name AS areaname', 'COUNT(*) AS cnt'])->join('JOIN','areas')
                    ->join('JOIN','request')->Where(['between', 'request.completion_date', $model->startDate, $model->endDate])
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
}