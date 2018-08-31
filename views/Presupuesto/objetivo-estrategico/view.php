<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\ObjetivoEstrategico */
?>
<div class="objetivo-estrategico-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'objetivo_estrategico_id',
            'objetivo_descripcion',
            'estado_regitro',
        ],
    ]) ?>

</div>
