<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Patrimonio\PatrimonioValorizacion */
?>
<div class="patrimonio-valorizacion-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'patrimonio_valorizacion_id',
            'patrimonio_item_id',
            'metacodigo_id',
            'valor',
            'fecha',
            'actualizado_en',
            'actualizado_por',
            'creado_en',
            'creado_por',
        ],
    ]) ?>

</div>
