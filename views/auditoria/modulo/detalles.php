<?php
echo "<table class=\"table\">";
    foreach ($procesos as $proceso) {
        echo "<tr>";
            echo "<td>";
                echo $proceso->descripcion;
            echo "</td>";
        echo "</tr>";
    }
echo "</table>";
// */
?>
