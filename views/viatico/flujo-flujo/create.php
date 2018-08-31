<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Viatico\FlujoFlujo */

?>
<div class="flujo-flujo-create">
    <?= $this->render('_form', [
        'model' => $model,
        'array_metacodigo_tipo_flujo' => $array_metacodigo_tipo_flujo

    ]) ?>
</div>
