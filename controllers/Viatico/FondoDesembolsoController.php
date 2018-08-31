<?php

namespace app\controllers\Viatico;

use Yii;
use app\models\Viatico\FondoFondo;
use app\models\Viatico\FondoFondoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\controllers\BehaviorController;
use app\models\ModeloGenerico;
use app\models\rrhh\StaffPersona;
use app\models\Viatico\FlujoRequerimiento;
use app\models\Patrimonio\Metacodigo;
use app\models\Patrimonio\DocumentoPnia;
use app\models\rrhh\PniaEntFinanciera;
use yii\web\UploadedFile;
use yii\db\Query;
use yii\helpers\Json;
/**
 * FondoFondoController implements the CRUD actions for FondoFondo model.
 */
class FondoDesembolsoController extends BehaviorController
{

    /**
     * Lists all FondoFondo models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new FondoFondoSearch();
        $dataProvider = $searchModel->searchDesembolso(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single FondoFondo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $metacodigo = new Metacodigo();
        $model_metacodigo = $metacodigo->findById($model->tipo_flujo_metacodigo);
        $title = "Fondo de Desembolso: ".$model->motivo." - ".$model_metacodigo->descripcion;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> $title,
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
     * Creates a new FondoFondo model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new FondoFondo();  

        $lista_flujo_requerimiento = FlujoRequerimiento::getComboBoxItemsFiltrados('Desembolso');
        $array_metacodigo_tipo_flujo = Metacodigo::getComboBoxItems('Tipo_flujo');

        $model_documento_pnia = new DocumentoPnia();

        $array_lista_entidad_financiera = PniaEntFinanciera::getComboBoxItems();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Crear nuevo Fondo de Desembolso",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'lista_flujo_requerimiento' => $lista_flujo_requerimiento,
                        'array_metacodigo_tipo_flujo' => $array_metacodigo_tipo_flujo,
                        'model_documento_pnia' => $model_documento_pnia,
                        'array_lista_entidad_financiera' => $array_lista_entidad_financiera,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if ($model_documento_pnia->load(Yii::$app->request->post())) {
                
                $documento = UploadedFile::getInstance($model_documento_pnia, 'ruta_documento');
                if (isset($documento->extension))
                {
                    //echo Yii::getAlias('@uploadedfilesdir') . $documento->baseName . '.' . $documento->extension;  
                    $documento->saveAs(Yii::getAlias('@uploadedfilesdir') . $documento->baseName . '.' . $documento->extension); 
                    $model_documento_pnia->ruta_documento = Yii::getAlias('@uploadedfilesdir') . $documento->baseName . '.' . $documento->extension;
                    $model_documento_pnia->nombre_documento = $documento->baseName . '.' . $documento->extension;
                    $model_documento_pnia->documento_mimetype = $documento->extension;
                    $model_documento_pnia->save();

                    $model->resolucion_directoral_pnia_documento_id = $model_documento_pnia->documento_pnia_id;
                }
                

                
                if($model->load($request->post()) && $model->save()){
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "Crear nuevo Fondo de Desembolso",
                        'content'=>'<span class="text-success">Fondo de desembolso creado</span>',
                        'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::a('Crear Más',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
            
                    ];     
                }
                else
                    echo ("Verifique que los campos obligatorios hayan sido rellenados.");
                    //return $model->save();
                
            } else{           
                return [
                    'title'=> "Crear nuevo Fondo de Desembolso",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'lista_flujo_requerimiento' => $lista_flujo_requerimiento,
                        'array_metacodigo_tipo_flujo' => $array_metacodigo_tipo_flujo,
                        'model_documento_pnia' => $model_documento_pnia,
                        'array_lista_entidad_financiera' => $array_lista_entidad_financiera,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model_documento_pnia->load(Yii::$app->request->post())) {
                
                $documento = UploadedFile::getInstance($model_documento_pnia, 'ruta_documento');
                if (isset($documento->extension))
                {
                    //echo Yii::getAlias('@uploadedfilesdir') . $documento->baseName . '.' . $documento->extension;  
                    $documento->saveAs(Yii::getAlias('@uploadedfilesdir') . $documento->baseName . '.' . $documento->extension); 
                    $model_documento_pnia->ruta_documento = Yii::getAlias('@uploadedfilesdir') . $documento->baseName . '.' . $documento->extension;
                    $model_documento_pnia->nombre_documento = $documento->baseName . '.' . $documento->extension;
                    $model_documento_pnia->documento_mimetype = $documento->extension;
                    $model_documento_pnia->save();

                    $model->resolucion_directoral_pnia_documento_id = $model_documento_pnia->documento_pnia_id;
                }
                
                
                if($model->load($request->post()) && $model->save()){
                    return $this->redirect(['view', 'id' => $model->fondo_fondo_id]);
                }
                else
                    echo ("Verifique que los campos obligatorios hayan sido rellenados.");
                
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'lista_flujo_requerimiento' => $lista_flujo_requerimiento,
                    'array_metacodigo_tipo_flujo' => $array_metacodigo_tipo_flujo,
                    'model_documento_pnia' => $model_documento_pnia,
                    'array_lista_entidad_financiera' => $array_lista_entidad_financiera,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing FondoFondo model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        $metacodigo = new Metacodigo();
        $model_metacodigo = $metacodigo->findById($model->tipo_flujo_metacodigo);
        $title = "Actualizar Fondo : ".$model->motivo." - ".$model_metacodigo->descripcion;
        $model->autocomplete_staff_persona = StaffPersona::getDniNombreById($model->responsable_persona_id);    

        $lista_flujo_requerimiento = FlujoRequerimiento::getComboBoxItemsFiltrados('Desembolso');

        $array_metacodigo_tipo_flujo = Metacodigo::getComboBoxItems('Tipo_flujo');

        $model_documento_pnia = new DocumentoPnia();

        $array_lista_entidad_financiera = PniaEntFinanciera::getComboBoxItems();

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
                        'lista_flujo_requerimiento' => $lista_flujo_requerimiento,
                        'array_metacodigo_tipo_flujo' => $array_metacodigo_tipo_flujo,
                        'model_documento_pnia' => $model_documento_pnia,
                        'array_lista_entidad_financiera' => $array_lista_entidad_financiera,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if ($model_documento_pnia->load(Yii::$app->request->post())) {
                
                $documento = UploadedFile::getInstance($model_documento_pnia, 'ruta_documento');
                if (isset($documento->extension))
                {
                    //echo Yii::getAlias('@uploadedfilesdir') . $documento->baseName . '.' . $documento->extension;  
                    $documento->saveAs(Yii::getAlias('@uploadedfilesdir') . $documento->baseName . '.' . $documento->extension); 
                    $model_documento_pnia->ruta_documento = Yii::getAlias('@uploadedfilesdir') . $documento->baseName . '.' . $documento->extension;
                    $model_documento_pnia->nombre_documento = $documento->baseName . '.' . $documento->extension;
                    $model_documento_pnia->documento_mimetype = $documento->extension;
                    $model_documento_pnia->save();

                    $model->resolucion_directoral_pnia_documento_id = $model_documento_pnia->documento_pnia_id;
                }
                
                
                if($model->load($request->post()) && $model->save()){
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> $title,
                        'content'=>$this->renderAjax('view', [
                            'model' => $model,
                            'lista_flujo_requerimiento' => $lista_flujo_requerimiento,
                            'array_metacodigo_tipo_flujo' => $array_metacodigo_tipo_flujo,
                            'model_documento_pnia' => $model_documento_pnia,
                            'array_lista_entidad_financiera' => $array_lista_entidad_financiera,
                        ]),
                        'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::a('Guardar',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                    ];    
                }
                else
                    echo ("Verifique que los campos obligatorios hayan sido rellenados.");
                
            } else{
                 return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'lista_flujo_requerimiento' => $lista_flujo_requerimiento,
                        'array_metacodigo_tipo_flujo' => $array_metacodigo_tipo_flujo,
                        'model_documento_pnia' => $model_documento_pnia,
                        'array_lista_entidad_financiera' => $array_lista_entidad_financiera,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */

