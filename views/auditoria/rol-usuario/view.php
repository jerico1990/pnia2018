<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RolUsuario */
?>
<div class="rol-usuario-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'rol_usuario_id',
            'usuario_id',
            'rol_id',
            'actualizado_en',
            'actualizado_por',
            'creado_en',
            'creado_por',
        ],
    ]) ?>

</div>
