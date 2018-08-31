<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\MetaFinanciera */
$model->estado_regitro = 1;
?>
<div class="meta-financiera-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
