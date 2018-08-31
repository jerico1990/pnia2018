<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
?>
<div class="usuario-view">
    <?php if(strcmp('', $model->password_temporal) != 0 ) {?>
        <p align = "center" > <?php echo $model->alias ?> tu contraseña ha sido re-establecida, guardala en un lugar seguro: <b><?php echo $model->password_temporal ?></b> </p>
    <?php } else { ?>
        Una o más preguntas secretas fueron mal contestadas.
    <?php } ?>

</div>
