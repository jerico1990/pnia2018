<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\PresupuestoCabecera */
?>
<div class="presupuesto-cabecera-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'presupuesto_cabecera_id',
            'presupuesto_version_id',
            'linea_id',
            'partida_id',
            'presupuesto_cabecera_padre_id',
            'actualizado_en',
            'actualizado_por',
            'creado_en',
            'creado_por',
        ],
    ]) ?>



</div>
