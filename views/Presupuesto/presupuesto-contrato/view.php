<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\PresupuestoContrato */
?>
<div class="presupuesto-contrato-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'presupuesto_contrato_id',
            'contrato_descripcion',
            'nombre',
            'estado_regitro',
        ],
    ]) ?>

</div>
