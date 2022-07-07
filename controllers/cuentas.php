<?php

    class cuentas Extends Controller {

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
        $this->view->title = "cuentas - Home";
            $this->view->cuentas = $this->model->get();
            $this->view->render('cuentas/main/index');
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

            # Creo cuenta en blanco inicializando los campos del formulario
            $this->view->cuenta = new Cuenta();
            # Si existe algún error
            if (isset($_SESSION['error'])) {
            
                # Mensaje de rror
                $this->view->error = $_SESSION['error'];
                unset($_SESSION['error']);

                # Variables de autorelleno formulario
                $this->view->cuenta = unserialize($_SESSION['cuenta']);
                unset($_SESSION['cuenta']);

                # Tipo de error
                $this->view->erroresVal = $_SESSION['erroresVal'];
                unset($_SESSION['erroresVal']);
            }
            # Actualizo el título de la página
            $this->view->title = "Añadir - cuenta - GesBank";
           
            
            $this->view->clientes = $this->model->getClientes();
            
            # Cargo la vista
            $this->view->render('cuentas/nuevo/index');
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
            $num_cuenta = filter_var($_POST['num_cuenta'] ??= '', FILTER_SANITIZE_NUMBER_INT);
            $id_cliente = (int) filter_var($_POST['id_cliente'] ??= '', FILTER_SANITIZE_NUMBER_INT);

            # Validación
            $erroresVal = [];

            // Aplicaremos las reglas de validación

            # Validad Num_Cuenta
            $patronNum_Cuenta = array("options"=>array("regexp"=>"/^(\d{20})$/"));
            if (empty($num_cuenta)){
                $erroresVal['num_cuenta'] = "Num_cuenta no puede estar vacío";
            } else if (!filter_var($num_cuenta, FILTER_VALIDATE_REGEXP, $patronNum_Cuenta)) {
                $erroresVal['num_cuenta'] = "Num_cuenta no válido";
            } else {        
                if (!$this->model->validarNum_Cuenta($num_cuenta)){
                    $erroresVal['num_cuenta'] = "Num_cuenta no válido, ya ha sido registrado";
                }
            }

            if (empty($id_cliente)){
                $erroresVal['id_cliente'] = "Id_cliente no puede estar vacío";
            } else {        
                if ($this->model->validarId_Cliente($id_cliente)){
                    $erroresVal['id_cliente'] = "Id_cliente no válido, ya ha sido registrado";
                }
            }

            # Cargamos los datos del formulario
            $cuenta = new cuenta(
                null,
                $num_cuenta,
                $id_cliente,
                null,
                null,
                null,
                null,
                null,
                null
            );
            if (!empty($erroresVal)) {

                # Formulario no valido
                $_SESSION['cuenta'] = Serialize($cuenta);
                $_SESSION['error'] = "Fallo en la validación del formulario";
                $_SESSION['erroresVal'] = $erroresVal;
                // var_dump($erroresVal);
                // exit;
                # Redireccionamos a nuevo (formulario cuenta nuevo)
                header('location:' .URL. 'cuentas/nuevo');
                
            } else {
                # Añadir registros en la tabla sin validación
            $this->model->create($cuenta);

                # Crear Mensaje
                $_SESSION['mensaje'] = "cuenta añadido correctamente";
                # Redireccionamos al main de cuentas
                header('location:' .URL. 'cuentas');

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

            $this->view->id = htmlspecialchars($param[0]);

            $this->view->title = "Editar cuenta - GesBank";

            $this->view->cuenta = $this->model->read($this->view->id);

            $this->view->clientes = $this->model->getClientes();

            if (isset($_SESSION['error'])) {
            
                # Mensaje de rror
                $this->view->error = $_SESSION['error'];
                unset($_SESSION['error']);

                # Variables de autorelleno formulario
                $this->view->cuenta = unserialize($_SESSION['cuenta']);
                unset($_SESSION['cuenta']);

                # Tipo de error
                $this->view->erroresVal = $_SESSION['erroresVal'];
                unset($_SESSION['erroresVal']);
            }
            $this->view->render('cuentas/editar/index');

            // var_dump($this->view->cliente);
            // exit();
        }
        

        public function update($param){

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

            # Iniciamos o continuamos la sesión
            

 # Saneamiento de los datos del formulario
 $num_cuenta = filter_var($_POST['num_cuenta'] ??= '', FILTER_SANITIZE_NUMBER_INT);
 $id_cliente = (int) filter_var($_POST['id_cliente'] ??= '', FILTER_SANITIZE_NUMBER_INT);
 


 # Validación
 $erroresVal = [];

 # Validad Num_Cuenta
$patronNum_Cuenta = array("options"=>array("regexp"=>"/^(\d{20})$/"));
if (strcmp($cuentasSinAct->num_cuenta, $num_cuenta)!== 0){
if (empty($num_cuenta)){
    $erroresVal['num_cuenta'] = "Num_cuenta no puede estar vacío";
} else if (!filter_var($num_cuenta, FILTER_VALIDATE_REGEXP, $patronNum_Cuenta)) {
    $erroresVal['num_cuenta'] = "Num_cuenta no válido";
} else {        
    if (!$this->model->validarNum_Cuenta($num_cuenta)){
        $erroresVal['num_cuenta'] = "Num_cuenta no válido, ya ha sido registrado";
    }
}
}

if (strcmp($cuentasSinAct->num_cuenta, $num_cuenta)!== 0){
 if (empty($id_cliente)){
     $erroresVal['id_cliente'] = "Id_cliente no puede estar vacío";
 } else {        
    if ($this->model->validarId_Cliente($id_cliente)){
        $erroresVal['id_cliente'] = "Id_cliente no válido, ya ha sido registrado";
    }
}
}

            $cuenta = new cuenta(
                null,
                $num_cuenta,
                $id_cliente,
                htmlspecialchars($_POST['fecha_alta']),
                htmlspecialchars($_POST['fecha_ul_mov']),
                htmlspecialchars($_POST['num_movtos']),
                htmlspecialchars($_POST['saldo']),
                null,
                null
            );

            if (!empty($erroresVal)) {

                # Formulario no valido
                $_SESSION['cuenta'] = Serialize($cuenta);
                $_SESSION['error'] = "Fallo en la validación del formulario";
                $_SESSION['erroresVal'] = $erroresVal;
                // var_dump($erroresVal);
                // exit;
                # Redireccionamos a nuevo (formulario cliente nuevo)
                header('location:' .URL. 'cuentas/editar/'.$id);
                
            } else {
                # Añadir registros en la tabla sin validación
                $cuenta = $this->model->update($cuenta, $id);

                # Crear Mensaje
                $_SESSION['mensaje'] = "cliente añadido correctamente";
                # Redireccionamos al main de clientes
                header('location:'. URL. 'cuentas');

            }
            
            ;

            
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
           
            $this->view->title = "Mostrar cuenta - GesBank";

            $this->view->cuenta = $this->model->read($this->view->id);

            //$this->view->clientes = $this->model->getClientes();
            $this->view->clientes = $this->model->getCliente($this->view->id);
            $this->view->render('cuentas/mostrar/index');

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

            header('location:'. URL. 'cuentas');
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

            $this -> view -> cuentas = $this -> model -> order($this -> view -> criterio); 

            $this -> view -> render('cuentas/main/index');
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

            $this -> view -> cuentas = $this->model->filter($this->view->Expresion);

            $this->view->render('cuentas/main/index');
        }
    }

    public function cuentasPdf(){

            $pdf=new pdfCuentas();
            // //Primera página
            $pdf->AddPage();
            
            //$pdf->Title();

            //$pdf->encabezado();

            $pdf->body($this->model->get());
            $pdf->AliasNbPages();
            $pdf->Output();

        
    }

    }

?>