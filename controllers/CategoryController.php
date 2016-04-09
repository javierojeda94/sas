<?php

namespace app\controllers;

use Yii;
use app\models\Category;
use app\models\CategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
                        'actions' => ['create'],
                        'roles' => ['administrator','responsibleArea','executive'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['lists'],
                        'roles' => ['@', '?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['employeeArea','executive','responsibleArea','administrator'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['responsibleArea','executive','administrator'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['administrator','responsibleArea','executive'],
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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> Yii::t('app',"Category #").$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> 
                        Html::button(Yii::t('app','Close'), [
                            'class'=>'btn btn-default pull-left', 
                            'data-dismiss'=>"modal"
                        ]).
                        Html::a(Yii::t('app','Edit'), ['update','id'=>$id],  [
                            'class'=>'btn btn-primary',
                            'role'=>'modal-remote'
                        ])
                ];    
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new Category model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Category();  

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title'=> Yii::t('app',"Create new Category"),
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> 
                        Html::button(Yii::t('app','Close'), [
                            'class'=>'btn btn-default pull-left',
                            'data-dismiss'=>"modal"
                        ]).
                        Html::button(Yii::t('app','Save'), [
                            'class'=>'btn btn-primary',
                            'type'=>"submit"
                        ])
        
                ];         
            } else if (   $model->load($request->post()) 
                       && $model->save())    {
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> Yii::t('app',"Create new Category"),
                    'content'=>'<span class="text-success">'.Yii::t("app","Create Category success").'</span>',
                    'footer'=> 
                        Html::button(Yii::t('app','Close'), [
                            'class'=>'btn btn-default pull-left',
                            'data-dismiss'=>"modal"
                        ]).
                        Html::a(Yii::t('app','Create More'), ['create'], [
                            'class'=>'btn btn-primary',
                            'role'=>'modal-remote'
                        ])
        
                ];         
            }   else   {           
                return [
                    'title'=> Yii::t('app',"Create new Category"),
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> 
                        Html::button(Yii::t('app','Close'), [
                            'class'=>'btn btn-default pull-left',
                            'data-dismiss'=>"modal"
                        ]).
                        Html::button(Yii::t('app','Save'), [
                            'class'=>'btn btn-primary',
                            'type'=>"submit"
                        ])
        
                ];         
            }
        }   else   {
            /*
            *   Process for non-ajax request
            */
            if (   $model->load($request->post()) 
                && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing Category model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       

        if  ($request->isAjax)  {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if  ($request->isGet)  {
                return [
                    'title'=> Yii::t('app',"Update Category #").$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> 
                        Html::button(Yii::t('app','Close'), [
                            'class'=>'btn btn-default pull-left',
                            'data-dismiss'=>"modal"
                        ]).
                        Html::button(Yii::t('app','Save'), [
                            'class'=>'btn btn-primary',
                            'type'=>"submit"
                        ])
                ];         
            }  else if (  $model->load($request->post()) 
                       && $model->save())  {
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> Yii::t('app',"Category #").$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> 
                        Html::button(Yii::t('app','Close'), [
                            'class'=>'btn btn-default pull-left',
                            'data-dismiss'=>"modal"
                        ]).
                        Html::a(Yii::t('app','Edit'), ['update','id'=>$id], [
                            'class'=>'btn btn-primary',
                            'role'=>'modal-remote'
                        ])
                ];    
            }  else  {
                 return [
                    'title'=> Yii::t('app',"Update Category #").$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> 
                        Html::button(Yii::t('app','Close'), [
                            'class'=>'btn btn-default pull-left',
                            'data-dismiss'=>"modal"
                        ]).
                        Html::button(Yii::t('app','Save'), [
                            'class'=>'btn btn-primary',
                            'type'=>"submit"
                        ])
                ];        
            }
        }  else  {
            /*
            *   Process for non-ajax request
            */
            if (   $model->load($request->post()) 
                && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing Category model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        } else {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing Category model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {        
        $request = Yii::$app->request;
        $pks = $request->post('pks'); // Array or selected records primary keys
        foreach (Category::findAll(json_decode($pks)) as $model) {
            $model->delete();
        }
        

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        } else {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionLists($id){
        $rows = \app\models\Category::find()->where(['id_area' => $id])->all();
        if(count($rows)>0){
            echo "<option value='0'>Opcional: Selecciona una opcion</option>";
            foreach($rows as $row){
                echo "<option value='$row->id'>$row->name</option>";
            }
        }else{
            echo "<option value='0'>No hay categorias en esta área</option>";
        }
    }
}
