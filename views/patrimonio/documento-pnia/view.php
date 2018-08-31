<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Patrimonio\DocumentoPnia */
?>
<div class="documento-pnia-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'documento_pnia_id',
            'ruta_documento',
            'nombre_documento',
            'documento_mimetype',
            'documento_charset',
            'documento_lastupd',
            'actualizado_en',
            'actualizado_por',
            'creado_en',
            'creado_por',
        ],
    ]) ?>

</div>
