<?php

    /*

    Declaramos la clase cliente a partir de las columnas de la tabla cuentas de la bd fp

    Se declaran públicas las propiedas sin mantener

    */

    class cuenta {
        public $id;
        public $num_cuenta;
        public $id_cliente;
        public $fecha_alta;
        public $fecha_ul_mov;
        public $num_movtos;
        public $saldo;

        public function __construct(
            $id = null,
            $num_cuenta = null,
            $id_cliente = null,
            $fecha_alta = null,
            $fecha_ul_mov = null,
            $num_movtos = null,
            $saldo = null
           
            
        )
        {
           $this->id = $id;
           $this->num_cuenta = $num_cuenta;
           $this->id_cliente = $id_cliente; 
           $this->fecha_alta = $fecha_alta; 
           $this->fecha_ul_mov = $fecha_ul_mov; 
           $this->num_movtos = $num_movtos;
           $this->saldo = $saldo;
        }
        
    }

?>