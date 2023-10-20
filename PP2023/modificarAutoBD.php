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

        $auto = new AutoBD($patente, $marca, $color, $precio, "");

        $exito = $auto->modificar();
        $retorno = array("exito" => $exito,
                        "mensaje" => $exito ? "Auto modificado con éxito." : "Error al modificar el auto.");

        echo json_encode($retorno);

    }
    else
    {
        $retorno = array("exito" => false,
                        "mensaje" => "Error al modificar el auto.");

        echo json_encode($retorno);
    }
}