<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Patrimonio\Ubicacion */
?>
<div class="ubicacion-update">

    <?= $this->render('_form', [
        'model' => $model,
        'ubicaciones' => $ubicaciones
    ]) ?>

</div>
