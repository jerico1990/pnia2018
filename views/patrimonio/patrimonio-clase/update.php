<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Patrimonio\PatrimonioClase */
?>
<div class="patrimonio-clase-update">

    <?= $this->render('_form', [
        'model' => $model,
        'patrimonios_clases' => $patrimonios_clases
    ]) ?>

</div>
