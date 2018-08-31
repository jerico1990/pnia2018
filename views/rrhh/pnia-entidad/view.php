<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\rrhh\PniaEntidad */
?>
<div class="pnia-entidad-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'pnia_entidad_id',
            //'tipo_entidad',
            'tipoEntidad.descripcion',
            'ruc',
            'razon_social',
        ],
    ]) ?>

</div>
