<?php

namespace app\controllers\Presupuesto;

use app\models\Presupuesto\Presupuesto;
use app\models\Presupuesto\PresupuestoCabecera;
use Yii;
use app\models\Presupuesto\PresupuestoVersion;
use app\models\Presupuesto\PresupuestoVersionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * PresupuestoVersionController implements the CRUD actions for PresupuestoVersion model.
 */
class PresupuestoVersionController extends Controller
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
     * Lists all PresupuestoVersion models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new PresupuestoVersionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single PresupuestoVersion model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $title = "Versión ".$model->nro_version.' - '.$model->fecha;
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

    public function actionTestParaEdu(){
        $model_presupuesto_cabecera = new PresupuestoCabecera();
        $cabeceraPresupuesto = $model_presupuesto_cabecera->getPresupuestoCabeceraLink(2);
        if ($cabeceraPresupuesto->presupuestoContrato){
            $resultado = $cabeceraPresupuesto->presupuestoContrato->esBancoMundial();
            if ($resultado)
                $this->codigo_interno = $this->contrato_contrato_id//strval($numero_random)
                    . '-INIA/PNIA' . '-BM';
            else
                $this->codigo_interno = $this->contrato_contrato_id//strval($numero_random) .
                    .'-INIA/PNIA' . '-BID';

        }

    }

    public function actionTestUpdate(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $rpta = [];

        $presupuesto_id  = 29;
        $this_var = Presupuesto::findOne($presupuesto_id);
        $this_var->presupuesto_pagado_ro = 100;
        $this_var->actualizarLocalmente(0,0);


        $this_var_1st_act_loc = Presupuesto::findOne($presupuesto_id);
        $this_var_1st_act_loc->presupuesto_pagado_ro = 100;
        $this_var_1st_act_loc->actualizarLocalmente(0,0);
        $rpta['estado alterado'] = $this_var_1st_act_loc;

        $mi_cabecera = $this_var->presupuestoCabecera;

        $this_var->actualizarLocalmente(0,0);
        $estado_previo     = Presupuesto::findOne(['presupuesto_id' => $presupuesto_id]);
        $rpta['estado original'] = $estado_previo;
        $cabecera_padre    = $mi_cabecera->presupuestoCabeceraPadre;
        $plan_usado_padre  = $cabecera_padre->getSumPlanHijos($this_var->periodo_id);
        $presupuesto_padre = $cabecera_padre->getPresupuestoEn($this_var->periodo_id);

        $temp_plan_ro      = $this_var->presupuesto_plan_ro
                             - $estado_previo->presupuesto_plan_ro;
        $temp_plan_rooc    = $this_var->presupuesto_plan_rooc
                            - $estado_previo->presupuesto_plan_rooc;


        $rpta['presupuesto_padre->presupuesto_plan_ro'] = $presupuesto_padre->presupuesto_plan_ro;
        $rpta['presupuesto_padre->presupuesto_prestado_ro'] = $presupuesto_padre->presupuesto_prestado_ro;
        $rpta['plan usado padre'] = $plan_usado_padre;
        $rpta['temp_plan_ro'] = $temp_plan_ro;

        if (($presupuesto_padre->presupuesto_plan_ro   + $presupuesto_padre->presupuesto_prestado_ro  )
            < ($plan_usado_padre['ro']   + $temp_plan_ro)
            OR
            ($presupuesto_padre->presupuesto_plan_rooc + $presupuesto_padre->presupuesto_prestado_rooc)
            < ($plan_usado_padre['rooc'] + $temp_plan_rooc)
        ){

            $saldo_disponible_prev   = $cabecera_padre->getPresupuestoDisponibleHasta($this_var->periodo_id);

            $rpta['saldo previo disponible'] = $saldo_disponible_prev;


            $prestamo_requerido_ro   = $temp_plan_ro
                    - ($presupuesto_padre->presupuesto_plan_ro
                    + $presupuesto_padre->presupuesto_prestado_ro
                    - $plan_usado_padre['ro']);

            $rpta['$prestamo_requerido_ro'] = $prestamo_requerido_ro;

            $prestamo_requerido_rooc = $temp_plan_rooc
                    - ($presupuesto_padre->presupuesto_plan_rooc
                    + $presupuesto_padre->presupuesto_prestado_rooc
                    - $plan_usado_padre['rooc']);

            if ( $saldo_disponible_prev['ro']   < $prestamo_requerido_ro OR
                 $saldo_disponible_prev['rooc'] < $prestamo_requerido_rooc ){
                $rpta['RESULTADO'] = false;
                return $rpta;
            }

            $this_var->presupuesto_prestado_ro   += $prestamo_requerido_ro;
            $this_var->presupuesto_prestado_rooc += $prestamo_requerido_rooc;

            $this_var->presupuesto_plan_ro       = $this_var->presupuesto_planificado_ro   - $prestamo_requerido_ro;
            $this_var->presupuesto_plan_rooc     = $this_var->presupuesto_planificado_rooc - $prestamo_requerido_rooc;

            $rpta['estado final'] = $this_var;
            $rpta['RESULTADO-r'] = 're-calculo';

        }
        $this_var->copia_previa = $estado_previo;

        $rpta['RESULTADO'] = true;
        return $rpta;
    }

    public function actionTest(){

        $rpta = [];
        $presupuesto_cabecera = PresupuestoCabecera::getPresupuestoCabeceraLink(1);
        //$rpta['cabecera'] = $presupuesto_cabecera;


        $ultima_version = PresupuestoVersion::getUltimaVersion()->presupuesto_version_id;
        $rpta['version_id'] = $ultima_version ;
        $presupuesto_cabecera = PresupuestoCabecera::getPresupuestoCabeceraLink(3);
        $rpta['cabecera'] = $presupuesto_cabecera->presupuesto_cabecera_id;
        $rpta['periodos'] = $presupuesto_cabecera->getTrimestresyAnhos();
// */


/*
        $presupuesto_cabecera = PresupuestoCabecera::getPresupuestoCabeceraLink(1);


        //$rpta = $presupuesto_cabecera->reajustePresupuestarioLocal(1,2018,3);
        // */

/*
        $presupuesto_cabecera = PresupuestoCabecera::getPresupuestoCabeceraLink(3);
        $rpta['enero'] = $presupuesto_cabecera->getPresupuestos()->where(['periodo_id' => 2])->one();
        //*/

/*
        $presupuesto_cabecera = PresupuestoCabecera::getPresupuestoCabeceraLink(4);
        $actualizado = $presupuesto_cabecera->crearRequerimiento(3,5.25,'presupuesto_ejecutado_ro');
        $rpta['cabecera'] = $presupuesto_cabecera;
        $rpta['actualizado'] = $actualizado;// */


/*
        $presupuesto_cabecera = PresupuestoCabecera::getPresupuestoCabeceraLink(2);
        $rpta[] = $presupuesto_cabecera->getPresupuestoDisponibleHasta(4);
        //*/


/*
        $presupuesto_cabecera = PresupuestoCabecera::findOne(['presupuesto_cabecera_id' => 1]);
        $presupuesto_cabecera->actualizarJerarquiaPadre();
        $presupuesto_cabecera_padre = $presupuesto_cabecera->presupuestoCabeceraPadre;
        //$presupuesto_cabecera_padre->esta_actualizado = true;
        //$presupuesto_cabecera_padre->save();
        //$rpta[] = $presupuesto_cabecera_padre;

        $periodo_id = 1;
        $rpta['ro']   = $presupuesto_cabecera->hasMany(Presupuesto::className(), ['presupuesto_cabecera_id' => 'presupuesto_cabecera_id'])
            ->viaTable(PresupuestoCabecera::tableName(),['presupuesto_cabecera_padre_id' => 'presupuesto_cabecera_id'])->where('periodo_id = '.$periodo_id)->sum('presupuesto_plan_ro');
        $rpta['rooc'] = $presupuesto_cabecera->hasMany(Presupuesto::className(), ['presupuesto_cabecera_id' => 'presupuesto_cabecera_id'])
            ->viaTable(PresupuestoCabecera::tableName(),['presupuesto_cabecera_padre_id' => 'presupuesto_cabecera_id'])->where('periodo_id = '.$periodo_id)->sum('presupuesto_plan_rooc');

        //$rpta[] = $presupuesto_cabecera->getPresupuestoCabecerasHijos()-> ->all();// ->sum('presupuesto_plan_ro');
 /// */

        $rpta = [];

        /*
        $presupuesto_cabecera = PresupuestoCabecera::findOne(['presupuesto_cabecera_id' => 1]);
        $presupuesto_actual   = $presupuesto_cabecera->getPresupuestos()->where(['periodo_id' => 1])->one();
        $presupuesto_cabecera_mod = $presupuesto_cabecera->getPresupuestos()->where(['periodo_id' => 1])->one();;
        $rpta['original']   = $presupuesto_actual;
        $rpta['modificado'] = $presupuesto_cabecera_mod;
        $rpta['modificado']->presupuesto_plan_ro = 55;
        $rpta['modificado']->actualizarLocalmente(0,0);
        // */

        /*
        $presupuesto_id = 29;
        $estado_previo = Presupuesto::findOne(['presupuesto_id' => $presupuesto_id]);
        $estado_actual = Presupuesto::findOne(['presupuesto_id' => $presupuesto_id]);
        $estado_actual->presupuesto_compromiso_ro = 30;
        $estado_actual->actualizarLocalmente(0,0);
        $estado_actual->restarPresupuesto($estado_previo);
        $rpta['estado actual'] = $estado_actual;
        $rpta['estado resta'] = $estado_previo;

        $mi_cabecera = $estado_previo->presupuestoCabecera;

        $presupuesto_padre_previo = $mi_cabecera->presupuestoCabeceraPadre->getPresupuestoEn($estado_previo->periodo_id);
        $rpta['padre previo'] = $presupuesto_padre_previo;
        $presupuesto_padre = $mi_cabecera->presupuestoCabeceraPadre->getPresupuestoEn($estado_previo->periodo_id);
        $presupuesto_padre->sumarPresupuesto($estado_actual);
        $presupuesto_padre->actualizarLocalmente(0,0);
        $presupuesto_padre->actualizarLocalmente(0,0);
        $presupuesto_padre->actualizarLocalmente(0,0);
        $presupuesto_padre->actualizarLocalmente(0,0);
        $rpta['padre suma'] = $presupuesto_padre; //*/
        /*
        if ( $presupuesto_padre->presupuesto_saldo_ro < 0 OR $presupuesto_padre->presupuesto_saldo_rooc < 0 ){
            $saldos_previos = $presupuesto_padre->presupuestoCabecera->getPresupuestoDisponibleHasta($this->periodo_id);
            if ( $presupuesto_padre->presupuesto_saldo_ro + $saldos_previos['ro'] < 0
                AND $presupuesto_padre->presupuesto_saldo_rooc + $saldos_previos['rooc'] < 0 ){
                return false;
            }
        }else{/// aquí esta la recursividad
            $presupuesto_padre->save();
            return true;
        }
//*/

        /*
        $periodo_id = 2;
        $presupuesto_actual  = Presupuesto::findOne(['periodo_id' => $periodo_id, 'presupuesto_cabecera_id' => 3]);
        $mi_cabecera = $presupuesto_actual->presupuestoCabecera;
        $cabecera_padre = $mi_cabecera->presupuestoCabeceraPadre;
        $presupuesto_padre = $cabecera_padre->getPresupuestoEn($periodo_id);
        $rpta[] = $presupuesto_padre->presupuesto_plan_ro;
        $rpta[] = $mi_cabecera->presupuestoCabeceraPadre->getSumPlanHijos($periodo_id);
        // */

        /*
        $rpta['solo hojas'] = PresupuestoCabecera::getComboBoxItems(true);
        $rpta['todo'] = PresupuestoCabecera::getComboBoxItems(false);
        $rpta['periodos_disponibles'] = PresupuestoCabecera::getComboBoxPeriodosDisponibles(1);

        $rpta['disponible']= PresupuestoCabecera::findOne(3)->obtenerPresupuestoDisponible(2);
        // */


        $periodo_id = 3;
        /*
        $presupuesto_actual  = Presupuesto::findOne(['periodo_id' => $periodo_id, 'presupuesto_cabecera_id' => 4]);
        $presupuesto_actual->presupuesto_compromiso_rooc = 5000;
        $presupuesto_actual->save();
    // */
        $presupuesto_actual  = Presupuesto::findOne(['periodo_id' => $periodo_id, 'presupuesto_cabecera_id' => 3]);
        $mi_cabecera = $presupuesto_actual->presupuestoCabecera;
        $rpta ['saldo']= $mi_cabecera->getPresupuestoDisponibleHasta(8);
        /*
        $mi_cabecera = $presupuesto_actual->presupuestoCabecera;
        $cabecera_padre = $mi_cabecera->presupuestoCabeceraPadre;
        $presupuesto_padre = $cabecera_padre->getPresupuestoEn($periodo_id);
        $rpta[] = $presupuesto_padre->presupuesto_plan_ro;
        $rpta[] = $mi_cabecera->presupuestoCabeceraPadre->getSumPlanHijos($periodo_id);
        //*/
        //$rpta[] = Presupuesto::findOne(['periodo_id' => $periodo_id, 'presupuesto_cabecera_id' => 4]);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $rpta;
    }

    public function actionTest2(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $rpta = [];
        $rpta[] = PresupuestoCabecera::getComboBoxItems(false);
        return $rpta;
    }


    public function actionFullVersionClone(){

        $presupuesto_cabecera = PresupuestoCabecera::findOne(3);
        $rpta = $presupuesto_cabecera->obtenerPresupuestoDisponible(12);

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $rpta;

/*
        //PresupuestoCabecera::guardarNuevaVersionTotal(1);
        $presupuesto_cabecera->crearRequerimiento(2,10,'presupuesto_pagado_ro');
        $value = $presupuesto_cabecera->moverMontos(2,'presupuesto_pagado_ro','presupuesto_ejecutado_ro',10);
        $periodos = PresupuestoCabecera::getComboBoxPeriodosDisponibles($presupuesto_cabecera->presupuesto_cabecera_id);

            if ($value){
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $periodos;
                //return 'funciono =)';
            }else{
                return 'algo exploto';
            }
// */
    }

    /**
     * Creates a new PresupuestoVersion model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new PresupuestoVersion();
        $array_versiones_previas = PresupuestoVersion::getComboBoxItems();
        $title = "Crear Nueva Versión de Presupuestos";
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
                        'array_versiones_previas' => $array_versiones_previas,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> $title,
                    'content'=>'<span class="text-success">Registro exitoso</span>',
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Crear Más',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'array_versiones_previas' => $array_versiones_previas,
                    ]),
                    'footer'=> Html::button('Crear',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->presupuesto_version_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'array_versiones_previas' => $array_versiones_previas,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing PresupuestoVersion model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       
        $title = "Actualizar Versión ".$model->nro_version.' - '.$model->fecha;
        $array_versiones_previas = PresupuestoVersion::getComboBoxItems();
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
                        'array_versiones_previas' => $array_versiones_previas,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> $title,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'array_versiones_previas' => $array_versiones_previas,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> $title,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'array_versiones_previas' => $array_versiones_previas,
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
                return $this->redirect(['view', 'id' => $model->presupuesto_version_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'array_versiones_previas' => $array_versiones_previas,
                ]);
            }
        }
    }

    /**
     * Delete an existing PresupuestoVersion model.
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
     * Delete multiple existing PresupuestoVersion model.
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
     * Finds the PresupuestoVersion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PresupuestoVersion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PresupuestoVersion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
