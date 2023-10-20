<?php

namespace Barrio\Cristian
{
    require_once "../PP2023/clases/autoBD.php";

    if(isset($_POST["auto_json"]))
    {
        $datos = json_decode($_POST["auto_json"], true);
        $patente = $datos["patente"];
        $marca = $datos["marca"];
        $color = $datos["color"];
        $precio = $datos["precio"];
        $foto = $datos["pathFoto"];

        $auto = new AutoBD($patente, $marca, $color, $precio, $foto);

        if(AutoBD::eliminar($patente))
        {
            if($auto->guardarEnArchivo())
            {
                $retorno = array("exito" => true,
                "mensaje" => "Auto eliminado con éxito"); 
            }else
            {
                $retorno = array("exito" => false,
                "mensaje" => "Hubo un error al guardar el auto eliminado."); 
            }
        }
        else
        {
            $retorno = array("exito" => false,
            "mensaje" => "Hubo un error al eliminar el auto."); 
        }

        echo json_encode($retorno);
    }
    else if($_SERVER["REQUEST_METHOD"] === "GET")
    {
        if(file_exists("./archivos/autosbd_borrados.txt"))
        {
            echo "
            <table >
                <thead>
                    <tr>
                        <th>patente</th>
                        <th>marca</th>
                        <th>color</th>
                        <th>precio</th>
                        <th>path</th>
                        <th>foto</th>
                    </tr>
                </thead>"; 
            $tabla = "";
            $contenido = file_get_contents('./archivos/autosbd_borrados.txt');
            $lineas = explode("\n", $contenido);
            foreach ($lineas as $linea) 
            {
                // Dividir la línea en campos usando la coma como separador
                $campos = explode(',', $linea);
                // Crear una fila de la tabla con los datos
                echo '<tr>';
                foreach ($campos as $campo) {
                    // Dividir el campo en clave y valor usando el dos puntos como separador
                    $datos = explode(':', $campo);
                    if (count($datos) > 1) 
                    { // Verificar si el índice 1 está definido en el array $datos
                        $clave = trim($datos[0]);
                        $valor = trim($datos[1]);
                    if ($clave == "foto") 
                    {
                        $valor .= '</td><td><img src=../PP2023/autosBorrados/' . urlencode($valor) . ' width="200" height="200"></td>';
                    }
                    // Mostrar el valor en la celda correspondiente
                    echo '<td>' . $valor . '</td>';
                    }   
            }
                echo '</tr>';
            }
        $tabla .= "</table>";
    
        echo $tabla;
    }
    else
    {
        $retorno = array("exito" => false,
            "mensaje" => "Error");
            
        echo json_encode($retorno);
    }
}
}