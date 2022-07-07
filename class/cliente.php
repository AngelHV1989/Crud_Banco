<?php

    /*

    Declaramos la clase cliente a partir de las columnas de la tabla clientes de la bd fp

    Se declaran públicas las propiedas sin mantener

    */

    class cliente {
        public $id;
        public $apellidos;
        public $nombre;
        public $telefono;
        public $ciudad;
        public $dni;
        public $email;

        public function __construct(
            $id = null,
            $apellidos = null,
            $nombre = null,
            $telefono = null,
            $ciudad = null,
            $dni = null,
            $email = null
           
            
        )
        {
           $this->id = $id;
           $this->apellidos = $apellidos;
           $this->nombre = $nombre; 
           $this->telefono = $telefono; 
           $this->ciudad = $ciudad; 
           $this->dni = $dni; 
           $this->email = $email;
        }
        
    }

?>