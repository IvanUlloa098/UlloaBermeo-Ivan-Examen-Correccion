<?php
    include '../../config/conexionBD.php';
    $capitulo = isset($_POST["capitulo"]) ? trim($_POST["capitulo"]) : null;
    $codigo = 0;

    $sql = "SELECT lib_codigo, lib_nombre, lib_isbn, lib_num_paginas, cap_cod, cap_numero, cap_titulo, aut_nombre, aut_nacionalidad FROM libro, autor, 
            (SELECT cap_cod, cap_numero, cap_titulo, capitulo.lib_cod, aut_cod FROM capitulo, 
            (SELECT lib_cod FROM capitulo WHERE cap_titulo = '$capitulo') AS tab
            WHERE capitulo.lib_cod = tab.lib_cod) AS tab_2
            WHERE tab_2.lib_cod = libro.lib_codigo AND tab_2.aut_cod = autor.aut_cod;";

    $resul = $conn->query($sql);

    if($resul->num_rows > 0 ){

        echo "<table style='width:65%'>
            <tr>
                <th>Libro</th>
                <th>ISBN</th>
                <th>Paginas</th>
                <th>Numero del capítulo</th>
                <th>Título del capítulo</th> 
                <th>Autor</th>
                <th>Nacionalidad</th> 
            </tr>";
            
        while ($row = $resul->fetch_assoc()){

            echo "<tr>";
            if ($codigo == $row['lib_codigo']) {

                echo "<td>''</td>";
                echo "<td>''</td>";
                echo "<td>''</td>";
                echo "<td>" .$row['cap_numero']. "</td>";
                echo "<td>" .$row['cap_titulo']. "</td>";
                echo "<td>" .$row['aut_nombre']. "</td>";
                echo "<td>" .$row['aut_nacionalidad']. "</td>";
                
                $codigo = $row['lib_codigo'];

            } else {

                echo "<td>" .$row['lib_nombre']. "</td>";
                echo "<td>" .$row['lib_isbn']. "</td>";
                echo "<td>" .$row['lib_num_paginas']. "</td>";
                echo "<td>" .$row['cap_numero']. "</td>";
                echo "<td>" .$row['cap_titulo']. "</td>";
                echo "<td>" .$row['aut_nombre']. "</td>";
                echo "<td>" .$row['aut_nacionalidad']. "</td>";

                $codigo = $row['lib_codigo'];

            }
            echo "</tr>";
            
            
            
        }
        

    }else {
        echo "<tr>";
        echo " <td colspan='7'> <em><strong>No hay Ningun capitulo con ese titulo</strong></em></td>";
        echo "</tr>";
    }
    echo "</table>";
    $conn->close();
    


?>