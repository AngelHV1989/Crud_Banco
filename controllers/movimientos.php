<?php

    class movimientos Extends Controller {

        function __construct() {

            parent ::__construct();
            
            
        }

        function render($param) {
            sec_session_start();

            # Capa autentificación
            if(!isset($_SESSION['id'])){
                header("location:" .URL. "login");
            } else
            # Capa gestión de privilegios
            if (!in_array($_SESSION['id_rol'], $GLOBALS['consultar'])) {
                $_SESSION['mensaje'] = "Operación sin privilegios";
                header("location:" . URL . "clientes");
            }

            # Comprobamos si existe algún mensaje
            if (isset($_SESSION['mensaje'])) {
                $this->view->mensaje = $_SESSION['mensaje'];
                unset($_SESSION['mensaje']);
            
        }
            $this->view->title = "movimientos - Home";
            $this->view->id = htmlspecialchars($param[0]);
            $this->view->movimientos = $this->model->get($this->view->id);
            $this->view->render('movimientos/main/index');
            
            
            
        }

        function nuevo($param){
            sec_session_start();

            # Capa autentificación
            if(!isset($_SESSION['id'])){
                header("location:" .URL. "login");
            } else
            # Capa gestión de privilegios
            if (!in_array($_SESSION['id_rol'], $GLOBALS['crear'])) {
                $_SESSION['mensaje'] = "Operación sin privilegios";
                header("location:" . URL . "clientes");
            }

            # Creo movimiento en blanco inicializando los campos del formulario
            $this->view->movimiento = new movimiento();
            # Si existe algún error
            if (isset($_SESSION['error'])) {
            
                # Mensaje de rror
                $this->view->error = $_SESSION['error'];
                unset($_SESSION['error']);

                # Variables de autorelleno formulario
                $this->view->movimiento = unserialize($_SESSION['movimiento']);
                unset($_SESSION['movimiento']);

                # Tipo de error
                $this->view->erroresVal = $_SESSION['erroresVal'];
                unset($_SESSION['erroresVal']);
            }
            # Actualizo el título de la página
            $this->view->title = "Añadir - movimiento - GesBank";
            $this->view->id = htmlspecialchars($param[0]);
            $this->view->movimientos = $this->model->get($this->view->id);
            //$this->view->clientes = $this->model->getClientes();
            
            # Cargo la vista
            $this->view->render('movimientos/nuevo/index');
        }

        function create($param){
            # Iniciamos o continuamos la sesión
 sec_session_start();

 # Capa autentificación
 if(!isset($_SESSION['id'])){
    header("location:" .URL. "login");
} else
# Capa gestión de privilegios
if (!in_array($_SESSION['id_rol'], $GLOBALS['crear'])) {
    $_SESSION['mensaje'] = "Operación sin privilegios";
    header("location:" . URL . "clientes");
}

 # Saneamiento de los datos del formulario
 $concepto = filter_var($_POST['concepto'] ??= '', FILTER_SANITIZE_STRING);
 $tipo = filter_var($_POST['tipo'] ??= '', FILTER_SANITIZE_STRING);
 $cantidad = filter_var($_POST['cantidad'] ??= '', FILTER_SANITIZE_NUMBER_FLOAT);
 


 # Validación
 $erroresVal = [];

 // Aplicaremos las reglas de validación
 if (empty($concepto)){
     $erroresVal['concepto'] = "Concepto no puede estar vacío";
 } else if (strlen($concepto)> 50) {
     $erroresVal['concepto'] = "No puede superar más de 20 caracteres";
 }

 if (!in_array($tipo, ['I', 'R'])){
    $erroresVal['tipo'] = "Seleccione un tipo válido";
}

 if (empty($cantidad)){
     $erroresVal['cantidad'] = "Cantidad no puede estar vacío";
 } 

            # Cargamos los datos del formulario
            $movimiento = new movimiento(
                null,
                htmlspecialchars($_POST['id_cuenta']),
                null,
                $concepto,
                $tipo,
                $cantidad,
                null,
                null,
                null
            );
            if (!empty($erroresVal)) {

                # Formulario no valido
                $_SESSION['movimiento'] = Serialize($movimiento);
                $_SESSION['error'] = "Fallo en la validación del formulario";
                $_SESSION['erroresVal'] = $erroresVal;
                // var_dump($erroresVal);
                // exit;
                # Redireccionamos a nuevo (formulario movimiento nuevo)
                header('location:' .URL. 'movimientos/nuevo/'.$param[0]);
                
            } else {
                # Añadir registros en la tabla sin validación
            $this->model->create($movimiento);

                # Crear Mensaje
                $_SESSION['mensaje'] = "movimiento añadido correctamente";
                # Redireccionamos al main de movimientos
                $this->view->id = htmlspecialchars($param[0]);
            $this->view->movimientos = $this->model->get($this->view->id);
            $this->view->render('movimientos/main/index');

            }
            
        }

        public function ordenar($param) {
            
            sec_session_start();

            # Capa autentificación
            if(!isset($_SESSION['id'])){
                header("location:" .URL. "login");
            } else
            # Capa gestión de privilegios
            if (!in_array($_SESSION['id_rol'], $GLOBALS['consultar'])) {
                $_SESSION['mensaje'] = "Operación sin privilegios";
                header("location:" . URL . "clientes");
            } else{

            $this -> view -> criterio = (int)$param[0];
            
            $this->view->id = htmlspecialchars($param[1]);
            $this -> view -> movimientos = $this -> model -> order($this -> view -> criterio, $this->view->id); 

            $this -> view -> render('movimientos/main/index');

            }
        }

        public function buscar($param) {

            sec_session_start();

            # Capa autentificación
            if(!isset($_SESSION['id'])){
                header("location:" .URL. "login");
            } else
            # Capa gestión de privilegios
            if (!in_array($_SESSION['id_rol'], $GLOBALS['consultar'])) {
                $_SESSION['mensaje'] = "Operación sin privilegios";
                header("location:" . URL . "clientes");
            } else{

            $this -> view -> title = 'Buscar - GesBank';
            $this->view->id = htmlspecialchars($param[0]);
            $this -> view -> Expresion = htmlspecialchars($_GET['Expresion']);

            $this -> view -> movimientos = $this->model->filter($this->view->Expresion, $this->view->id);

            $this->view->render('movimientos/main/index');
            }
        }
        public function movimientosPdf($param){
            $this->view->id = htmlspecialchars($param[0]);
            $pdf=new pdfMovimientos();
            // //Primera página
            $pdf->AddPage();
            
            //$pdf->Title();

            //$pdf->encabezado();

            $pdf->body($this->model->get($this->view->id));
            $pdf->AliasNbPages();
            $pdf->Output();
        }

    }

?>