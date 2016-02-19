<?php

namespace app\controllers;

use app\models\AreasRequest;
use app\models\CategoryRequest;
use Yii;
use app\models\Request;
use app\models\User;
use app\models\UsersRequest;
use app\models\RequestSearch;
use app\models\UsersRequestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * RequestController implements the CRUD actions for request model.
 */
class RequestController extends Controller
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

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Lists all request models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new RequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single request model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "request #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new request model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $areasRequest = new AreasRequest();
        $categoryRequest = new CategoryRequest();
        $model = new Request();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                $model = $this->completeModel($model);

                return [
                    'title'=> "Create new request",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                $areasRequest->request_id = $model->id;
                $areasRequest->area_id = $model->area_id;

                $categoryRequest->request_id = $model->id;
                $categoryRequest->category_id = $model->category_id;

                if (!empty($model->category_id) || $model->category_id != 0) {
                    $categoryRequest->save();
                }

                $areasRequest->save();

                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new request",
                    'content'=>'<span class="text-success">Create request success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{
                $model = $this->completeModel($model);

                return [
                    'title'=> "Create new request",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                $areasRequest->request_id = $model->id;
                $areasRequest->area_id = $model->area_id;

                $categoryRequest->request_id = $model->id;
                $categoryRequest->category_id = $model->category_id;

                if (!empty($model->category_id) || $model->category_id != 0) {
                    $categoryRequest->save();
                }

                $areasRequest->save();

                if(Yii::$app->user->isGuest){
                    Yii::$app->session->setFlash('requestFormSubmitted');
                    return $this->refresh();
                }else{
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                $model = $this->completeModel($model);

                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing request model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update request #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "request #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update request #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing request model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing request model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionBulkDelete()
    {        
        $request = Yii::$app->request;
        $pks = $request->post('pks'); // Array or selected records primary keys
        foreach (request::findAll(json_decode($pks)) as $model) {
            $model->delete();
        }
        

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Reject an existing request model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionReject($id){

        $request = Yii::$app->request;

        if(!Yii::$app->user->isGuest){
            $specificRequest = $this->findModel($id);
            $specificRequest->status = "Rechazado";
            $specificRequest->save();

            if($request->isAjax){
                /*
                *   Process for ajax request
                */
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
            }else{
                /*
                *   Process for non-ajax request
                */
                return $this->redirect(['index']);
            }
        }else{
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Authorize a rejected request model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionAuthorize($id){

        $request = Yii::$app->request;

        if(!Yii::$app->user->isGuest){
            $specificRequest = $this->findModel($id);
            $specificRequest->status = "Autorizada";
            $specificRequest->save();

            if($request->isAjax){
                /*
                *   Process for ajax request
                */
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
            }else{
                /*
                *   Process for non-ajax request
                */
                return $this->redirect(['index']);
            }
        }else{
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Show advanced options for a request model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionAdvanced($id){

        $request = Yii::$app->request;

        if(!Yii::$app->user->isGuest){
            $specificRequest = $this->findModel($id);

            if($request->isAjax){
                /*
                *   Process for ajax request
                */
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
            }else{
                /*
                *   Process for non-ajax request
                */
                $users = ArrayHelper::map(User::find()->all(),'id', ['first_name']);
                $searchModel = new UsersRequestSearch();
                $dataProvider = $searchModel->search(['request_id' => $id]);
                return $this->render('advanced', [
                    'request' => $specificRequest,
                    'users' => $users,
                    'dataProvider' => $dataProvider,
                ]);
            }
        }else{
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Assign a responsible for the request.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionAsign(){
        $request = Yii::$app->request;
        $model = new UsersRequest();
        $model->user_id = $request->post()['Request']['user_id'];
        $model->request_id = $request->post()['Request']['request_id'];
        $model->save();
        return $this->redirect('advanced?id='.$model->request_id);
    }

    /**
     * Unassign a responsible for the request.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUnasign($u_id, $r_id){
        $model = UsersRequest::find()->where(['user_id'=>$u_id,'request_id'=>$r_id])->one();
        $model->delete();
        return $this->redirect('advanced?id='.$r_id);
    }

    /**
     * Finds the request model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return request the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = request::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $id
     * @return User
     */
    protected function findUserModel($id){
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            return null;
        }
    }

    /**
     * @param $model Request
     * @return Request
     */
    private function completeModel($model){
       if(Yii::$app->user->isGuest){

       } else{
           $user = $this->findUserModel(Yii::$app->user->id);
           if($user != null) {
               $model->name = $user->first_name . " " . $user->lastname;
               $model->email = $user->email;
           }
       }

        return $model;
    }
}
