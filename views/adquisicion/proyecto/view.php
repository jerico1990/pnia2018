<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Adquisicion\Proyecto */
?>
<div class="proyecto-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'proyecto_id',
            'nombre',
            'actualizado_en',
            'actualizado_por',
            'creado_en',
            'creado_por',
        ],
    ]) ?>

</div>
