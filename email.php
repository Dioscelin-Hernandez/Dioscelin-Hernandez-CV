<?php
require 'recursos/phpmailer/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


$subject="Contacto";

if($_POST) {

    $name = trim(stripslashes($_POST['contactName']));
    $email = trim(stripslashes($_POST['contactEmail']));
    $tel = trim(stripslashes($_POST['contactTel']));
    $contact_message = trim(stripslashes($_POST['contactMessage']));

    // Check Name
    if (strlen($name) < 2) {
        $error['name'] = "Por favor Escribe tu nombre.";
    }
    if (strlen($tel) < 2) {
        $error['tel'] = "Por favor Escribe tu Teléfono.";
    }
    // Check Email
    if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
        $error['email'] = "Por favor escribe un correo válido.";
    }
    // Check Message
    if (strlen($contact_message) < 5) {
        $error['message'] = "Por favor escribe tu mensaje de al menos 10 caracteres.";
    }
    // Subject
    if ($subject == '') { $subject = "Contacto"; }


    if (!@$error) {


        //ini_set("sendmail_from", $siteOwnersEmail); 
        //$mail = mail($siteOwnersEmail, $subject, $message, $headers);
        
        $body   =   "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//ES' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
  <meta http-equiv='X-UA-Compatible' content='IE=edge' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Amara CoiinSoft</title>
    
</head>
    <body style='background-color: #F9FAFC;' >
        <center class='wrapper'>
            <div class='webkit' >

                <table width='600px' align='center' cellspacing='15px' style='font-family: sans-serif; background-color: #FFF; padding: 20px; border-radius: 6px;'>
                    <tr>
                        <td colspan='2' align='center'>
                            <img src='images\dh.png' width='30%' alt='Dioscelin Hernández CV   ' />
                        </td>
                    </tr>
                   
                    <tr >
                        <td colspan='2'>
                            <p style='font-size:16px; color:#666666;'>Hola <b>".($name)."</b>, Gracias por ponerte en contacto con nosotros,</p>
                            <p style='font-size:16px; color:#666666;'>En breve me contactare contigo en base a tus datos:
                                </p>

                                <p style='font-size:16px; color:#666666;'>
                                Nombre ".$name."<br>
                                EMail ".$email."<br>
                                Teléfono ".$tel."<hr>
                                Mensaje ".$contact_message."
                                
                                
                                </p>
                                
                        </td>
                    </tr>
                    
                    
                </table>
            </div>
        </center>
        
    </body>

</html>";

//echo $body;

$mail = new PHPMailer(true);

try {

    $mail->isSMTP();                                            
    $mail->Host       = "mail.dmmarketing.com.mx";                     
    $mail->SMTPAuth   = true;                                   
    $mail->Username   = "hernandezdioscelin18@gmail.com";
    $mail->Password   = "dioscelin2404";
    $mail->setFrom('hernandezdioscelin18@gmail.com', 'Dioscelin Hernández CV');
    $mail->addAddress($email,$name );
    $mail->addBCC('marketingdmpublicidad@gmail.com'); 

    $mail->isHTML(true);
    $mail->Subject = 'Contacto desde Dioscelin Hernánndez CV';
    $mail->Body    = $body;
    $mail->AltBody = 'Contacto';

    $mail->send();
    //echo 'Message has been sent';
} catch (Exception $e) {
    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}



        
    }else {

        $response = (isset($error['name'])) ? $error['name'] . "<br /> \n" : null;
        $response .= (isset($error['email'])) ? $error['email'] . "<br /> \n" : null;
        $response .= (isset($error['message'])) ? $error['message'] . "<br />" : null;
        
        echo $response;

    } # end if - there was a validation error

}

?>
