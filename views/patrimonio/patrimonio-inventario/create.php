<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Patrimonio\PatrimonioInventario */

?>
<div class="patrimonio-inventario-create">
    <?= $this->render('_form', [
        'model' => $model,
        'metacodigo_condicion' => $metacodigo_condicion,
        'metacodigo_estado' => $metacodigo_estado,
        'ubicaciones' => $ubicaciones,
        'items' => $items,
        'user' => $user,
        'model_documento_pnia' => $model_documento_pnia,
    ]) ?>
</div>
