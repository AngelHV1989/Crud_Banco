<?php  

require_once 'class/cliente.php';
require_once 'class/cuenta.php';
require_once 'class/movimiento.php';
require_once 'class/contactar.php';
require_once 'class/user.php';
require_once 'fpdf184/fpdf.php';
require_once 'class/pdfClientes.php';
require_once 'class/pdfCuentas.php';
require_once 'class/pdfMovimientos.php';
require_once 'libs/database.php';
require_once 'libs/controller.php';
require_once 'libs/model.php';
require_once 'libs/view.php';
require_once 'libs/controlsessionseg.php';
require_once 'libs/privileges.php';
require_once 'libs/app.php';
require_once 'config/config.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
$app = new App();


?>