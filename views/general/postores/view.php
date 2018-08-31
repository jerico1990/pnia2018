<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\General\Postores */
?>
<div class="postores-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'postores_id',
            'dni',
            'nombres',
            'apellido_paterno',
            'apellido_materno',
            'ruc',
            'fecha_nacimiento',
            'email:email',
            'telefono',
            'actualizado_en',
            'actualizado_por',
            'creado_en',
            'creado_por',
        ],
    ]) ?>

</div>
