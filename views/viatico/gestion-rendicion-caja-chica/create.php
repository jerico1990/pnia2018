<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Viatico\FondoRendicionGenerico */

?>
<div class="fondo-rendicion-generico-create">
    <?= $this->render('_form', [
        'model' => $model,
        'array_tipo_afecto' => $array_tipo_afecto,
        'array_metacodigo_tipo_bien_servicio' => $array_metacodigo_tipo_bien_servicio,
        'array_metacodigo_documento_rendicion' => $array_metacodigo_documento_rendicion,
        'array_pnia_entidades' => $array_pnia_entidades,
    ]) ?>
</div>
