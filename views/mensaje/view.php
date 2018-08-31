<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Mensaje */
?>
<div class="mensaje-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'mensaje_id',
            'titulo',
            'mensaje:ntext',
            'usuario_id_de',
            'usuario_id_para',
            'status',
            'creado_en',
        ],
    ]) ?>

</div>
