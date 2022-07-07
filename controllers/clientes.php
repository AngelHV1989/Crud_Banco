<?php

    class clientes Extends Controller {

        function __construct() {

            parent ::__construct();
            
            
        }

        function render() {
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
            $this->view->title = "clientes - Home";
            $this->view->clientes = $this->model->get();
            $this->view->render('clientes/main/index');
            
            
        }

        function nuevo(){
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

            # Creo cliente en blanco inicializando los campos del formulario
            $this->view->cliente = new Cliente();
            # Si existe algún error
            if (isset($_SESSION['error'])) {
            
                # Mensaje de rror
                $this->view->error = $_SESSION['error'];
                unset($_SESSION['error']);

                # Variables de autorelleno formulario
                $this->view->cliente = unserialize($_SESSION['cliente']);
                unset($_SESSION['cliente']);

                # Tipo de error
                $this->view->erroresVal = $_SESSION['erroresVal'];
                unset($_SESSION['erroresVal']);
            }
            # Actualizo el título de la página
            $this->view->title = "Añadir - cliente - GesBank";
            # Cargo el array de clubs para la vista
            
            # Cargo el array de categorias para la vista
            
            # Cargo la vista
            $this->view->render('clientes/nuevo/index');
        }

        function create(){
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
            $nombre = filter_var($_POST['nombre'] ??= '', FILTER_SANITIZE_STRING);
            $apellidos = filter_var($_POST['apellidos'] ??= '', FILTER_SANITIZE_STRING);
            $telefono = filter_var($_POST['telefono'] ??= '', FILTER_SANITIZE_STRING);
            $ciudad = filter_var($_POST['ciudad'] ??= '', FILTER_SANITIZE_STRING);
            $dni = filter_var($_POST['dni'] ??= '', FILTER_SANITIZE_STRING);
            $email = filter_var($_POST['email'] ??= '', FILTER_SANITIZE_EMAIL);
            


            # Validación
            $erroresVal = [];

            // Aplicaremos las reglas de validación
            if (empty($nombre)){
                $erroresVal['nombre'] = "Nombre no puede estar vacío";
            } else if (strlen($nombre)> 20) {
                $erroresVal['nombre'] = "No puede superar más de 20 caracteres";
            }

            if (empty($apellidos)){
                $erroresVal['apellidos'] = "Apellidos no puede estar vacío";
            } else if (strlen($apellidos)> 45) {
                $erroresVal['apellidos'] = "No puede superar más de 45 caracteres";
            }

            if (empty($ciudad)){
                $erroresVal['ciudad'] = "Ciudad no puede estar vacío";
            } else if (strlen($ciudad)> 20) {
                $erroresVal['ciudad'] = "No puede superar más de 20 caracteres";
            }

            # Validad Telefono
            $patronTelefono = array("options"=>array("regexp"=>"/^(\d{9})$/"));
            if (empty($telefono)){
                $erroresVal['telefono'] = "Telefono no puede estar vacío";
            } else if (!filter_var($telefono, FILTER_VALIDATE_REGEXP, $patronTelefono)) {
                $erroresVal['telefono'] = "Telefono no válido";
            } else {        
                if (!$this->model->validarTelefono($telefono)){
                    $erroresVal['telefono'] = "Telefono no válido, ya ha sido registrado";
                }
            }

            # Validad Dni
            $patronDni = array("options"=>array("regexp"=>"/^(\d{8})([A-Z])$/"));
            if (empty($dni)){
                $erroresVal['dni'] = "DNI no puede estar vacío";
            } else if (!filter_var($dni, FILTER_VALIDATE_REGEXP, $patronDni)) {
                $erroresVal['dni'] = "DNI no válido";
            } else {        
                if (!$this->model->validarDni($dni)){
                    $erroresVal['dni'] = "DNI no válido, ya ha sido registrado";
                }
            }

            if (empty($email)){
                $erroresVal['email'] = "Email no puede estar vacío";
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $erroresVal['email'] = "Email no válido";
            } else {        
                if (!$this->model->validarEmail($email)){
                    $erroresVal['email'] = "Email no válido, ya ha sido registrado";
                }
            }
            # Cargamos los datos del formulario
            $cliente = new cliente(
                null,
                $apellidos,
                $nombre,
                $telefono,
                $ciudad,
                $dni,
                $email,
                null,
                null
            );
            if (!empty($erroresVal)) {

                # Formulario no valido
                $_SESSION['cliente'] = Serialize($cliente);
                $_SESSION['error'] = "Fallo en la validación del formulario";
                $_SESSION['erroresVal'] = $erroresVal;
                // var_dump($erroresVal);
                // exit;
                # Redireccionamos a nuevo (formulario cliente nuevo)
                header('location:' .URL. 'clientes/nuevo');
                
            } else {
                # Añadir registros en la tabla sin validación
                $this->model->create($cliente);

                # Crear Mensaje
                $_SESSION['mensaje'] = "cliente añadido correctamente";
                # Redireccionamos al main de clientes
                header('location:' .URL. 'clientes');

            }
            
        }
        
        public function editar($param){
            sec_session_start();

            # Capa autentificación
            if(!isset($_SESSION['id'])){
                header("location:" .URL. "login");
            } else
            # Capa gestión de privilegios
            if (!in_array($_SESSION['id_rol'], $GLOBALS['editar'])) {
                $_SESSION['mensaje'] = "Operación sin privilegios";
                header("location:" . URL . "clientes");
            }

            # Creo cliente en blanco inicializando los campos del formulario
            //$this->view->cliente = new Cliente();
            

            $this->view->id = htmlspecialchars($param[0]);

            $this->view->title = "Editar cliente - GesBank";

            $this->view->cliente = $this->model->read($this->view->id);

            # Si existe algún error
            if (isset($_SESSION['error'])) {
            
                # Mensaje de rror
                $this->view->error = $_SESSION['error'];
                unset($_SESSION['error']);

                # Variables de autorelleno formulario
                $this->view->cliente = unserialize($_SESSION['cliente']);
                unset($_SESSION['cliente']);

                # Tipo de error
                $this->view->erroresVal = $_SESSION['erroresVal'];
                unset($_SESSION['erroresVal']);
            }

            $this->view->render('clientes/editar/index');

            // var_dump($this->view->cliente);
            // exit();
        }
        

        public function update($param){

            # Iniciamos o continuamos la sesión
            sec_session_start();

            # Capa autentificación
            if(!isset($_SESSION['id'])){
                header("location:" .URL. "login");
            } else
            # Capa gestión de privilegios
            if (!in_array($_SESSION['id_rol'], $GLOBALS['editar'])) {
                $_SESSION['mensaje'] = "Operación sin privilegios";
                header("location:" . URL . "clientes");
            }

            $id = htmlspecialchars($param[0]);

            $cuentasSinAct = $this->model->read($id);

            

 # Saneamiento de los datos del formulario
 $nombre = filter_var($_POST['nombre'] ??= '', FILTER_SANITIZE_STRING);
 $apellidos = filter_var($_POST['apellidos'] ??= '', FILTER_SANITIZE_STRING);
 $telefono = filter_var($_POST['telefono'] ??= '', FILTER_SANITIZE_STRING);
 $ciudad = filter_var($_POST['ciudad'] ??= '', FILTER_SANITIZE_STRING);
 $dni = filter_var($_POST['dni'] ??= '', FILTER_SANITIZE_STRING);
 $email = filter_var($_POST['email'] ??= '', FILTER_SANITIZE_EMAIL);
 


 # Validación
 $erroresVal = [];

 // Aplicaremos las reglas de validación
 if (strcmp($cuentasSinAct->nombre, $nombre)!== 0){
    if (empty($nombre)){
     $erroresVal['nombre'] = "Nombre no puede estar vacío";
 } else if (strlen($nombre)> 20) {
     $erroresVal['nombre'] = "No puede superar más de 20 caracteres";
 }
}

 if (strcmp($cuentasSinAct->apellidos, $apellidos)!== 0){
    if (empty($apellidos)){
     $erroresVal['apellidos'] = "Apellidos no puede estar vacío";
 } else if (strlen($apellidos)> 45) {
    $erroresVal['apellidos'] = "No puede superar más de 45 caracteres";
}
 }

 if (strcmp($cuentasSinAct->ciudad, $ciudad)!== 0){
    if (empty($ciudad)){
    $erroresVal['ciudad'] = "Ciudad no puede estar vacío";
} else if (strlen($ciudad)> 20) {
    $erroresVal['ciudad'] = "No puede superar más de 20 caracteres";
}
 }
# Validad Telefono
$patronTelefono = array("options"=>array("regexp"=>"/^(\d{9})$/"));
if (strcmp($cuentasSinAct->telefono, $telefono)!== 0){
    if (empty($telefono)){
    $erroresVal['telefono'] = "Telefono no puede estar vacío";
} else if (!filter_var($telefono, FILTER_VALIDATE_REGEXP, $patronTelefono)) {
    $erroresVal['telefono'] = "Telefono no válido";
} else {        
    if (!$this->model->validarTelefono($telefono)){
        $erroresVal['telefono'] = "Telefono no válido, ya ha sido registrado";
    }
}
}
# Validad Dni
$patronDni = array("options"=>array("regexp"=>"/^(\d{8})([A-Z])$/"));
if (strcmp($cuentasSinAct->dni, $dni)!== 0){
    if (empty($dni)){
    $erroresVal['dni'] = "DNI no puede estar vacío";
} else if (!filter_var($dni, FILTER_VALIDATE_REGEXP, $patronDni)) {
    $erroresVal['dni'] = "DNI no válido";
} else {        
    if (!$this->model->validarDni($dni)){
        $erroresVal['dni'] = "DNI no válido, ya ha sido registrado";
    }
}
}
 if (strcmp($cuentasSinAct->email, $email)!== 0){
    if (empty($email)){
     $erroresVal['email'] = "Email no puede estar vacío";
 } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
     $erroresVal['email'] = "Email no válido";
 } else {        
     if (!$this->model->validarEmail($email)){
         $erroresVal['email'] = "Email no válido, ya ha sido registrado";
     }
 }
}
            $cliente = new cliente(
                null,
                $apellidos,
                $nombre,
                $telefono,
                $ciudad,
                $dni,
                $email,
                null,
                null
            );
            if (!empty($erroresVal)) {

                # Formulario no valido
                $_SESSION['cliente'] = Serialize($cliente);
                $_SESSION['error'] = "Fallo en la validación del formulario";
                $_SESSION['erroresVal'] = $erroresVal;
                // var_dump($erroresVal);
                // exit;
                # Redireccionamos a nuevo (formulario cliente nuevo)
                header('location:' .URL. 'clientes/editar/'.$id);
                
            } else {
                # Añadir registros en la tabla sin validación
                $cliente = $this->model->update($cliente, $id);

                # Crear Mensaje
                $_SESSION['mensaje'] = "cliente añadido correctamente";
                # Redireccionamos al main de clientes
                header('location:'. URL. 'clientes');

            }
            
            

            
        }

        public function mostrar($param){

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
            
            $this->view->id = htmlspecialchars($param[0]);

            $this->view->title = "Editar cliente - GesBank";

            $this->view->cliente = $this->model->read($this->view->id);

            $this->view->render('clientes/mostrar/index');

            // var_dump($this->view->cliente);
            // exit();
        }

        public function eliminar($param){

            sec_session_start();

            # Capa autentificación
            if(!isset($_SESSION['id'])){
                header("location:" .URL. "login");
            } else
            # Capa gestión de privilegios
            if (!in_array($_SESSION['id_rol'], $GLOBALS['eliminar'])) {
                $_SESSION['mensaje'] = "Operación sin privilegios";
                header("location:" . URL . "clientes");
            } else{
            $this->view->id = htmlspecialchars($param[0]);

            $this->view->title = "Eliminar cliente - GesBank";

            $this->view->cliente = $this->model->read($this->view->id);

            $this->view->cliente = $this->model->delete($this->view->id);

            header('location:'. URL. 'clientes');
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

            $this -> view -> clientes = $this -> model -> order($this -> view -> criterio); 

            $this -> view -> render('clientes/main/index');

            }
        }

        public function buscar() {

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

            $this -> view -> Expresion = htmlspecialchars($_GET['Expresion']);

            $this -> view -> clientes = $this->model->filter($this->view->Expresion);

            $this->view->render('clientes/main/index');
            }
        }
        
        public function clientesPdf(){

            $pdf=new pdfClientes();
            // //Primera página
            $pdf->AddPage();
            
            //$pdf->Title();

            $pdf->body($this->model->get());
            $pdf->AliasNbPages();
            $pdf->Output();

        }

    }

?>