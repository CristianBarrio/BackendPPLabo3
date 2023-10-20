<?php
namespace Barrio\Cristian
{
    require_once "../PP2023/clases/autoBD.php";
    
    if(isset($_GET["tabla"]) && $_GET["tabla"] === "mostrar")
    {
        
        $retorno = "";
        
        $retorno = '<h1>Lista de autos</h1><br>';
        $retorno .= '<table border="1">
                        <tr>
                        <th>Patente</th>
                        <th>Marca</th>
                        <th>Color</th>
                        <th>Precio</th>
                        <th>Foto</th>
                        </tr>';
                        
        $autos = AutoBD::traer();
        
        foreach($autos as $auto)
        {
            $retorno .= '<tr>';
            $retorno .= '<td>' . $auto->patente . '</td>';
            $retorno .= '<td>' . $auto->marca . '</td>';
            $retorno .= '<td>' . $auto->color . '</td>';
            $retorno .= '<td>' . $auto->precio . '</td>';
            $retorno .= '<td><img src="' . $auto->foto .'." width="50px" height="50px"></td>';
            $retorno .= '</tr>';
        }
        
        $retorno .= '</table>';
        
        echo $retorno;
    }
    else
    {
        echo json_encode(Auto::traerJSON("../PP2023/archivos/autos.json"));
    }
}

?>