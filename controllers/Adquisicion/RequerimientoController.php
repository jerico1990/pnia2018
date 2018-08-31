<?php

namespace app\controllers\Adquisicion;

use Yii;
use app\models\Adquisicion\Requerimiento;
use app\models\Adquisicion\RequerimientoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\models\Patrimonio\Metacodigo;
use app\models\Adquisicion\RequerimientoDetalle;
use app\models\Adquisicion\RequerimientoDetalleSearch;
use app\models\Patrimonio\DocumentoPnia;
use app\models\Patrimonio\DocumentoPniaSearch;
use app\models\Viatico\RequerimientoDocumento;
use yii\web\UploadedFile;
/**
 * RequerimientoController implements the CRUD actions for Requerimiento model.
 */
class RequerimientoController extends Controller
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
     * Lists all Requerimiento models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RequerimientoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexAutorizacionJefeRequerimiento()
    {
        $searchModel = new RequerimientoSearch();
        $dataProvider = $searchModel->searchAutorizacionJefeRequerimiento(Yii::$app->request->queryParams);

        return $this->render('index-autorizacion-jefe-requerimiento', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexAutorizacionOperacionesRequerimiento()
    {
        $searchModel = new RequerimientoSearch();
        $dataProvider = $searchModel->searchAutorizacionOperacionesRequerimiento(Yii::$app->request->queryParams);

        return $this->render('index-autorizacion-operaciones-requerimiento', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexAutorizacionPlaneacionRequerimiento()
    {
        $searchModel = new RequerimientoSearch();
        $dataProvider = $searchModel->searchAutorizacionPlaneacionRequerimiento(Yii::$app->request->queryParams);

        return $this->render('index-autorizacion-planeacion-requerimiento', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexAutorizacionAdjudicacionRequerimiento()
    {
        $searchModel = new RequerimientoSearch();
        $dataProvider = $searchModel->searchAutorizacionAdjudicacionRequerimiento(Yii::$app->request->queryParams);

        return $this->render('index-autorizacion-adjudicacion-requerimiento', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Requerimiento model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Requerimiento #".$id,
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
     * Creates a new Requerimiento model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Requerimiento();
        $array_tipo_requerimiento = Metacodigo::getComboBoxItems('Tipo_Bien_Servicio');
        $flag_action='create';
		    $array_documentos_id = [];
        $model_documento_pnia = new DocumentoPnia();
        if($request->isAjax){

            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Crear requerimiento",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'array_tipo_requerimiento'=>$array_tipo_requerimiento,
                        'flag_action'=>$flag_action,
						'model_documento_pnia' => $model_documento_pnia,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Grabar',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post()) && $model_documento_pnia->load($request->post()) && $model->validate()){
                $model->situacion_requerimiento_id=1; // el 1 significa en digitación
                $model->save();
				        $documento = UploadedFile::getInstances($model_documento_pnia, 'ruta_documento');
                if (isset($documento[0]->extension))
                {
                    foreach ($documento as $file) {
                        $model_documento_pnia = new DocumentoPnia();
                        $file->saveAs('documentos/requerimientos/' . $model->requerimiento_id . '.' . $file->extension);
                        $model_documento_pnia->ruta_documento = 'documentos/requerimientos/' . $file->baseName . '.' . $file->extension;
                        $model_documento_pnia->nombre_documento = $file->baseName . '.' . $file->extension;
                        $model_documento_pnia->documento_mimetype = $file->extension;
                        $model_documento_pnia->documento = $model->requerimiento_id . '.' . $file->extension;
                        $model_documento_pnia->tabla='requerimiento';
                        $model_documento_pnia->pk_tabla=$model->requerimiento_id;
                        $model_documento_pnia->save();

                        //echo($model_documento_pnia->nombre_documento .' ');
                        array_push($array_documentos_id, $model_documento_pnia->documento_pnia_id);
                        //$model->documento_pnia_id = $model_documento_pnia->documento_pnia_id;
                    }
                }


                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Confirmación",
                    'content'=>'<span class="text-success">Requerimiento creado</span>',
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])

                ];
            }else{
                return [
                    'title'=> "Crear requerimiento",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'array_tipo_requerimiento'=>$array_tipo_requerimiento,
                        'flag_action'=>$flag_action,
						'model_documento_pnia' => $model_documento_pnia,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Grabar',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }
        }else{

            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->requerimiento_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'array_tipo_requerimiento'=>$array_tipo_requerimiento,
                    'flag_action'=>$flag_action,
					          'model_documento_pnia' => $model_documento_pnia,
                ]);
            }
        }

    }



    /**
     * Updates an existing Requerimiento model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $array_tipo_requerimiento = Metacodigo::getComboBoxItems('Tipo_Bien_Servicio');
        $flag_action='update';

        $searchModelRequerimientoDetalle = new RequerimientoDetalleSearch();
        $searchModelRequerimientoDetalle->requerimiento_id=$model->requerimiento_id;
        $dataProviderRequerimientoDetalle = $searchModelRequerimientoDetalle->search(Yii::$app->request->queryParams);
		    $model_documento_pnia_ = DocumentoPnia::find()->where('tabla=:tabla and pk_tabla=:pk_tabla',[':tabla'=>'requerimiento',':pk_tabla'=>$model->requerimiento_id])->all();
        $model_documento_pnia = new DocumentoPnia;
        $model_documento_actual_a_borrar = $model_documento_pnia_;
        if($model->situacion_requerimiento_id>1){
          $flag_action='disabled';//disabled formulario de requerimiento
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update Requerimiento #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'array_tipo_requerimiento'=>$array_tipo_requerimiento,
                        'flag_action'=>$flag_action,
                        'searchModelRequerimientoDetalle'=>$searchModelRequerimientoDetalle,
                        'dataProviderRequerimientoDetalle'=>$dataProviderRequerimientoDetalle,
						            'model_documento_pnia' => $model_documento_pnia,

                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }else if($model->load($request->post()) && $model_documento_pnia->load($request->post()) && $model->validate()){
				//todo se borra del puente y de documentos antes de actualizar un documento nuevo subido o varios
                /*foreach($model_documento_pnia_ as $documento_actual){
                    //$documento = DocumentoPnia::find()->where(['documento_pnia_id' => $documento_actual->documento_pnia_id])->one();
                    unlink('documentos/requerimientos/' . $documento_actual->documento);
                    $documento_actual->delete();
                    $documento->delete();
                }*/

                $documento = UploadedFile::getInstances($model_documento_pnia, 'ruta_documento');
                if (isset($documento[0]->extension))
                {
                    foreach ($documento as $file) {
                        $model_documento_pnia = new DocumentoPnia();
                        $file->saveAs('documentos/requerimientos/' . $model->requerimiento_id . '.' . $file->extension);
                        $model_documento_pnia->ruta_documento = 'documentos/requerimientos/' . $file->baseName . '.' . $file->extension;
                        $model_documento_pnia->nombre_documento = $file->baseName . '.' . $file->extension;
                        $model_documento_pnia->documento_mimetype = $file->extension;
                        $model_documento_pnia->save();
                        //echo($model_documento_pnia->nombre_documento .' ');
                        array_push($array_documentos_id, $model_documento_pnia->documento_pnia_id);
                        //$model->documento_pnia_id = $model_documento_pnia->documento_pnia_id;
                    }
                }

                $model->save();
                //$model->asignarDocumentos($array_documentos_id);
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Requerimiento #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'array_tipo_requerimiento'=>$array_tipo_requerimiento,
                        'flag_action'=>$flag_action,
						            'model_documento_pnia' => $model_documento_pnia,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
            }else{
                 return [
                    'title'=> "Update Requerimiento #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'array_tipo_requerimiento'=>$array_tipo_requerimiento,
                        'flag_action'=>$flag_action,
                        'searchModelRequerimientoDetalle'=>$searchModelRequerimientoDetalle,
                        'dataProviderRequerimientoDetalle'=>$dataProviderRequerimientoDetalle,
						            'model_documento_pnia' => $model_documento_pnia,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model_documento_pnia->load($request->post()) && $model->validate()) {

                $documento = UploadedFile::getInstances($model_documento_pnia, 'ruta_documento');
                if (isset($documento[0]->extension))
                {
                    foreach ($documento as $file) {
                        $model_documento_pnia = new DocumentoPnia();
                        $file->saveAs('documentos/requerimientos/' . $model->requerimiento_id . '.' . $file->extension);
                        $model_documento_pnia->ruta_documento = 'documentos/requerimientos/' . $file->baseName . '.' . $file->extension;
                        $model_documento_pnia->nombre_documento = $file->baseName . '.' . $file->extension;
                        $model_documento_pnia->documento_mimetype = $file->extension;
                        $model_documento_pnia->documento = $model->requerimiento_id . '.' . $file->extension;
                        $model_documento_pnia->tabla='requerimiento';
                        $model_documento_pnia->pk_tabla=$model->requerimiento_id;
                        $model_documento_pnia->save();
                        //echo($model_documento_pnia->nombre_documento .' ');
                        //array_push($array_documentos_id, $model_documento_pnia->documento_pnia_id);
                        //$model->documento_pnia_id = $model_documento_pnia->documento_pnia_id;
                    }
                }

                $model->save();
                return $this->refresh();
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'array_tipo_requerimiento'=>$array_tipo_requerimiento,
                    'flag_action'=>$flag_action,
                    'searchModelRequerimientoDetalle'=>$searchModelRequerimientoDetalle,
                    'dataProviderRequerimientoDetalle'=>$dataProviderRequerimientoDetalle,
					          'model_documento_pnia' => $model_documento_pnia,
                ]);
            }
        }
    }

    public function actionUpdateAutorizacionJefeRequerimiento($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $array_tipo_requerimiento = FlujoFlujo::getComboBoxItemsAdquisicion();
        $flag_action='update';

        $searchModelRequerimientoDetalle = new RequerimientoDetalleSearch();
        $searchModelRequerimientoDetalle->requerimiento_id=$model->requerimiento_id;
        $dataProviderRequerimientoDetalle = $searchModelRequerimientoDetalle->search(Yii::$app->request->queryParams);


        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update Requerimiento #".$id,
                    'content'=>$this->renderAjax('update-autorizacion-jefe-requerimiento', [
                        'model' => $model,
                        'array_tipo_requerimiento'=>$array_tipo_requerimiento,
                        'flag_action'=>$flag_action,
                        'searchModelRequerimientoDetalle'=>$searchModelRequerimientoDetalle,
                        'dataProviderRequerimientoDetalle'=>$dataProviderRequerimientoDetalle
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Requerimiento #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'array_tipo_requerimiento'=>$array_tipo_requerimiento,
                        'flag_action'=>$flag_action
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
            }else{
                 return [
                    'title'=> "Update Requerimiento #".$id,
                    'content'=>$this->renderAjax('update-autorizacion-jefe-requerimiento', [
                        'model' => $model,
                        'array_tipo_requerimiento'=>$array_tipo_requerimiento,
                        'flag_action'=>$flag_action,
                        'searchModelRequerimientoDetalle'=>$searchModelRequerimientoDetalle,
                        'dataProviderRequerimientoDetalle'=>$dataProviderRequerimientoDetalle
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
                return $this->redirect(['view', 'id' => $model->requerimiento_id]);
            } else {
                return $this->render('update-autorizacion-jefe-requerimiento', [
                    'model' => $model,
                    'array_tipo_requerimiento'=>$array_tipo_requerimiento,
                    'flag_action'=>$flag_action,
                    'searchModelRequerimientoDetalle'=>$searchModelRequerimientoDetalle,
                    'dataProviderRequerimientoDetalle'=>$dataProviderRequerimientoDetalle
                ]);
            }
        }
    }

    public function actionUpdateAutorizacionOperacionesRequerimiento($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $array_tipo_requerimiento = FlujoFlujo::getComboBoxItemsAdquisicion();
        $flag_action='update';

        $searchModelRequerimientoDetalle = new RequerimientoDetalleSearch();
        $searchModelRequerimientoDetalle->requerimiento_id=$model->requerimiento_id;
        $dataProviderRequerimientoDetalle = $searchModelRequerimientoDetalle->search(Yii::$app->request->queryParams);


        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update Requerimiento #".$id,
                    'content'=>$this->renderAjax('update-autorizacion-operaciones-requerimiento', [
                        'model' => $model,
                        'array_tipo_requerimiento'=>$array_tipo_requerimiento,
                        'flag_action'=>$flag_action,
                        'searchModelRequerimientoDetalle'=>$searchModelRequerimientoDetalle,
                        'dataProviderRequerimientoDetalle'=>$dataProviderRequerimientoDetalle
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Requerimiento #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'array_tipo_requerimiento'=>$array_tipo_requerimiento,
                        'flag_action'=>$flag_action
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
            }else{
                 return [
                    'title'=> "Update Requerimiento #".$id,
                    'content'=>$this->renderAjax('update-autorizacion-operaciones-requerimiento', [
                        'model' => $model,
                        'array_tipo_requerimiento'=>$array_tipo_requerimiento,
                        'flag_action'=>$flag_action,
                        'searchModelRequerimientoDetalle'=>$searchModelRequerimientoDetalle,
                        'dataProviderRequerimientoDetalle'=>$dataProviderRequerimientoDetalle
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
                return $this->redirect(['view', 'id' => $model->requerimiento_id]);
            } else {
                return $this->render('update-autorizacion-operaciones-requerimiento', [
                    'model' => $model,
                    'array_tipo_requerimiento'=>$array_tipo_requerimiento,
                    'flag_action'=>$flag_action,
                    'searchModelRequerimientoDetalle'=>$searchModelRequerimientoDetalle,
                    'dataProviderRequerimientoDetalle'=>$dataProviderRequerimientoDetalle
                ]);
            }
        }
    }

    public function actionUpdateAutorizacionPlaneacionRequerimiento($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $array_tipo_requerimiento = FlujoFlujo::getComboBoxItemsAdquisicion();
        $flag_action='update';

        $searchModelRequerimientoDetalle = new RequerimientoDetalleSearch();
        $searchModelRequerimientoDetalle->requerimiento_id=$model->requerimiento_id;
        $dataProviderRequerimientoDetalle = $searchModelRequerimientoDetalle->search(Yii::$app->request->queryParams);


        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update Requerimiento #".$id,
                    'content'=>$this->renderAjax('update-autorizacion-planeacion-requerimiento', [
                        'model' => $model,
                        'array_tipo_requerimiento'=>$array_tipo_requerimiento,
                        'flag_action'=>$flag_action,
                        'searchModelRequerimientoDetalle'=>$searchModelRequerimientoDetalle,
                        'dataProviderRequerimientoDetalle'=>$dataProviderRequerimientoDetalle
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Requerimiento #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'array_tipo_requerimiento'=>$array_tipo_requerimiento,
                        'flag_action'=>$flag_action
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
            }else{
                 return [
                    'title'=> "Update Requerimiento #".$id,
                    'content'=>$this->renderAjax('update-autorizacion-planeacion-requerimiento', [
                        'model' => $model,
                        'array_tipo_requerimiento'=>$array_tipo_requerimiento,
                        'flag_action'=>$flag_action,
                        'searchModelRequerimientoDetalle'=>$searchModelRequerimientoDetalle,
                        'dataProviderRequerimientoDetalle'=>$dataProviderRequerimientoDetalle
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
                return $this->redirect(['view', 'id' => $model->requerimiento_id]);
            } else {
                return $this->render('update-autorizacion-planeacion-requerimiento', [
                    'model' => $model,
                    'array_tipo_requerimiento'=>$array_tipo_requerimiento,
                    'flag_action'=>$flag_action,
                    'searchModelRequerimientoDetalle'=>$searchModelRequerimientoDetalle,
                    'dataProviderRequerimientoDetalle'=>$dataProviderRequerimientoDetalle
                ]);
            }
        }
    }

    public function actionUpdateAutorizacionAdjudicacionRequerimiento($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $array_tipo_requerimiento = FlujoFlujo::getComboBoxItemsAdquisicion();
        $flag_action='update';

        $searchModelRequerimientoDetalle = new RequerimientoDetalleSearch();
        $searchModelRequerimientoDetalle->requerimiento_id=$model->requerimiento_id;
        $dataProviderRequerimientoDetalle = $searchModelRequerimientoDetalle->search(Yii::$app->request->queryParams);


        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update Requerimiento #".$id,
                    'content'=>$this->renderAjax('update-autorizacion-adjudicacion-requerimiento', [
                        'model' => $model,
                        'array_tipo_requerimiento'=>$array_tipo_requerimiento,
                        'flag_action'=>$flag_action,
                        'searchModelRequerimientoDetalle'=>$searchModelRequerimientoDetalle,
                        'dataProviderRequerimientoDetalle'=>$dataProviderRequerimientoDetalle
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Requerimiento #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'array_tipo_requerimiento'=>$array_tipo_requerimiento,
                        'flag_action'=>$flag_action
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
            }else{
                 return [
                    'title'=> "Update Requerimiento #".$id,
                    'content'=>$this->renderAjax('update-autorizacion-adjudicacion-requerimiento', [
                        'model' => $model,
                        'array_tipo_requerimiento'=>$array_tipo_requerimiento,
                        'flag_action'=>$flag_action,
                        'searchModelRequerimientoDetalle'=>$searchModelRequerimientoDetalle,
                        'dataProviderRequerimientoDetalle'=>$dataProviderRequerimientoDetalle
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
                return $this->redirect(['view', 'id' => $model->requerimiento_id]);
            } else {
                return $this->render('update-autorizacion-adjudicacion-requerimiento', [
                    'model' => $model,
                    'array_tipo_requerimiento'=>$array_tipo_requerimiento,
                    'flag_action'=>$flag_action,
                    'searchModelRequerimientoDetalle'=>$searchModelRequerimientoDetalle,
                    'dataProviderRequerimientoDetalle'=>$dataProviderRequerimientoDetalle
                ]);
            }
        }
    }

    /**
     * Delete an existing Requerimiento model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
		$lista_contratos_documentos = ContratoDocumento::find()->where(['requerimiento_id'=>$id])->all();
        //todo se borra del puente y de documentos antes de actualizar un documento nuevo subido o varios
        foreach($lista_contratos_documentos as $documento_actual){
            $documento = DocumentoPnia::find()->where(['documento_pnia_id' => $documento_actual->documento_pnia_id])->one();
            unlink(Yii::getAlias('@uploadedfilesdir') . $documento->nombre_documento);
            $documento_actual->delete();
            $documento->delete();
        }
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
     * Delete multiple existing Requerimiento model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
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
     * Finds the Requerimiento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Requerimiento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Requerimiento::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionEnviarJefeRequerimiento(){
      $flag=0;
      if(isset($_POST['requerimiento_id']) && trim($_POST['requerimiento_id'])!=''){
        $requerimiento_id=$_POST['requerimiento_id'];
        $model = $this->findModel($requerimiento_id);
        $model->situacion_requerimiento_id=2;// por aprobar
        if($model->update()){
          $detalles = RequerimientoDetalle::find()->where('requerimiento_id=:requerimiento_id and situacion_requerimiento_detalle_id=1',[':requerimiento_id'=>$requerimiento_id])->all();
          foreach($detalles as $detalle){
            $detalle->situacion_requerimiento_detalle_id=2;// por aprobar
            $detalle->update();
          }
          $flag=1;
        }
      }
      return $flag;
    }

    public function actionAprobarJefeRequerimiento(){
      $flag=0;
      if(isset($_POST['requerimiento_id']) && trim($_POST['requerimiento_id'])!=''){
        $requerimiento_id=$_POST['requerimiento_id'];
        $model = $this->findModel($requerimiento_id);
        $model->situacion_requerimiento_id=3;// req. aprobado
        if($model->update()){
          $detalles = RequerimientoDetalle::find()->where('requerimiento_id=:requerimiento_id and situacion_requerimiento_detalle_id=2',[':requerimiento_id'=>$requerimiento_id])->all();
          foreach($detalles as $detalle){
            $detalle->situacion_requerimiento_detalle_id=3;// aprobado
            $detalle->update();
          }
          $flag=1;
        }
      }
      return $flag;
    }

    public function actionDesaprobarJefeRequerimiento(){
      $flag=0;
      if(isset($_POST['requerimiento_id']) && trim($_POST['requerimiento_id'])!=''){
        $requerimiento_id=$_POST['requerimiento_id'];
        $model = $this->findModel($requerimiento_id);
        $model->situacion_requerimiento_id=4;// req. desaprobado
        if($model->update()){
          $detalles = RequerimientoDetalle::find()->where('requerimiento_id=:requerimiento_id and situacion_requerimiento_detalle_id=2',[':requerimiento_id'=>$requerimiento_id])->all();
          foreach($detalles as $detalle){
            $detalle->situacion_requerimiento_detalle_id=4;// desaprobado
            $detalle->update();
          }
          $flag=1;
        }
      }
      return $flag;
    }

    public function actionEnviarOperacionesRequerimiento(){
      $flag=0;
      if(isset($_POST['requerimiento_id']) && trim($_POST['requerimiento_id'])!=''){
        $requerimiento_id=$_POST['requerimiento_id'];
        $model = $this->findModel($requerimiento_id);
        $model->situacion_requerimiento_id=5;// por aprobar
        if($model->update()){
          $detalles = RequerimientoDetalle::find()->where('requerimiento_id=:requerimiento_id and situacion_requerimiento_detalle_id=3',[':requerimiento_id'=>$requerimiento_id])->all();
          foreach($detalles as $detalle){
            $detalle->situacion_requerimiento_detalle_id=5;// VB Dirección de Operaciones
            $detalle->update();
          }
          $flag=1;
        }
      }
      return $flag;
    }

    public function actionAprobarOperacionesRequerimiento(){
      $flag=0;
      if(isset($_POST['requerimiento_id']) && trim($_POST['requerimiento_id'])!=''){
        $requerimiento_id=$_POST['requerimiento_id'];
        $model = $this->findModel($requerimiento_id);
        $model->situacion_requerimiento_id=6;// req. VB Dirección de Operaciones Aprobado
        if($model->update()){
          $detalles = RequerimientoDetalle::find()->where('requerimiento_id=:requerimiento_id and situacion_requerimiento_detalle_id=5',[':requerimiento_id'=>$requerimiento_id])->all();
          foreach($detalles as $detalle){
            $detalle->situacion_requerimiento_detalle_id=6;// req. VB Dirección de Operaciones Aprobado
            $detalle->update();
          }
          $flag=1;
        }
      }
      return $flag;
    }

    public function actionDesaprobarOperacionesRequerimiento(){
      $flag=0;
      if(isset($_POST['requerimiento_id']) && trim($_POST['requerimiento_id'])!=''){
        $requerimiento_id=$_POST['requerimiento_id'];
        $model = $this->findModel($requerimiento_id);
        $model->situacion_requerimiento_id=7;//// req. VB Dirección de Operaciones Desaprobado
        if($model->update()){
          $detalles = RequerimientoDetalle::find()->where('requerimiento_id=:requerimiento_id and situacion_requerimiento_detalle_id=5',[':requerimiento_id'=>$requerimiento_id])->all();
          foreach($detalles as $detalle){
            $detalle->situacion_requerimiento_detalle_id=7;// req. VB Dirección de Operaciones desaprobado
            $detalle->update();
          }
          $flag=1;
        }
      }
      return $flag;
    }

    public function actionPedidoCertificacionSiaf(){
      $flag=0;
      if(isset($_POST['requerimiento_id']) && trim($_POST['requerimiento_id'])!=''){
        $requerimiento_id=$_POST['requerimiento_id'];
        $model = $this->findModel($requerimiento_id);
        $model->situacion_requerimiento_id=8;//// req. VB Dirección de Operaciones Desaprobado
        if($model->update()){
          $detalles = RequerimientoDetalle::find()->where('requerimiento_id=:requerimiento_id and situacion_requerimiento_detalle_id=6',[':requerimiento_id'=>$requerimiento_id])->all();
          foreach($detalles as $detalle){
            $detalle->situacion_requerimiento_detalle_id=8;// req. VB Dirección de Operaciones desaprobado
            $detalle->update();
          }
          $flag=1;
        }
      }
      return $flag;
    }

    public function actionAprobarCertificacionSiaf(){
      $flag=0;
      if(isset($_POST['requerimiento_id']) && trim($_POST['requerimiento_id'])!=''){
        $requerimiento_id=$_POST['requerimiento_id'];
        $model = $this->findModel($requerimiento_id);
        $model->situacion_requerimiento_id=9;//// req. VB Dirección de Operaciones Desaprobado
        if($model->update()){
          $detalles = RequerimientoDetalle::find()->where('requerimiento_id=:requerimiento_id and situacion_requerimiento_detalle_id=8',[':requerimiento_id'=>$requerimiento_id])->all();
          foreach($detalles as $detalle){
            $detalle->situacion_requerimiento_detalle_id=9;// req. VB Dirección de Operaciones desaprobado
            $detalle->update();
          }
          $flag=1;
        }
      }
      return $flag;
    }

    public function actionDesaprobarCertificacionSiaf(){
      $flag=0;
      if(isset($_POST['requerimiento_id']) && trim($_POST['requerimiento_id'])!=''){
        $requerimiento_id=$_POST['requerimiento_id'];
        $model = $this->findModel($requerimiento_id);
        $model->situacion_requerimiento_id=10;//// req. VB Dirección de Operaciones Desaprobado
        if($model->update()){
          $detalles = RequerimientoDetalle::find()->where('requerimiento_id=:requerimiento_id and situacion_requerimiento_detalle_id=8',[':requerimiento_id'=>$requerimiento_id])->all();
          foreach($detalles as $detalle){
            $detalle->situacion_requerimiento_detalle_id=10;// req. VB Dirección de Operaciones desaprobado
            $detalle->update();
          }
          $flag=1;
        }
      }
      return $flag;
    }


}
