<?php
echo "<table class=\"table\">";
    if($detalles)
    {
        foreach ($detalles as $det) {
            echo "<tr>";
                echo "<td>";
                    echo $det->rol_id;
                echo "</td>";
            echo "</tr>";
        }
    }
    else
        echo 'No existen roles asignados a este usuario';
    
echo "</table>";
// */
?>
