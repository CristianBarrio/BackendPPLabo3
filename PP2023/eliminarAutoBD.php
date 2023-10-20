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
    
        $auto = new Auto($patente, $marca, $color, $precio);
        $retorno = AutoBD::Eliminar($patente);
    
        if($retorno)
        {
            $auto->guardarJSON("../PP2023/archivos/autos_eliminados.json");
            $retorno = array(
                "exito" => true,
                "mensaje" => "Auto eliminado con éxito."
            );
        }
        else
        {
            $retorno = array(
                "exito" => false,
                "mensaje" => "Error al eliminar el auto."
            );
        }
    
        echo json_encode($retorno);
    }
    else
    {
        $retorno = array(
            "exito" => false,
            "mensaje" => "Error al eliminar el auto."
        );
    
        echo json_encode($retorno);
    }
}