            if ($model_documento_pnia->load(Yii::$app->request->post())) {
                
                $documento = UploadedFile::getInstance($model_documento_pnia, 'ruta_documento');
                if (isset($documento->extension))
                {
                    //echo Yii::getAlias('@uploadedfilesdir') . $documento->baseName . '.' . $documento->extension;  
                    $documento->saveAs(Yii::getAlias('@uploadedfilesdir') . $documento->baseName . '.' . $documento->extension); 
                    $model_documento_pnia->ruta_documento = Yii::getAlias('@uploadedfilesdir') . $documento->baseName . '.' . $documento->extension;
                    $model_documento_pnia->nombre_documento = $documento->baseName . '.' . $documento->extension;
                    $model_documento_pnia->documento_mimetype = $documento->extension;
                    $model_documento_pnia->save();

                    $model->resolucion_directoral_pnia_documento_id = $model_documento_pnia->documento_pnia_id;
                }
                
                
                if($model->load($request->post()) && $model->save()){
                    return $this->redirect(['view', 'id' => $model->fondo_fondo_id]);
                }
                else
                    echo ("Verifique que los campos obligatorios hayan sido rellenados.");
                
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'lista_flujo_requerimiento' => $lista_flujo_requerimiento,
                    'array_metacodigo_tipo_flujo' => $array_metacodigo_tipo_flujo,
                    'model_documento_pnia' => $model_documento_pnia,
                    'array_lista_entidad_financiera' => $array_lista_entidad_financiera,
                ]);
            }
        }
    }

    /**
     * Delete an existing FondoFondo model.
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
     * Delete multiple existing FondoFondo model.
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
     * Finds the FondoFondo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FondoFondo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FondoFondo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAutocompleteFondo($q = null, $id = null) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('fondo_fondo_id AS id, motivo AS text')
                ->from('fondo_fondo')
                ->where(['like', 'motivo', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        // elseif ($id > 0) {
        //     $out['results'] = ['id' => $id, 'text' => City::find($id)->name];
        // }
        return $out;
    }
}
