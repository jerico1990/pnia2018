<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Adquisicion\Adjudicacion */
?>
<div class="adjudicacion-update">

    <?= $this->render('_form_autorizacion_adjudicacion', [
        'model' => $model,
        'searchModelPostor' => $searchModelPostor,
        'dataProviderPostor' => $dataProviderPostor,
    ]) ?>

</div>
