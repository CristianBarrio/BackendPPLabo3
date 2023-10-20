<?php
namespace Barrio\Cristian
{
    require_once "../PP2023/clases/autoBD.php";

    if(isset($_POST["obj_auto"]))
    {
        $datos = json_decode($_POST["obj_auto"], true);
        $patente = $datos["patente"];
    
        $auto = new AutoBD($patente, "", "", 1);
        $retorno = "{}";
        $autos = AutoBD::traer();

        if($auto->existe($autos))
        {
            $retorno = $auto->toJSON();
            /*foreach($autos as $autoComparar)
            {
                if($autoComparar->patente === $patente)
                {
                }
                break;
            }*/
        }
    
        echo $retorno;
    }
    else
    {
        echo json_encode("{}");
    }
}