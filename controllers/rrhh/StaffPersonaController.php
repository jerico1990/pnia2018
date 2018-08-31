<?php

namespace app\controllers\rrhh;

use Yii;
use app\models\rrhh\PniaEntFinanciera;
use app\models\rrhh\StaffPersona;
use app\models\rrhh\StaffPersonaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

use yii\db\Query;
use yii\helpers\Json;
use yii\db\Expression;
use app\controllers\BehaviorController;
use app\models\rrhh\StaffArea;

use yii\db\IntegrityException;

use app\models\Auditoria\Usuario;
use yii\helpers\Url;
use app\models\RolProceso;
Use yii\filters\AccessControl;

/**
 * StaffPersonaController implements the CRUD actions for StaffPersona model.
 */
class StaffPersonaController extends BehaviorController
{

    /**
     * Lists all StaffPersona models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new StaffPersonaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single StaffPersona model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        $model  = $this->findModel($id);
        $title  = "Persona-Staff : ".$model->getNombreCompleto();
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Editar',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new StaffPersona model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new StaffPersona();  
        $title = "Registrar Persona";
        $array_entidades_financieras = PniaEntFinanciera::getComboBoxItems();
        $array_staff_areas = StaffArea::getComboBoxItems();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'array_entidades_financieras' => $array_entidades_financieras,
                        'array_staff_areas' => $array_staff_areas,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> $title,
                    'content'=>'<span class="text-success">Persona Creada.</span>',
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Crear Más',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'array_entidades_financieras' => $array_entidades_financieras,
                        'array_staff_areas' => $array_staff_areas,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->staff_persona_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'array_entidades_financieras' => $array_entidades_financieras,
                    'array_staff_areas' => $array_staff_areas,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing StaffPersona model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;

        $model  = $this->findModel($id);
        $title  = "Actualizar Persona-Staff : ".$model->getNombreCompleto();

        $array_entidades_financieras = PniaEntFinanciera::getComboBoxItems();     
        $array_staff_areas = StaffArea::getComboBoxItems();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'array_entidades_financieras' => $array_entidades_financieras,
                        'array_staff_areas' => $array_staff_areas,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> $title,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'array_entidades_financieras' => $array_entidades_financieras,
                        'array_staff_areas' => $array_staff_areas,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Editar',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'array_entidades_financieras' => $array_entidades_financieras,
                        'array_staff_areas' => $array_staff_areas,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->staff_persona_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'array_entidades_financieras' => $array_entidades_financieras,
                    'array_staff_areas' => $array_staff_areas,
                ]);
            }
        }
    }

    /**
     * Delete an existing StaffPersona model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        //$this->findModel($id)->delete();
        
        try {
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
        }catch (IntegrityException $e) {
           throw new \yii\web\HttpException(500,"No puede borrar esta persona. Primero debe desasociarla de su área y su usuario.", 405);
        }catch (\Exception $e) {
          throw new \yii\web\HttpException(500,"No puede borrar esta persona. Primero debe desasociarla de su área y su usuario.", 405);
        }
        
//        if($request->isAjax){
//            /*
//            *   Process for ajax request
//            */
//            Yii::$app->response->format = Response::FORMAT_JSON;
//            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
//        }else{
//            /*
//            *   Process for non-ajax request
//            */
//            return $this->redirect(['index']);
//        }


    }


     /**
     * Delete multiple existing StaffPersona model.
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
     * Finds the StaffPersona model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StaffPersona the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
   
    protected function findModel($id)
    {
        if (($model = StaffPersona::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::$app->params['testoEspañol']['paginaNoEncontrada']);
        }
    }

    public function actionAutocompletarNombreCompleto($q = null) {
        $query = new Query;
        $selectText = new Expression('CONCAT("nombres",'."' '".',"apellido_paterno","apellido_materno")');
        $query->select([
            "CONCAT(dni,' ',nombres,' ',apellido_paterno,' ',apellido_materno) as nombre_completo"])
            ->from('staff_persona')
            ->where(
                "CONCAT(nombres,' ',apellido_paterno,' ',apellido_materno)".' LIKE \'%' . $q .'%\' OR dni LIKE \'%'.$q.'%\'');
        $command = $query->createCommand();
        $requestData = $command->queryAll();
        $out = [];
        foreach ($requestData as $actlData) {
            $out[] = [
                //'id' => $actlData['staff_persona_id'],
                'nombre_completo' => $actlData['nombre_completo'],
            ];
        }
        return Json::encode($out);
    }

    public function actionAutocompletarNombreCompleto_edu($q = null) {
        $query = new Query;
        $selectText = new Expression('("nombres"+'."' '".'+"apellido_paterno"+"apellido_materno")');
        $query->select([
            "(dni+' '+nombres+' '+apellido_paterno+' '+apellido_materno) as nombre_completo"])
            ->from('staff_persona')
            ->where(
                "CONCAT(nombres+' '+apellido_paterno+' '+apellido_materno)".' LIKE \'%' . $q .'%\' OR dni LIKE \'%'.$q.'%\'');
        $command = $query->createCommand();
        $requestData = $command->queryAll();
        $out = [];
        foreach ($requestData as $actlData) {
            $out[] = [
                'nombre_completo' => $actlData['nombre_completo'],
            ];
        }
        return Json::encode($out);
    }

}
