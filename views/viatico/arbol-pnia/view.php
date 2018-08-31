<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Viatico\ArbolPnia */
?>
<div class="arbol-pnia-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'arbol_pnia_id',
            'descripcion',
            // 'actualizado_en',
            // 'actualizado_por',
            // 'creado_en',
            // 'creado_por',
        ],
    ]) ?>

</div>
