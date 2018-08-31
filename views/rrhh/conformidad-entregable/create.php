<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\rrhh\ConformidadEntregable */

?>
<div class="conformidad-entregable-create">
    <?= $this->render('_form', [
        'model' => $model,
        'array_tipo_conformidad' => $array_tipo_conformidad,
        'model_documento_pnia' => $model_documento_pnia,
    ]) ?>
</div>
