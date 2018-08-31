<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\presupuesto */
?>
<div class="presupuesto-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'presupuesto_id',
            'periodo_id',
            'presupuesto_cabecera_id',
            'presupuesto_plan_ro',
            'presupuesto_plan_rooc',
            'presupuesto_ejecutado_ro',
            'presupuesto_ejecutado_rooc',
            'presupuesto_saldo_ro',
            'presupuesto_saldo_rooc',
            'presupuesto_saldo_anual_ro',
            'presupuesto_saldo_anual_rooc',
            'estado',
            'presupuesto_compromiso_ro',
            'presupuesto_compromiso_rooc',
            'presupuesto_devengado_ro',
            'presupuesto_devengado_rooc',
            'presupuesto_girado_ro',
            'presupuesto_girado_rooc',
            'presupuesto_pagado_ro',
            'presupuesto_pagado_rooc',
            'actualizado_en',
            'actualizado_por',
            'creado_en',
            'creado_por',
        ],
    ]) ?>

</div>
