<?php

    /*

    Declaramos la clase cliente a partir de las columnas de la tabla clientes de la bd fp

    Se declaran públicas las propiedas sin mantener

    */

    class contactarClass {
        public $nombre;
        public $asunto;
        public $mensaje;
        public $email;

        public function __construct(
            $nombre = null,
            $asunto = null,
            $mensaje = null,
            $email = null,  
        )
        {
            $this->nombre = $nombre;
           $this->asunto = $asunto;
           $this->mensaje = $mensaje; 
           $this->email = $email; 
          
        }
        
    }

?>