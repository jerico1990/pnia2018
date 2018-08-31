<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\rrhh\PniaEntFinanciera */
?>
<div class="pnia-ent-financiera-update">

    <?= $this->render('_form', [
        'model' => $model,
        'array_lista_tipo_entidad_financiera' => $array_lista_tipo_entidad_financiera,
    ]) ?>

</div>
