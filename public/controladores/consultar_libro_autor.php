<?php
    include '../../config/conexionBD.php';
    $autor = isset($_POST["autor"]) ? trim($_POST["autor"]) : null;
    $codigo = 0;

    $sql = "SELECT libro.lib_codigo, libro.lib_nombre, libro.lib_isbn, libro.lib_num_paginas, tab_2.cap_numero, tab_2.cap_titulo, tab_2.aut_nombre, tab_2.aut_nacionalidad 
    FROM libro, (SELECT cap_numero, cap_titulo, lib_cod, tab.aut_nombre, tab.aut_nacionalidad FROM capitulo, 
    (SELECT aut_cod, aut_nombre, aut_nacionalidad FROM autor WHERE aut_nombre = '$autor') AS tab 
    WHERE capitulo.aut_cod = tab.aut_cod) AS tab_2 WHERE libro.lib_codigo = tab_2.lib_cod;";

    $resul = $conn->query($sql);

    if($resul->num_rows > 0 ){

        echo "<table style='width:65%'>
            <tr>
                <th>Autor</th>
                <th>Nacionalidad</th>
                <th>Libro</th>
                <th>ISBN</th>
                <th>Paginas</th>
                <th>Numero del capítulo</th>
                <th>Título del capítulo</th>  
            </tr>";
            
        while ($row = $resul->fetch_assoc()){

            echo "<tr>";
            if ($codigo == $row['lib_codigo']) {

                echo "<td>''</td>";
                echo "<td>''</td>";
                echo "<td>''</td>";
                echo "<td>''</td>";
                echo "<td>''</td>";
                echo "<td>" .$row['cap_numero']. "</td>";
                echo "<td>" .$row['cap_titulo']. "</td>";
                
                $codigo = $row['lib_codigo'];

            } else {

                echo "<td>" .$row['aut_nombre']. "</td>";
                echo "<td>" .$row['aut_nacionalidad']. "</td>";
                echo "<td>" .$row['lib_nombre']. "</td>";
                echo "<td>" .$row['lib_isbn']. "</td>";
                echo "<td>" .$row['lib_num_paginas']. "</td>";
                echo "<td>" .$row['cap_numero']. "</td>";
                echo "<td>" .$row['cap_titulo']. "</td>";

                $codigo = $row['lib_codigo'];

            }
            echo "</tr>";
            
            
            
        }
        

    }else {
        echo "<tr>";
        echo " <td colspan='7'> <em><strong>No hay Ningun Autor con ese nombre</strong></em></td>";
        echo "</tr>";
    }
    echo "</table>";
    $conn->close();
    


?>