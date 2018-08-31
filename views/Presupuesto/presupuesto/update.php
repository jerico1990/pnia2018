<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\presupuesto */
?>
<div class="presupuesto-update">

    <?= $this->render('_form', [
        'model' => $model,
        'array_metacodigo_estados' => $array_metacodigo_estados,
    ]) ?>

</div>
