<?php

use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\rrhh\ContratoContrato */
?>
<div class="contrato-contrato-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'codigo_interno',
            [
                'label' => 'Entidad contratista',
                'attribute' => 'entidadContratista.razon_social',
            ],
            [
                'label' => 'Área contratante',
                'attribute' => 'areaContratante.descripcion',
            ],
            [
                'label' => 'Área responsable',
                'attribute' => 'areaResponsable.descripcion',
            ],
            'monto',
            'fecha_inicio',
            'fecha_fin',
            'objetivos',
            'contrato_origen',
            'flg_es_staff',
        ],
    ]) ?>
</div>