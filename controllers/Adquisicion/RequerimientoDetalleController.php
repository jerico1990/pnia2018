<?php

namespace app\controllers\Adquisicion;

use Yii;
use app\models\Adquisicion\RequerimientoDetalle;
use app\models\Adquisicion\RequerimientoDetalleSearch;
use app\models\Adquisicion\Adjudicacion;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\models\Patrimonio\Metacodigo;
use app\models\Patrimonio\Ubicacion;
use app\models\Presupuesto\MetaFinanciera;

use yii\helpers\ArrayHelper;

/**
 * RequerimientoDetalleController implements the CRUD actions for RequerimientoDetalle model.
 */
class RequerimientoDetalleController extends Controller
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
     * Lists all RequerimientoDetalle models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout='vacio';
        $searchModel = new RequerimientoDetalleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexAutorizacionContabilidad()
    {
        $searchModel = new RequerimientoDetalleSearch();
        $dataProvider = $searchModel->searchContabilidad(Yii::$app->request->queryParams);

        return $this->render('index-autorizacion-contabilidad', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RequerimientoDetalle model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "RequerimientoDetalle #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new RequerimientoDetalle model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($requerimiento_id=null)
    {
        $request = Yii::$app->request;
        $model = new RequerimientoDetalle();
        $model->requerimiento_id=$requerimiento_id;
		    $array_metacodigo = Metacodigo::getComboBoxItems('Tipo_Garantia');
        $array_ubicaciones = ArrayHelper::map((new Ubicacion())->getUbicaciones(), 'ubicacion_id', 'nombre');
        $array_lineas_presupuesto  = RequerimientoDetalle::getComboBoxItemsLineasPresupuesto(9);

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Registrar item presupuestal",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
						            'array_metacodigo' => $array_metacodigo,
                        'array_ubicaciones' => $array_ubicaciones,
                        'array_lineas_presupuesto' => $array_lineas_presupuesto
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Grabar',['class'=>'btn btn-primary btn-grabar-detalle','type'=>"submit"])

                ];
            }else if($model->load($request->post())){
                $arrayFormasPagos = [];
                for($i = 0 ; $i < count($model->FormaPagoDescripciones); $i++){
                  array_push($arrayFormasPagos,[ 'descripcion' => $model->FormaPagoDescripciones[$i] , 'tiempo' => $model->FormaPagoTiempos[$i], 'porcetaje' => $model->FormaPagoPorcentajes[$i], 'condicion' => $model->FormaPagoCondiciones[$i]]);
                }
                //var_dump(json_encode($arrayFormasPagos));die;
                $model->forma_pago = json_encode($arrayFormasPagos);
                $model->fecha_entrega = date('Y-m-d H:i:s',strtotime($model->fecha_entrega));
                $model->situacion_requerimiento_detalle_id=1; // 1 en digitación
                $model->save();

                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new RequerimientoDetalle",
                    'content'=>'<span class="text-success">Create RequerimientoDetalle success</span>',
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])

                ];
            }else{
                return [
                    'title'=> "Create new RequerimientoDetalle",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
						            'array_metacodigo' => $array_metacodigo,
                        'array_ubicaciones' => $array_ubicaciones,
                        'array_lineas_presupuesto' => $array_lineas_presupuesto
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Grabar',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post())) {
                $model->situacion_requerimiento_detalle_id=1;
                $model->save();
                return $this->redirect(['view', 'id' => $model->requerimiento_detalle_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
					          'array_metacodigo' => $array_metacodigo,
                    'array_ubicaciones' => $array_ubicaciones,
                    'array_lineas_presupuesto' => $array_lineas_presupuesto
                ]);
            }
        }

    }

    /**
     * Updates an existing RequerimientoDetalle model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
		    $array_metacodigo = Metacodigo::getComboBoxItems('Tipo_Garantia');
        $array_ubicaciones = ArrayHelper::map((new Ubicacion())->getUbicaciones(), 'ubicacion_id', 'nombre');
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update RequerimientoDetalle #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
						'array_metacodigo' => $array_metacodigo,
                        'array_ubicaciones' => $array_ubicaciones,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "RequerimientoDetalle #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
						'array_metacodigo' => $array_metacodigo,
                        'array_ubicaciones' => $array_ubicaciones,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
            }else{
                 return [
                    'title'=> "Update RequerimientoDetalle #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
						'array_metacodigo' => $array_metacodigo,
                        'array_ubicaciones' => $array_ubicaciones,
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
                return $this->redirect(['view', 'id' => $model->requerimiento_detalle_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
					'array_metacodigo' => $array_metacodigo,
                    'array_ubicaciones' => $array_ubicaciones,
                ]);
            }
        }
    }

    public function actionUpdateAutorizacionRequerimiento($id)
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
                    'title'=> "Update RequerimientoDetalle #".$id,
                    'content'=>$this->renderAjax('update-autorizacion-requerimiento', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "RequerimientoDetalle #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
                ];
            }else{
                 return [
                    'title'=> "Update RequerimientoDetalle #".$id,
                    'content'=>$this->renderAjax('update-autorizacion-requerimiento', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->requerimiento_detalle_id]);
            } else {
                return $this->render('update-autorizacion-requerimiento', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing RequerimientoDetalle model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
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
     * Delete multiple existing RequerimientoDetalle model.
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
     * Finds the RequerimientoDetalle model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RequerimientoDetalle the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RequerimientoDetalle::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAprobarCertificacionSiaf(){
      $flag=0;
      if(isset($_POST['requerimiento_detalle_id']) && trim($_POST['requerimiento_detalle_id'])!=''){
        $requerimiento_detalle_id=$_POST['requerimiento_detalle_id'];
        $model = $this->findModel($requerimiento_detalle_id);
        $model->situacion_requerimiento_detalle_id=9;//certificacion aprobada
        $countRequerimientoDetalles=(new \yii\db\Query())
                   ->from('requerimiento_detalle')
                   ->where('requerimiento_id=:requerimiento_id and situacion_requerimiento_detalle_id=8',[':requerimiento_id'=>$model->requerimiento_id])
                   ->count();

        if($model->update()){
          if($countRequerimientoDetalles==1){
            $requerimiento=Requerimiento::findOne($model->requerimiento_id);
            $requerimiento->situacion_requerimiento_id=9;//certificacion aprobada
            $requerimiento->update();
          }

          $flag=1;
        }
      }
      return $flag;
    }

    public function actionDesaprobarCertificacionSiaf(){
      $flag=0;
      if(isset($_POST['requerimiento_detalle_id']) && trim($_POST['requerimiento_detalle_id'])!=''){
        $requerimiento_detalle_id=$_POST['requerimiento_detalle_id'];
        $model = $this->findModel($requerimiento_detalle_id);
        $model->situacion_requerimiento_detalle_id=10;//certificacion desaprobada
        $countRequerimientoDetallesAprobados=(new \yii\db\Query())
                   ->from('requerimiento_detalle')
                   ->where('requerimiento_id=:requerimiento_id and situacion_requerimiento_detalle_id=9',[':requerimiento_id'=>$model->requerimiento_id])
                   ->count();
         $countRequerimientoDetallesFaltantes=(new \yii\db\Query())
                    ->from('requerimiento_detalle')
                    ->where('requerimiento_id=:requerimiento_id and situacion_requerimiento_detalle_id=8',[':requerimiento_id'=>$model->requerimiento_id])
                    ->count();

        if($model->update()){
          if($countRequerimientoDetallesFaltantes==1 && $countRequerimientoDetallesAprobados==0){
            $requerimiento=Requerimiento::findOne($model->requerimiento_id);
            $requerimiento->situacion_requerimiento_id=10;//certificacion aprobada
            $requerimiento->update();
          }

          $flag=1;
        }
      }
      return $flag;
    }

    public function actionPedidoCompromisoSiaf(){
      $flag=0;
      if(isset($_POST['requerimiento_detalle_id']) && trim($_POST['requerimiento_detalle_id'])!=''){
        $requerimiento_detalle_id=$_POST['requerimiento_detalle_id'];
        $model = $this->findModel($requerimiento_detalle_id);
        $model->situacion_requerimiento_detalle_id=18;//comprometer
        /*
        $countRequerimientoDetallesAprobados=(new \yii\db\Query())
                   ->from('requerimiento_detalle')
                   ->where('requerimiento_id=:requerimiento_id and situacion_requerimiento_detalle_id=9',[':requerimiento_id'=>$model->requerimiento_id])
                   ->count();
         $countRequerimientoDetallesFaltantes=(new \yii\db\Query())
                    ->from('requerimiento_detalle')
                    ->where('requerimiento_id=:requerimiento_id and situacion_requerimiento_detalle_id=8',[':requerimiento_id'=>$model->requerimiento_id])
                    ->count();
        */
        if($model->update()){
          $adjudicacion=Adjudicacion::find()->where('requerimiento_detalle_id=:requerimiento_detalle_id and situacion_adjudicacion_id=7',[':requerimiento_detalle_id'=>$requerimiento_detalle_id])->one();
          $adjudicacion->situacion_adjudicacion_id=8;// comprometer
          $adjudicacion->update();
          $flag=1;
        }
      }
      return $flag;
    }

    public function actionAprobarCompromisoSiaf(){
      $flag=0;
      if(isset($_POST['requerimiento_detalle_id']) && trim($_POST['requerimiento_detalle_id'])!=''){
        $requerimiento_detalle_id=$_POST['requerimiento_detalle_id'];
        $model = $this->findModel($requerimiento_detalle_id);
        $model->situacion_requerimiento_detalle_id=19;//comprometer
        /*
        $countRequerimientoDetallesAprobados=(new \yii\db\Query())
                   ->from('requerimiento_detalle')
                   ->where('requerimiento_id=:requerimiento_id and situacion_requerimiento_detalle_id=9',[':requerimiento_id'=>$model->requerimiento_id])
                   ->count();
         $countRequerimientoDetallesFaltantes=(new \yii\db\Query())
                    ->from('requerimiento_detalle')
                    ->where('requerimiento_id=:requerimiento_id and situacion_requerimiento_detalle_id=8',[':requerimiento_id'=>$model->requerimiento_id])
                    ->count();
        */
        if($model->update()){
          $adjudicacion=Adjudicacion::find()->where('requerimiento_detalle_id=:requerimiento_detalle_id and situacion_adjudicacion_id=8',[':requerimiento_detalle_id'=>$requerimiento_detalle_id])->one();
          $adjudicacion->situacion_adjudicacion_id=9;// comprometer
          $adjudicacion->update();
          $flag=1;
        }
      }
      return $flag;
    }

    public function actionDesaprobarCompromisoSiaf(){
      $flag=0;
      if(isset($_POST['requerimiento_detalle_id']) && trim($_POST['requerimiento_detalle_id'])!=''){
        $requerimiento_detalle_id=$_POST['requerimiento_detalle_id'];
        $model = $this->findModel($requerimiento_detalle_id);
        $model->situacion_requerimiento_detalle_id=20;//desaprobar compromiso
        /*
        $countRequerimientoDetallesAprobados=(new \yii\db\Query())
                   ->from('requerimiento_detalle')
                   ->where('requerimiento_id=:requerimiento_id and situacion_requerimiento_detalle_id=9',[':requerimiento_id'=>$model->requerimiento_id])
                   ->count();
         $countRequerimientoDetallesFaltantes=(new \yii\db\Query())
                    ->from('requerimiento_detalle')
                    ->where('requerimiento_id=:requerimiento_id and situacion_requerimiento_detalle_id=8',[':requerimiento_id'=>$model->requerimiento_id])
                    ->count();
        */
        if($model->update()){
          $adjudicacion=Adjudicacion::find()->where('requerimiento_detalle_id=:requerimiento_detalle_id and situacion_adjudicacion_id=8',[':requerimiento_detalle_id'=>$requerimiento_detalle_id])->one();
          $adjudicacion->situacion_adjudicacion_id=10;// aprobar compromiso
          $adjudicacion->update();
          $flag=1;
        }
      }
      return $flag;
    }


    public function actionGetLineaPresupuestoJson(){
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

      $flag=0;
      if(isset($_POST['linea_nivel_id']) && trim($_POST['linea_nivel_id'])!=''){
        $linea_nivel_id=$_POST['linea_nivel_id'];
        $meta_financiera = MetaFinanciera::find()->where('presupuesto_cabecera_id=:presupuesto_cabecera_id',[':presupuesto_cabecera_id'=>$linea_nivel_id])->one();
        if($meta_financiera){
          return $meta_financiera;
        }
      }
      return $flag;
    }


}
