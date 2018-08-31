<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
?>
<div class="usuario-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nombre',
            'alias',
            // 'clave_autenticacion',
            // 'password_hash',
            // 'token_de_acceso',
        ],
    ]) ?>

</div>
