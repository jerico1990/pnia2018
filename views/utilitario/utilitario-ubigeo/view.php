<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Utilitario\UtilitarioUbigeo */
?>
<div class="utilitario-ubigeo-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'utilitario_ubigeo_id',
            'nombre',
            'ubigeo_region_id',
            'ubigeo_provincia_id',
            'actualizado_en',
            'creado_en',
            'creado_por',
            'actualizado_por',
        ],
    ]) ?>

</div>
