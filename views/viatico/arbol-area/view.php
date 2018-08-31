<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Viatico\ArbolArea */
?>
<div class="arbol-area-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'arbol_area_id',
            'staff_area_id',
            'presupuesto_cabecera_id',
            'actualizado_en',
            'actualizado_por',
            'creado_en',
            'creado_por',
        ],
    ]) ?>

</div>
