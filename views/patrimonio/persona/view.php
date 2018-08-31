<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Patrimonio\Persona */
?>
<div class="persona-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'persona_id',
            'nombre',
            // 'actualizado_en',
            // 'actualizado_por',
            // 'creado_en',
            // 'creado_por',
        ],
    ]) ?>

</div>
