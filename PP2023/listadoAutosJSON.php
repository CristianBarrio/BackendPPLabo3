<?php
namespace Barrio\Cristian
{
    require_once "../PP2023/clases/auto.php";
    $path = "../PP2023/archivos/autos.json";
    $autos = Auto::traerJSON($path);

    foreach($autos as $auto) 
    {
        $autos_data = array(
            "patente" => $auto->Patente(),
            "marca" => $auto->Marca(),
            "color" => $auto->Color(),
            "precio" => $auto->Precio(),
        );
        $retorno[] = $autos_data;
    }
    echo(json_encode($retorno));
   
}