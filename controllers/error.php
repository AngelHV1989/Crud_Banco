<?php

    class Errores extends Controller {

        function __construct() {

            parent ::__construct();
            $this->view->mensaje = "URL no existente";
            $this->view->render('error/index');
        }

      

    }

?>