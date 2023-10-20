<?php
namespace Barrio\Cristian
{
    require_once "../PP2023/clases/auto.php";
    require_once "../PP2023/clases/IParte1.php";
    require_once "../PP2023/clases/IParte2.php";
    require_once "../PP2023/clases/IParte3.php";
    use \PDO;
    use \PDOException;

    class AutoBD extends Auto implements IParte1, IParte2, IParte3
    {
        protected string $pathFoto;

        public function __construct($patente, $marca, $color, $precio, $pathFoto = "")
        {
            parent::__construct($patente, $marca, $color, $precio);
            $this->pathFoto = $pathFoto;
        }

        public function toJSON()
        {
            $datosAuto = array("patente" => $this->patente,
                                    "marca" => $this->marca,
                                    "color" => $this->color,
                                    "precio" => $this->precio,
                                    "pathFoto" => $this->pathFoto);

            return json_encode($datosAuto);
        }

        public function PathFoto(){

            return $this->pathFoto;
            
        }

        public function agregar()
        {
            $retorno = false;

            try
            {
                $pdo = new PDO("mysql:host=localhost;dbname=garage_bd", "root", "");
                
                $sql = $pdo->prepare("INSERT INTO `autos`(`patente`, `marca`, `color`, `precio`, `foto`) VALUES (:patente, :marca, :color, :precio, :foto)");
                $sql->bindParam(":patente", $this->patente, PDO::PARAM_STR, 10);
                $sql->bindParam(":marca", $this->marca, PDO::PARAM_STR, 20);
                $sql->bindParam(":color", $this->color, PDO::PARAM_STR, 20);
                $sql->bindParam(":precio", $this->precio, PDO::PARAM_INT);
                $sql->bindParam(":foto", $this->pathFoto, PDO::PARAM_STR, 100);

                if($sql->execute())
                {
                    $retorno = true;
                }
            }
            catch(PDOException)
            {
                $retorno = false;
            }

        return $retorno;
        }

        public static function traer()
        {
            try
            {
                $pdo = new PDO("mysql:host=localhost;dbname=garage_bd", "root", "");
                
                $sql = $pdo->prepare("SELECT * FROM `autos`");
                $autos = array();

                if($sql->execute())
                {
                    while($res = $sql->fetchObject())
                    {
                        $autos[] = $res;
                    }

                    return $autos;               
                }
            }
            catch(PDOException)
            {
                return $autos;
            }

            return $autos;
        }

        public function modificar()
        {
            $retorno = false;
            try
            {
                $pdo = new PDO("mysql:host=localhost;dbname=garage_bd", "root", "");
                
                $sql = $pdo->prepare("UPDATE `autos` SET marca = :marca, color = :color, precio = :precio, foto = :foto WHERE patente = :patente");
                $sql->bindParam(":patente", $this->patente, PDO::PARAM_STR, 10);
                $sql->bindParam(":marca", $this->marca, PDO::PARAM_STR, 20);
                $sql->bindParam(":color", $this->color, PDO::PARAM_STR, 20);
                $sql->bindParam(":precio", $this->precio, PDO::PARAM_INT);
                $sql->bindParam(":foto", $this->pathFoto, PDO::PARAM_STR, 100);
    
                if($sql->execute())
                {
                    $retorno = true;
                    return $retorno;
                }
                else
                {
                    return $retorno;
                }
            }
            catch(PDOException)
            {
                return $retorno;
            }
        }
    
    
        public static function eliminar($patente)
        {
            $retorno = false;
            try
            {
                $pdo = new PDO("mysql:host=localhost;dbname=garage_bd", "root", "");
                
                $sql = $pdo->prepare("DELETE FROM `autos` WHERE patente = :patente");
                $sql->bindParam(":patente", $patente, PDO::PARAM_STR, 10);
    
                if($sql->execute())
                {
                    $retorno = true;
                    return $retorno;
                }
                else
                {
                    return $retorno;
                }
            }
            catch(PDOException)
            {
                return $retorno;
            }
        }

        public function existe($autos)
        {
            $retorno = false;
        
            foreach($autos as $auto)
            {
                if($auto->patente === $this->patente)
                {
                    $retorno = true;
                }
            }

            return $retorno;
        }

        public function guardarEnArchivo()
        {
            $path = "../PP2023/archivos/autosbd_borrados.txt";
            $retorno = false;
            if(file_exists($path))
            {
                $nuevoPath = "../PP2023/autosBorrados/" . $this->patente . "." . $this->marca . ".borrado." . date("His") . ".jpg";
                
                if(file_put_contents($path, $this->toJSON(), FILE_APPEND) && move_uploaded_file($this->pathFoto, $nuevoPath))
                {
                    $retorno = true;
                } 
            }

            return $retorno;
        }


    }
}
