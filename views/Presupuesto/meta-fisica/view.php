<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\MetaFisica */
?>
<div class="meta-fisica-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'meta_fisica_id',
            'descripcion',
            'avance_total',
            'avance_actual',
            'unidad_medida_id',
            'presupuesto_cabecera_id',
            'estado_regitro',
            'actualizado_en',
            'actualizado_por',
            'creado_en',
            'creado_por',
        ],
    ]) ?>

</div>
