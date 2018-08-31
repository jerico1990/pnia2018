<?php
echo "<table class=\"table\">";
    if($detalles)
    {
        foreach ($detalles as $det) {
            echo "<tr>";
                echo "<td>";
                    echo $det->descripcion;
                echo "</td>";
            echo "</tr>";
        }
    }
    else
        echo 'No existen procesos asignados a este rol';
    
echo "</table>";
// */
?>
