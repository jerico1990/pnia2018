<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\Proyecto */
?>
<div class="proyecto-update">

    <?= $this->render('_form', [
        'model' => $model,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]) ?>

</div>
