<?php

namespace app\controllers\General;

use Yii;
use app\models\General\Postores;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\controllers\BehaviorController;

/**
 * PostoresController implements the CRUD actions for Postores model.
 */
class ReporteController extends Controller
{

    /**
     * Lists all Postores models.
     * @return mixed
     */
    public function actionIndex(){

        return $this->render('index');
    }

    public function actionGenerarListaReporte(){

        return $this->render('generar-lista-reporte');
    }



}
