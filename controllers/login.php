<?php

    class Login extends Controller{

        public function render(){
            sec_session_start();
            $this->view->title = "Login - Gesbank";
            //Inicializo valores del formulario
            $this->view->email = null;
            $this->view->password = null;

            //Control de los mensajes
            if(isset($_SESSION['mensaje'])){
                $this->view->mensaje = $_SESSION['mensaje'];
                unset($_SESSION['mensaje']);

                //Autorrelleno registrado con exito
                if(isset($_SESSION['email'])){
                    $this->view->email = $_SESSION['email'];
                    unset($_SESSION['email']);
                }

                //Autorrelleno registrado con exito
                if(isset($_SESSION['password'])){
                    $this->view->password = $_SESSION['password'];
                    unset($_SESSION['password']);
                }
            }

            if (isset($_SESSION['error'])){

                //Mensaje de error
                $this->view->error = $_SESSION['error'];
                unset($_SESSION['error']);
    
                //Variables de autorrelleno
                $this->view->email = $_SESSION['email'];
                $this->view->password = $_SESSION['password'];
                unset($_SESSION['email']);
                unset($_SESSION['password']);

                //Tipo de error
                $this->view->erroresVal = $_SESSION['erroresVal'];
                unset($_SESSION['erroresVal']);
            }

            $this->view->render('auth/login/index');

        }

        public function validate(){
            sec_session_start();

            $email = filter_var($_POST['email'] ??= null, FILTER_SANITIZE_EMAIL);
            $password = filter_var($_POST['password'] ??= null, FILTER_SANITIZE_STRING);

            $erroresVal = array();

            $user = $this->model->getUserEmail($email);

            if($user === false){
                $erroresVal['email'] = "Email no ha sido registrado";
                $_SESSION['erroresVal'] = $erroresVal;

                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;

                $_SESSION['error'] = "Fallo en la autentificación";

                header("location:".URL. "login");
            }else if(!password_verify($password,$user->password)){
                $erroresVal['password'] = "Password no es correcto";
                $_SESSION['erroresVal'] = $erroresVal;

                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;

                $_SESSION['error'] = "Fallo en la autentificación";

                header("location:".URL. "login");
                
            }else{
                $_SESSION['id'] = $user->id;
                $_SESSION['name_user'] = $user->name;
                $_SESSION['id_rol'] = $this->model->getUserIdPerfil($user->id);
                $_SESSION['name_rol'] = $this->model->getUserPerfil($_SESSION['id_rol']);

                $_SESSION['mensaje'] = "Usuario" . $user->name. " ha iniciado sesión";

                header("location:".URL. "clientes");
            }
        }
    }

?>