<?php
namespace Barrio\Cristian
{
    require_once "../PP2023/clases/auto.php";
    
    
    if(isset($_POST["patente"], $_POST["marca"], $_POST["color"], $_POST["precio"]))
    {
        $patente = $_POST["patente"];
        $marca = $_POST["marca"];
        $color = $_POST["color"];
        $precio = $_POST["precio"];
        
        $auto = new Auto($patente, $marca, $color, $precio);
    
        $path = "../PP2023/archivos/autos.json";
        echo $auto->guardarJSON($path);
    }
    else
    {
        echo "Error al guardar el auto.";
    }

}