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
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;           //Enable verbose debug output
            $mail->isSMTP();                   //Send using SMTP
            $mail->SMTPAuth   = true;
            $mail->Host       = 'smtp.gmail.com';    //Set the SMTP server to send through
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Username   = 'gustamarsil@gmail.com';         //SMTP username
            $mail->Password   = 'wxnqukobbucmtvvi';             //SMTP password gerado exclusivo para este envio, não é a mesma senha do email.
            $mail->Port       = 587;        //TCP port to connect to; use 587 if you have set `SMTPSecure = 

            //Recipients
            $mail->setFrom('gustamarsil@gmail.com', 'Sistema de Login');
            $mail->addAddress('gustamarsil@gmail.com', ''.$login.'');    //Add a recipient
            $mail->addReplyTo('gustamarsil@gmail.com', 'Responda para:');

            //Content
            $mail->isHTML(true);           //Set email format to HTML
            $mail->Subject = 'Código de autenticação de dois fatores.';
            $mail->Body    = 'Utilize o seu código para autenticar: <b>'.$OTP.'</b>';
            $mail->AltBody = 'Utilize o seu código para autenticar: '.$OTP.'';

            $mail->send();
            $query = "UPDATE autenticacao SET codigo = '$OTP', hora = '10:33' WHERE id_user = 1 ";
            $result = mysqli_query(abreConexao(), $query);
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