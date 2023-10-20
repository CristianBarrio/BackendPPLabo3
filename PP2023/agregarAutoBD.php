<?php

namespace Barrio\Cristian
{
    require_once "../PP2023/clases/autoBD.php";

    if(isset($_POST["patente"], $_POST["marca"], $_POST["color"], $_POST["precio"], $_FILES["foto"]))
    {
        $patente = $_POST["patente"];
        $marca = $_POST["marca"];
        $color = $_POST["color"];
        $precio = $_POST["precio"];
        $foto = $_FILES["foto"]["tmp_name"];

        $pathFoto = "../PP2023/autos/imagenes/" . $patente . "." . date("His") . ".jpg";
        $auto = new AutoBD($patente, $marca, $color, $precio, $pathFoto);
        $exito = false;

        if($auto->existe(AutoBD::traer()))
        {
            $retorno = array("exito" => $exito,
            "mensaje" => "El auto ya se encuentra en la base de datos"); 
        }else
        {
            $exito = $auto->agregar();
            move_uploaded_file($foto, $pathFoto);
            $retorno = array("exito" => $exito,
            "mensaje" => $exito ? "Auto agregado con exito." : "Error al agregar el auto."); 
        }

        echo json_encode($retorno);
    }
    else
    {
        $retorno = array("exito" => false,
            "mensaje" => "Error");
            
        echo json_encode($retorno);
    }
}