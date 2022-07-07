<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    class contactar Extends Controller {

        function __construct() {

            parent ::__construct();
            
            
        }
    
        function render(){
            sec_session_start();

            # Comprobamos si existe algún mensaje
            if (isset($_SESSION['mensaje'])) {
                $this->view->mensaje = $_SESSION['mensaje'];
                unset($_SESSION['mensaje']);
            }

            # Creo cliente en blanco inicializando los campos del formulario
            $this->view->contactar = new contactarClass();

            if (isset($_SESSION['error'])) {
            
                # Mensaje de rror
                $this->view->error = $_SESSION['error'];
                unset($_SESSION['error']);

                # Variables de autorelleno formulario
                $this->view->contactar = unserialize($_SESSION['contactar']);
                unset($_SESSION['contactar']);

                # Tipo de error
                $this->view->erroresVal = $_SESSION['erroresVal'];
                unset($_SESSION['erroresVal']);
            }
            // print_r($this->view->nombre);
            // exit;
           $this->view->render('contactar/main/index');
            
        }
    
        function validar(){

            sec_session_start();

            # Saneamiento de los datos del formulario
            $nombre = filter_var($_POST['nombre'] ??= '', FILTER_SANITIZE_STRING);
            $asunto = filter_var($_POST['asunto'] ??= '', FILTER_SANITIZE_STRING);
            $mensaje = filter_var($_POST['mensaje'] ??= '', FILTER_SANITIZE_STRING);
            $email = filter_var($_POST['email'] ??= '', FILTER_SANITIZE_EMAIL);

            # Validación
            $erroresVal = [];

            // Aplicaremos las reglas de validación
            if (empty($nombre)){
                $erroresVal['nombre'] = "Nombre no puede estar vacío";     
            }
            if (empty($asunto)){
                $erroresVal['asunto'] = "Asunto no puede estar vacío";     
            }
            if (empty($mensaje)){
                $erroresVal['mensaje'] = "Mensaje no puede estar vacío";     
            }
            if (empty($email)){
                $erroresVal['email'] = "Email no puede estar vacío";     
            }

            $contactar = new contactarClass(
                $nombre,
                $asunto,
                $mensaje,
                $email
            );

            if (!empty($erroresVal)) {

                # Formulario no valido
                $_SESSION['contactar'] = Serialize($contactar);
                $_SESSION['error'] = "Fallo en la validación del formulario";
                $_SESSION['erroresVal'] = $erroresVal;
                // var_dump($erroresVal);
                // exit;
                # Redireccionamos a nuevo (formulario cliente nuevo)
                header('location:' .URL. 'contactar');
                
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

                    $mail->setFrom($_POST['email'], $_POST['nombre']);
                    $mail->AddReplyTo($_POST['email'], 'Email respuesta');
                    $mail->addAddress('angelpruebaphp@gmail.com', 'Yo Mismo');
                    $mail->Subject = $_POST['asunto'];
                    $mail->Body = $_POST['mensaje'];
                    // Usar HTML
                    $mail->isHTML(true);
                    // Enviar
                    $mail->send();
                } catch (Exception $e) {
                    $_SESSION['error'];
                }
                $_SESSION['mensaje'] = "Email enviado correctamente";
                header('location:'. URL . 'contactar');
            }
            
        }
    }
    
?>