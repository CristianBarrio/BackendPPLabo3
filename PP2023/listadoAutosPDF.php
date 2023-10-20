<?php
namespace Barrio\Cristian
{
    require_once "../PP2023/clases/autoBD.php";
    require_once "../vendor/autoload.php";
    use \Mpdf;
    
    header('content-type:application/pdf');

    $mpdf = new Mpdf\Mpdf([
        'orientation' => 'P',
        'pagenumPrefix' => 'Pagina nro. ',
        'pagenumSuffrix' => ' - ',
        'nbpgPrefix' => ' de ',
        'nbpgSuffix' => ' páginas'
    ]);

    $mpdf->SetHeader('Barrio Cristian||{PAGENO}{nbpg}');
    $mpdf->SetFooter('|{DATE j-m-Y}|');

    $arrayAutos = AutoBD::traer();
    $tabla = '<table class="table" border="1" align="center">
                <thead>
                    <tr>
                        <th> Patente   </th>
                        <th> Marca     </th>
                        <th> Color     </th>
                        <th> Precio    </th>
                        <th> Foto      </th>
                    </tr>
                </thead>';

    foreach ($arrayAutos as $auto) {
        $tabla .= "<tr>
                        <td>".$auto->patente."</td>
                        <td>".$auto->marca."</td>
                        <td>".$auto->color."</td>
                        <td>".$auto->precio."</td>
                        <td><img src='".$auto->pathFoto."' width='100px' height='100px'/></td>
                        </tr>";
    }

    $tabla .= '</table>';
    $mpdf->WriteHTML("<h3>Listado de autos</h3>");
    $mpdf->WriteHTML("<br>");
    $mpdf->WriteHTML($tabla);
    $mpdf->Output("mi_pdf.pdf", "I");
}