<?php
    class Auth Extends Controller {
        public function render(){

        }

        public function logout(){
            # iniciamos sesión
            sec_session_start();
            sec_session_destroy();

            header("location:" .URL. "login");
        }

        public function edit(){
            sec_session_start();

            $this->view->title = "Modificar perfil - Gesbank";

            if (isset($_SESSION['mensaje'])){

                $this->view->mensaje = $_SESSION['mensaje'];
                unset($_SESSION['mensaje']);
            }

            $this->view->user = $this->model->getUserId($_SESSION['id']);

            if (isset($_SESSION['error'])){
                $this->view->error = $_SESSION['error'];
                unset($_SESSION['error']);

                $this->view->user = unserialize($_SESSION['user']);
                unset($_SESSION['user']);

                $this->view->erroresVal = $_SESSION['erroresVal'];
                unset($_SESSION['erroresVal']);
            }
            $this->view->render('auth/edit/index');
        }
        public function validate(){
            sec_session_start(); 
            if (!isset($_SESSION['id'])){
                header("location:".URL."login");
            }
            $name = filter_var($_POST['name'] ??= '', FILTER_SANITIZE_STRING);
            $email = filter_var($_POST['email'] ??= '', FILTER_SANITIZE_EMAIL);

            $user = $this->model->getUserId($_SESSION['id']);

            $erroresVal = array();

            # Validar Nombre
            if(strcmp($user->name, $name) !== 0){
            if (empty($name)){
                $erroresVal['name'] = "Nombre de usuario no puede estar vacío";
            } else if ((strlen($name)< 5) || (strlen($name)> 50)) {
                $erroresVal['name'] = "Nombre de usuario no puede superar más de 20 caracteres";
            } else if (!$this->model->validarName($name)){
                $erroresVal['name'] = "Nombre de usuario no válido, ya ha sido registrado";
            }
        }
            # Validar Email
            if(strcmp($user->email, $email) !== 0){
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
        # Crear objeto user

        $user = new User(
            $user->id,
            $name,
            $email,
            null
        );
        
        if (!empty($erroresVal)) {

            # Formulario no valido
            $_SESSION['erroresVal'] = $erroresVal;
            $_SESSION['user'] = serialize($user);
            $_SESSION['error'] = "Fallo en la validación del formulario";
            
            # Redireccionamos a nuevo (formulario user nuevo)
            header('location:' .URL. 'auth/edit');
            
        } else {
            # Añadir registros en la tabla sin validación
            $this->model->update($user);

            $_SESSION['name_user'] = $user->name;

            # Crear Mensaje
            $_SESSION['mensaje'] = "Usuario Modificado correctamente";
            # Vuelve clientes
            header('location:' .URL. 'clientes');

        }
        }
        public function chpassword(){
            sec_session_start(); 

            if(!isset($_SESSION['id'])){
                header("location:".URL."login");
            }

            $this->view->title = "Cambiar password - Gesbank";

            if(isset($_SESSION['mensaje'])){

                $this->view->mensaje = $_SESSION['mensaje'];
                unset($_SESSION['mensaje']);
            }
            if (isset($_SESSION['error'])){
                $this->view->error = $_SESSION['error'];
                unset($_SESSION['error']);

                $this->view->erroresVal = $_SESSION['erroresVal'];
                unset($_SESSION['erroresVal']);
            }

            $this->view->render('auth/chpassword/index');
        }
        public function validatepassword(){
            sec_session_start(); 
            if (!isset($_SESSION['id'])){
                header("location:".URL."login");
            }
            $password_actual = filter_var($_POST['password_actual'] ??= null, FILTER_SANITIZE_STRING);
            $password = filter_var($_POST['password'] ??= null, FILTER_SANITIZE_STRING);
            $password_confirm = filter_var($_POST['password_confirm'] ??= null, FILTER_SANITIZE_STRING);

            $user = $this->model->getUserId($_SESSION['id']);

            $erroresVal = array();

            # Validar Password
            if(!password_verify($password_actual, $user->password)){
                    $erroresVal['password_actual'] = "Password actual no correcto";
            }

            if (empty($password)){
                $erroresVal['password'] = "Password de usuario no puede estar vacío";
            } else if (strcmp($password , $password_confirm) !== 0) {
                $erroresVal['password'] = "Password no coincidentes";
            } else if ((strlen($password)< 5) || (strlen($password)> 60)) {
                $erroresVal['password'] = "Password ha de tener entre 5 y 60 caracteres";
            }
            
            if (!empty($erroresVal)){
                $_SESSION['erroresVal'] = $erroresVal;
                $_SESSION['error'] = "Formulario con errores de validación";

                header("location:".URL. "auth/chpassword");
            } else{
        # Crear objeto user

        $user = new User(
            $user->id,
            null,
            null,
            $password
        );
        $this->model->update_password($user);
    
        $_SESSION['mensaje'] = "Password modificado correctamente";
        header("location:".URL."clientes");
    }
        }
        public function delete(){
            sec_session_start(); 

                if (!isset($_SESSION['id'])){
                    header("location:".URL."login");
                } 
             else{
                $user = $this->model->getUserId($_SESSION['id']);

            $this->view->title = "Eliminar Usuario - Maratoon";

            $this->model->delete($user);

            $_SESSION['mensaje'] = "Usuario eliminado correctamente";

            sec_session_destroy(); 

            header("location:".URL."login");
            
        }
        
        }
    }