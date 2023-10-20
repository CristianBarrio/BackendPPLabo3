<?php

namespace Barrio\Cristian
{
    class Auto
    {
        protected string $patente;
        protected string $marca;
        protected string $color;
        protected float $precio;

        public function __construct($patente, $marca, $color, $precio)
        {
            $this->patente = $patente;
            $this->marca = $marca;
            $this->color = $color;
            $this->precio = $precio;
        }

        public function toJSON()
        {
            $datosAuto = array("patente" => $this->patente,
                                    "marca" => $this->marca,
                                    "color" => $this->color,
                                    "precio" => $this->precio);

            return json_encode($datosAuto);
        }

        public function Patente(){

            return $this->patente;
        }
    
        public function Marca(){
    
            return $this->marca;
        }
        public function Color(){
    
            return $this->color;
        }
        public function Precio(){
    
            return $this->precio;
        }
    
    public function guardarJSON($path)
    {
        $autosObtenidos = [];
        $retorno = [];
        if (file_exists($path)) {
            $autosObtenidos = json_decode(file_get_contents($path), true);
        }

        $autoNuevo = $this->toJSON(); 
        $autosObtenidos[] = json_decode($autoNuevo, true); 
        $autosJson = json_encode($autosObtenidos);

        if (file_put_contents($path, $autosJson)) 
        {
            $retorno = array(
                "exito" => true,
                "mensaje" => "Auto agregado con éxito."
            );
        } else 
        {
            $retorno = array(
                "exito" => false,
                "mensaje" => "Error al agregar el auto."
            );        
        }

        return json_encode($retorno);
    }

   
    public static function traerJSON($path)
    {
        $autosObtenidos = [];
        $retorno = array();
        if (file_exists($path))
        {
            $autosObtenidos = json_decode((file_get_contents($path)), true);
            foreach ($autosObtenidos as $autoData) 
            {
                $auto = new Auto($autoData["patente"], $autoData["marca"], $autoData["color"], $autoData["precio"]);
                $retorno[] = $auto;
            }
        }
        
        return $retorno;
    }

    public static function verificarAutoJSON($auto)
    {
        $path = "../PP2023/archivos/autos.json";
        $autos = Auto::traerJSON($path);
        $exito = false;
        foreach($autos as $autoAComparar)
        {
            if($auto->patente === $autoAComparar->patente)
            {
                $exito = true;
            }
        }
        $retorno = array(
            "exito" => $exito,
            "mensaje" => $exito ? "El auto se encuentra en el archivo." : "El auto no se encuentra en el archivo"
        );

        return $retorno;
    }

}

}