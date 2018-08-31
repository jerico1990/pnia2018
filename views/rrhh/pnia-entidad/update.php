<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\rrhh\PniaEntidad */
?>
<div class="pnia-entidad-update">

    <?= $this->render('_form', [
        'model' => $model,
        'array_metacodigo_tipo_entidad' => $array_metacodigo_tipo_entidad,
    ]) ?>

</div>
