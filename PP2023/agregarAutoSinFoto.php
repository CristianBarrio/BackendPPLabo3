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

    $exito = $auto->Agregar();

    $retorno = array("exito" => $exito,
    "mensaje" => $exito ? "Auto agregado con éxito." : "Error al agregar el auto.");

    echo json_encode($retorno);
}
else
{
    $retorno = array("exito" => false,
    "mensaje" => "Error al agregar el auto.");
    echo json_encode($retorno);
}
}