<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\AccionEstrategica */
?>
<div class="accion-estrategica-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'accion_estrategica_id',
            'accion_descripcion',
            'estado_regitro',
        ],
    ]) ?>

</div>
