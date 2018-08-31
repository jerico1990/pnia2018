<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\CategoriaProducto */
?>
<div class="categoria-producto-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'categoria_producto_id',
            'categoria_producto_descripcion',
            'estado_regitro',
        ],
    ]) ?>

</div>
