<?php
namespace Barrio\Cristian
{
    require_once "../PP2023/clases/autoBD.php";

    if(isset($_POST["auto_json"], $_FILES["foto"]))
    {
        $datos = json_decode($_POST["auto_json"], true);
        $patente = $datos["patente"];
        $marca = $datos["marca"];
        $color = $datos["color"];
        $precio = $datos["precio"];
        $foto = $_FILES["foto"]["name"];

        //$extensionFoto = pathinfo($foto, PATHINFO_EXTENSION);
        $nuevoNombre = $patente . "." . $marca . ".modificado." . date("His") . ".jpg";
        $nuevoPath = "../PP2023/autosModificados/" . $nuevoNombre;
        $auto = new AutoBD($patente, $marca, $color, $precio, $nuevoNombre);

        if($auto->modificar() && move_uploaded_file($_FILES["foto"]["tmp_name"], $nuevoPath))
        {
            $retorno = array("exito" => true,
                            "mensaje" => "Auto modificado con éxito.");
        }
        else
        {
            $retorno = array("exito" => false,
                            "mensaje" => "Error al modificar el auto.");
        }

        echo json_encode($retorno);

    }
    else if($_SERVER["REQUEST_METHOD"] === "GET")
    {
        if(file_exists("./archivos/autosbd_modificados.txt")){
    
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
                $contenido = file_get_contents('./archivos/autosbd_modificados.txt');
                $lineas = explode("\n", $contenido);
                foreach ($lineas as $linea) {
                    // Dividir la línea en campos usando la coma como separador
                    $campos = explode(',', $linea);
                  
                    // Crear una fila de la tabla con los datos
                    echo '<tr>';
                    foreach ($campos as $campo) {
                      // Dividir el campo en clave y valor usando el dos puntos como separador
                      $datos = explode(':', $campo);
                     // if($datos[0]!=""){                
                        $clave = trim($datos[0]);
                        $valor = trim($datos[1]);
                        if($clave == "foto"){
                            $valor .= '</td><td><img src=../PP2023/autosModificados/'.urlencode($valor).' width="200" height="200"></td>';
                        }
                     // }          
                      // Mostrar el valor en la celda correspondiente
                      echo '<td>' . $valor . '</td>';
                    }
                    echo '</tr>';
                }
                $tabla .= "</table>";
            
                echo $tabla;
    }
    else
    {
        $retorno = array("exito" => false,
                        "mensaje" => "Error al modificar el auto.");

        echo json_encode($retorno);
    }
}
}