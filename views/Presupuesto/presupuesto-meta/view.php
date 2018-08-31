<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\PresupuestoMeta */
?>
<div class="presupuesto-meta-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'presupuesto_meta_id',
            'presupuesto_id',
            'meta_fisica_id',
            'meta_financiera_id',
            'unidad_fisica_consumida_temp',
            'unidad_financiera_consumida_temp',
            'unidad_fisica_consumida_final',
            'unidad_financiera_consumida_final',
            'estado_meta',
            'estado_financiero',
            'estado_regitro',
            'actualizado_en',
            'actualizado_por',
            'creado_en',
            'creado_por',
        ],
    ]) ?>

</div>
