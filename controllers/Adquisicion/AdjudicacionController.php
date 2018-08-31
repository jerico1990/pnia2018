<?php

namespace app\controllers\Adquisicion;

use Yii;
use app\models\Adquisicion\Adjudicacion;
use app\models\Adquisicion\AdjudicacionSearch;
use app\models\Adquisicion\Requerimiento;
use app\models\Adquisicion\RequerimientoDetalle;
use app\models\General\PostoresSearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * AdjudicacionController implements the CRUD actions for Adjudicacion model.
 */
class AdjudicacionController extends Controller
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
     * Lists all Adjudicacion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdjudicacionSearch();
        $dataProvider = $searchModel->searchAutorizacionAdjudicacion(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Adjudicacion model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Adjudicacion #".$id,
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
     * Creates a new Adjudicacion model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Adjudicacion();
        //$model->adjudicacion_id=$adjudicacion_id;
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new Adjudicacion",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post())){
                // // en clasificacion
                $model->save();
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new Adjudicacion",
                    'content'=>'<span class="text-success">Create Adjudicacion success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])

                ];
            }else{
                return [
                    'title'=> "Create new Adjudicacion",
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
                return $this->redirect(['view', 'id' => $model->adjudicacion_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

    }

    /**
     * Updates an existing Adjudicacion model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
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
                    'title'=> "Update Adjudicacion #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Adjudicacion #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
            }else{
                 return [
                    'title'=> "Update Adjudicacion #".$id,
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
                return $this->redirect(['view', 'id' => $model->adjudicacion_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }


    public function actionUpdateAutorizacionAdjudicacion($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $searchModelPostor = new PostoresSearch();
        $searchModelPostor->adjudicacion_id=$model->adjudicacion_id;
        $dataProviderPostor = $searchModelPostor->search(Yii::$app->request->queryParams);
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update Adjudicacion #".$id,
                    'content'=>$this->renderAjax('update-autorizacion-adjudicacion', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Adjudicacion #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
            }else{
                 return [
                    'title'=> "Update Adjudicacion #".$id,
                    'content'=>$this->renderAjax('update-autorizacion-adjudicacion', [
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
                return $this->redirect(['view', 'id' => $model->adjudicacion_id]);
            } else {
                return $this->render('update-autorizacion-adjudicacion', [
                    'model' => $model,
                    'searchModelPostor' => $searchModelPostor,
                    'dataProviderPostor' => $dataProviderPostor,
                ]);
            }
        }
    }

    /**
     * Delete an existing Adjudicacion model.
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
     * Delete multiple existing Adjudicacion model.
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
     * Finds the Adjudicacion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Adjudicacion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Adjudicacion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionIniciarAdjudicacionGlobal(){
      $flag=0;
      if(isset($_POST['requerimiento_id']) && trim($_POST['requerimiento_id'])!=''){
        $requerimiento_id=$_POST['requerimiento_id'];
        $model = Requerimiento::find()->where('requerimiento_id=:requerimiento_id',[':requerimiento_id'=>$requerimiento_id])->one();
        $model->situacion_requerimiento_id=11;// iniciar adjudicacion
        if($model->update()){
          $detalles = RequerimientoDetalle::find()->where('requerimiento_id=:requerimiento_id and situacion_requerimiento_detalle_id=9',[':requerimiento_id'=>$requerimiento_id])->all();
          foreach($detalles as $detalle){
            $detalle->situacion_requerimiento_detalle_id=11;// iniciar adjudicacion
            $detalle->update();

            $adjudicacion = new Adjudicacion;
            $adjudicacion->requerimiento_id=$model->requerimiento_id;
            $adjudicacion->requerimiento_detalle_id=$detalle->requerimiento_detalle_id;
            $adjudicacion->situacion_adjudicacion_id=1;//iniciar adjudicacion
            $adjudicacion->save();
          }
          $flag=1;
        }
      }
      return $flag;
    }

    public function actionAdmitirAdjudicacionGlobal(){
      $flag=0;
      if(isset($_POST['requerimiento_id']) && trim($_POST['requerimiento_id'])!=''){
        $requerimiento_id=$_POST['requerimiento_id'];
        $model = Requerimiento::find()->where('requerimiento_id=:requerimiento_id',[':requerimiento_id'=>$requerimiento_id])->one();
        $model->situacion_requerimiento_id=12;// admitir adjudicacion
        if($model->update()){
          $detalles = RequerimientoDetalle::find()->where('requerimiento_id=:requerimiento_id and situacion_requerimiento_detalle_id=11',[':requerimiento_id'=>$requerimiento_id])->all();
          foreach($detalles as $detalle){
            $detalle->situacion_requerimiento_detalle_id=12;// admitir adjudicacion
            $detalle->update();
          }

          $adjudicaciones=Adjudicacion::find()->where('requerimiento_id=:requerimiento_id and situacion_adjudicacion_id=1',[':requerimiento_id'=>$requerimiento_id])->all();
          foreach($adjudicaciones as $adjudicacion){
            $adjudicacion->situacion_adjudicacion_id=2;// admitir adjudicacion
            $adjudicacion->update();
          }

          $flag=1;
        }
      }
      return $flag;
    }


    public function actionObservarAdjudicacionGlobal(){
      $flag=0;
      if(isset($_POST['requerimiento_id']) && trim($_POST['requerimiento_id'])!=''){
        $requerimiento_id=$_POST['requerimiento_id'];
        $model = Requerimiento::find()->where('requerimiento_id=:requerimiento_id',[':requerimiento_id'=>$requerimiento_id])->one();
        $model->situacion_requerimiento_id=13;// observar adjudicacion
        if($model->update()){
          $detalles = RequerimientoDetalle::find()->where('requerimiento_id=:requerimiento_id and situacion_requerimiento_detalle_id=11',[':requerimiento_id'=>$requerimiento_id])->all();
          foreach($detalles as $detalle){
            $detalle->situacion_requerimiento_detalle_id=13;// observar adjudicacion
            $detalle->update();
          }

          $adjudicaciones=Adjudicacion::find()->where('requerimiento_id=:requerimiento_id and situacion_adjudicacion_id=1',[':requerimiento_id'=>$requerimiento_id])->all();
          foreach($adjudicaciones as $adjudicacion){
            $adjudicacion->situacion_adjudicacion_id=3;// observar adjudicacion
            $adjudicacion->update();
          }

          $flag=1;
        }
      }
      return $flag;
    }


    public function actionAdmitirAdjudicacion(){
      $flag=0;
      if(isset($_POST['requerimiento_detalle_id']) && trim($_POST['requerimiento_detalle_id'])!=''){
        $requerimiento_detalle_id=$_POST['requerimiento_detalle_id'];
        $adjudicacion=Adjudicacion::find()->where('requerimiento_detalle_id=:requerimiento_detalle_id and situacion_adjudicacion_id=1',[':requerimiento_detalle_id'=>$requerimiento_detalle_id])->one();
        $adjudicacion->situacion_adjudicacion_id=2;// admitir adjudicacion
        if($adjudicacion->update()){
          $requerimiento_detalle=RequerimientoDetalle::find()->where('requerimiento_detalle_id=:requerimiento_detalle_id and situacion_requerimiento_detalle_id=11',[':requerimiento_detalle_id'=>$requerimiento_detalle_id])->one();
          $requerimiento_detalle->situacion_requerimiento_detalle_id=12;
          $requerimiento_detalle->update();
          $flag=1;
        }
      }
      return $flag;
    }


    public function actionObservarAdjudicacion(){
      $flag=0;
      if(isset($_POST['requerimiento_detalle_id']) && trim($_POST['requerimiento_detalle_id'])!=''){
        $requerimiento_detalle_id=$_POST['requerimiento_detalle_id'];
        $adjudicacion=Adjudicacion::find()->where('requerimiento_detalle_id=:requerimiento_detalle_id and situacion_adjudicacion_id=1',[':requerimiento_detalle_id'=>$requerimiento_detalle_id])->one();
        $adjudicacion->situacion_adjudicacion_id=3;// observar adjudicacion
        if($adjudicacion->update()){
          $requerimiento_detalle=RequerimientoDetalle::find()->where('requerimiento_detalle_id=:requerimiento_detalle_id and situacion_requerimiento_detalle_id=11',[':requerimiento_detalle_id'=>$requerimiento_detalle_id])->one();
          $requerimiento_detalle->situacion_requerimiento_detalle_id=13;
          $requerimiento_detalle->update();
          $flag=1;
        }
      }
      return $flag;
    }

    public function actionPedidoCompletoAdjudicacion(){
      $flag=0;
      if(isset($_POST['requerimiento_detalle_id']) && trim($_POST['requerimiento_detalle_id'])!=''){
        $requerimiento_detalle_id=$_POST['requerimiento_detalle_id'];
        $adjudicacion=Adjudicacion::find()->where('requerimiento_detalle_id=:requerimiento_detalle_id and situacion_adjudicacion_id=2',[':requerimiento_detalle_id'=>$requerimiento_detalle_id])->one();
        $adjudicacion->situacion_adjudicacion_id=4;// pedido completo
        if($adjudicacion->update()){
          $requerimiento_detalle=RequerimientoDetalle::find()->where('requerimiento_detalle_id=:requerimiento_detalle_id and situacion_requerimiento_detalle_id=12',[':requerimiento_detalle_id'=>$requerimiento_detalle_id])->one();
          $requerimiento_detalle->situacion_requerimiento_detalle_id=14;//Pedido completo
          $requerimiento_detalle->update();
          $flag=1;
        }
      }
      return $flag;
    }

    public function actionPedidoIncompletoAdjudicacion(){
      $flag=0;
      if(isset($_POST['requerimiento_detalle_id']) && trim($_POST['requerimiento_detalle_id'])!=''){
        $requerimiento_detalle_id=$_POST['requerimiento_detalle_id'];
        $adjudicacion=Adjudicacion::find()->where('requerimiento_detalle_id=:requerimiento_detalle_id and situacion_adjudicacion_id=2',[':requerimiento_detalle_id'=>$requerimiento_detalle_id])->one();
        $adjudicacion->situacion_adjudicacion_id=5;// pedido incompleto
        if($adjudicacion->update()){
          $requerimiento_detalle=RequerimientoDetalle::find()->where('requerimiento_detalle_id=:requerimiento_detalle_id and situacion_requerimiento_detalle_id=12',[':requerimiento_detalle_id'=>$requerimiento_detalle_id])->one();
          $requerimiento_detalle->situacion_requerimiento_detalle_id=15;//Pedido incompleto
          $requerimiento_detalle->update();
          $flag=1;
        }
      }
      return $flag;
    }

    public function actionIniciarRegistroPostoresAdjudicacion(){
      $flag=0;
      if(isset($_POST['requerimiento_detalle_id']) && trim($_POST['requerimiento_detalle_id'])!=''){
        $requerimiento_detalle_id=$_POST['requerimiento_detalle_id'];
        $adjudicacion=Adjudicacion::find()->where('requerimiento_detalle_id=:requerimiento_detalle_id and situacion_adjudicacion_id=4',[':requerimiento_detalle_id'=>$requerimiento_detalle_id])->one();
        $adjudicacion->situacion_adjudicacion_id=6;// iniciar registro de postores
        if($adjudicacion->update()){
          $requerimiento_detalle=RequerimientoDetalle::find()->where('requerimiento_detalle_id=:requerimiento_detalle_id and situacion_requerimiento_detalle_id=14',[':requerimiento_detalle_id'=>$requerimiento_detalle_id])->one();
          $requerimiento_detalle->situacion_requerimiento_detalle_id=16;//Iniciar registro de postores
          $requerimiento_detalle->update();
          $flag=1;
        }
      }
      return $flag;
    }
}
