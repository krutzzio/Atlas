<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Obtener los datos del formulario
  $opcion = $_POST["opcion"];
  $titular = $_POST["titular"];
  $cups = $_POST["cups"];
  $direccion = $_POST["direccion"];
  $nombre = $_POST["nombre"];
  $email = $_POST["email"];
  $telefono = $_POST["telefono"];

  // Construir el cuerpo del correo electrónico
  $mensaje = "Datos del formulario:\n";
  $mensaje .= "Opción seleccionada: " . $opcion . "\n";
  $mensaje .= "Titular del Suministro: " . $titular . "\n";
  $mensaje .= "Nº CUPS: " . $cups . "\n";
  $mensaje .= "Dirección del Suministro: " . $direccion . "\n";
  $mensaje .= "Nombre: " . $nombre . "\n";
  $mensaje .= "Email: " . $email . "\n";
  $mensaje .= "Teléfono: " . $telefono . "\n";

  // Crear una instancia de PHPMailer
  $mail = new PHPMailer(true);

  try {
    // Configurar el servidor SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.example.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'tu_correo@example.com';
    $mail->Password   = 'tu_contraseña';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Configurar el remitente y destinatario
    $mail->setFrom($email);
    $mail->addAddress('vsus@bigbangtech.io');

    // Configurar el asunto y cuerpo del correo electrónico
    $mail->Subject = 'Nuevo formulario enviado';
    $mail->Body    = $mensaje;

    // Verificar si se enviaron archivos y adjuntarlos al correo electrónico
    if (isset($_FILES["file"])) {
      $mail->addAttachment($_FILES["file"]["tmp_name"], $_FILES["file"]["name"]);
    }
    if (isset($_FILES["extraFile"])) {
      $mail->addAttachment($_FILES["extraFile"]["tmp_name"], $_FILES["extraFile"]["name"]);
    }

    // Enviar el correo electrónico
    $mail->send();
    echo "<div style='display:flex;align-items:center;justify-content:center;gap:10px;'><svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' style='width:44px;color:lightgreen;'><path stroke-linecap='round' stroke-linejoin='round' d='M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z' /></svg><h2><b>Datos enviados correctamente</b></h2></div><h2>Nuestro departamento comercial se pone a trabajar inmediatamente. Si se requieren más datos se pondrán en contacto contigo, con el fin de ofrecerte la mejor oferta ajustada a tus necesidades.</h2><h2>Gracias por confiar en ATLAS Energia.</h2>";
  } catch (Exception $e) {
    echo "<div style='display:flex;align-items:center;justify-content:center;gap:10px;'><svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' style='width:44px;color:red;'><path stroke-linecap='round' stroke-linejoin='round' d='m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z' /></svg><h2><b>Error en el envío</b></h2></div><h2>Parece que ha habido un error en el envio de los datos, puede volver a intentarlo pasado unos minutos.</h2><h2>Disculpe las molestias.</h2>";
  }
}
?>