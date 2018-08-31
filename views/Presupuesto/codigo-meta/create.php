<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\CodigoMeta */
$model->estado_regitro = 1;
?>
<div class="codigo-meta-create">
    <?= $this->render('_form', [
        'model' => $model,
        'es_update' => false,
    ]) ?>
</div>
