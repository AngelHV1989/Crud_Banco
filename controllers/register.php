<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

    class Register Extends Controller{
        public function render(){
            sec_session_start();
            $this->view->title = "Registrar Nuevo Usuario - Gesbank";
            if (isset($_SESSION['mensaje'])){
                $this->view->mensaje = $_SESSION['mensaje'];
                unset($_SESSION['mensaje']);
            }

            $this->view->user = new user();

            if (isset($_SESSION['error'])){
                # Mensaje de error
                $this->view->error = $_SESSION['error'];
                unset($_SESSION['error']);
                # Variables de autorelleno
                $this->view->user= unserialize($_SESSION['user']);
                unset($_SESSION['user']);
                # Tipos de error
                $this->view->erroresVal = $_SESSION['erroresVal'];
                unset($_SESSION['erroresVal']);
            }

            $this->view->render('auth/register/index');
        }
        public function validate(){
            sec_session_start();

            $name = filter_var($_POST['name'] ??= '', FILTER_SANITIZE_STRING);
            $email = filter_var($_POST['email'] ??= '', FILTER_SANITIZE_EMAIL);
            $password = filter_var($_POST['password'] ??= '', FILTER_SANITIZE_STRING);
            $password_confirm = filter_var($_POST['password_confirm'] ??= null, FILTER_SANITIZE_STRING);

            $erroresVal = array();

            # Validar Nombre
            if (empty($name)){
                $erroresVal['name'] = "Nombre de usuario no puede estar vacío";
            } else if ((strlen($name)< 5) || (strlen($name)> 50)) {
                $erroresVal['name'] = "Nombre de usuario no puede superar más de 20 caracteres";
            } else if (!$this->model->validarName($name)){
                $erroresVal['name'] = "Nombre de usuario no válido, ya ha sido registrado";
            }

            # Validar Email
            if (empty($email)){
                $erroresVal['email'] = "Email no puede estar vacío";
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $erroresVal['email'] = "Email no válido";
            } else {        
                if (!$this->model->validarEmail($email)){
                    $erroresVal['email'] = "Email no válido, ya ha sido registrado";
                }
            }

            # Validar Password
            if (empty($password)){
                $erroresVal['password'] = "Password de usuario no puede estar vacío";
            } else if (strcmp($password , $password_confirm) !== 0) {
                $erroresVal['password'] = "Password no coincidentes";
            } else if ((strlen($password)< 5) || (strlen($password)> 60)) {
                $erroresVal['password'] = "Password ha de tener entre 5 y 60 caracteres";
            }

            # Crear objeto user

            $user = new User(
                null,
                $name,
                $email,
                $password
            );

            if (!empty($erroresVal)) {

                # Formulario no valido
                $_SESSION['erroresVal'] = $erroresVal;
                $_SESSION['user'] = serialize($user);
                $_SESSION['error'] = "Fallo en la validación del formulario";
                
                # Redireccionamos a nuevo (formulario user nuevo)
                header('location:' .URL. 'register');
                
            } else {
                try {
                    // Crear instancia; pasando `true` para habilitar excepciones
                    $mail = new PHPMailer(true);
                    // Codificación
                    $mail->CharSet = 'UTF-8';
                    $mail->Encoding = 'quoted-printable';

                    // Le decimos al script que utilizaremos SMTP
                    $mail->isSMTP();
                    // Activaremos la autentificación SMTP el cual se utiliza en la mayoría de casos
                    $mail->SMTPAuth = true;
                    // Especificamos la seguridad de la conexion, puede ser SSL, TLS o lo dejamos en blanco si no sabemos
                    $mail->SMTPSecure = 'ssl';
                    // Especificamos el host del servidor SMTP
                    $mail->Host = 'smtp.gmail.com';
                    // Especficiamos el puerto del servidor SMTP
                    $mail->Port = 465;
                    // El usuario del servidor SMTP
                    $mail->Username = "angelpruebaphp@gmail.com";
                    // Contraseña del usuario
                    $mail->Password = "hvimpznhitvsgrvq";

                    $mail->setFrom('angelpruebaphp@gmail.com', 'Admin');
                    $mail->AddReplyTo('angelpruebaphp@gmail.com', 'Email respuesta');
                    $mail->addAddress($_POST['email'], 'Yo Mismo');
                    $mail->Subject = 'Bienvenido';
                    $mail->Body = 'Bienvenido a nuestra red ' . $_POST['name']. ', su email de registro
                    es: '. $_POST['email'] . ' correspondiente al nombre de usuario '. $_POST['name'] . 
                    ' y su contarseña: ' . $_POST['password']. '. Reciba un cordial saludo.';
                    // Usar HTML
                    $mail->isHTML(true);
                    // Enviar
                    $mail->send();


                    
                } catch (Exception $e) {
                    echo "Mensaje no enviado. Error: {$mail->ErrorInfo}";
                }
                # Añadir registros en la tabla sin validación
                $this->model->registrar($user);

                # Crear Mensaje
                $_SESSION['mensaje'] = "Usuario añadido correctamente";
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                # Redireccionamos al main de user
                header('location:' .URL. 'login');

            }

        }
        
            
            
    }