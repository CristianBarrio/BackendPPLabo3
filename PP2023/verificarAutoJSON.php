<?php
namespace Barrio\Cristian
{
    require_once "../PP2023/clases/auto.php";
    if(isset($_POST["patente"]))
    {
        $patente = $_POST["patente"];
        
        $auto = new Auto($patente, "", "", 0);
    
        echo json_encode(Auto::verificarAutoJSON($auto));
    }
    else
    {
        echo "Error al verificar el auto.";
    }
}