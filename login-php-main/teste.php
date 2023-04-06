<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Require

require 'src/Exception.php'; 
require 'src/PHPMailer.php';
require 'src/SMTP.php'; 
require 'validarUsuario.php';
require 'conexao.php';


    $senha = $_POST['senha'];
    $login = $_POST['login'];


    if($_SESSION['user'] = efetuarLogin($login, $senha)){

        //Gera o código OTP
        $OTP = '0';
        $t =  substr(time(), 5);

        for ($i = 0; $i <6; $i++){
            $OTP += rand(6,$t);
        }
        //código OTP gerado na variável $OTP


                //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->SMTPAuth   = true;
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Username   = 'senacbonsu@gmail.com';                     //SMTP username
            $mail->Password   = 'senac@12751';                               //SMTP password gerado exclusivo para este envio, não é a mesma senha do email.
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = 

            //Recipients
            $mail->setFrom('tibonsucesso@gmail.com', 'Sistema de Login');
            $mail->addAddress('tibonsucesso@gmail.com', ''.$login.'');     //Add a recipient
            $mail->addReplyTo('tibonsucesso@gmail.com', 'Responda para:');

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Código de autenticação de dois fatores.';
            $mail->Body    = 'Utilize o seu código para autenticar: <b>'.$OTP.'</b>';
            $mail->AltBody = 'Utilize o seu código para autenticar: '.$OTP.'';

            $mail->send();
            echo 'Você será redirecionado.';
        } catch (Exception $e) {
            echo "Erro ao enviar email, tente novamente: {$mail->ErrorInfo}";
        }

        
    }
    else{
        $_SESSION['login_error'] = true;
        header("Location: index.php");
    }

?>