<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/home8/crimsonw/public_html/s270012/ArtisanalDips/php/PHPMailer/src/Exception.php';
require '/home8/crimsonw/public_html/s270012/ArtisanalDips/php/PHPMailer/src/PHPMailer.php';
require '/home8/crimsonw/public_html/s270012/ArtisanalDips/php/PHPMailer/src/SMTP.php';

include_once("dbconnect.php");

$email = $_POST['email'];
$newotp = rand(1000,9999);
$newpassword = random_password(10);
$passha = sha1($newpassword);


$sql = "SELECT * FROM tbl_user WHERE email = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) 
        {$sqlupdate = "UPDATE tbl_user SET otp = '$newotp', password = '$passha' WHERE email = '$email'";
         if ($conn->query($sqlupdate) === TRUE)
            {sendEmail($newotp,$newpassword,$email);
             echo 'success';
            }
         else
            {echo 'failed';
            }
        }
    else
        {echo "failed";
        }

function sendEmail($otp,$newpassword,$email)
    {$mail = new PHPMailer(true);
     $mail->SMTPDebug = 0;                                      //Disable verbose debug output
     $mail->isSMTP();                                           //Send using SMTP
     $mail->Host       = 'mail.crimsonwebs.com';                //Set the SMTP server to send through
     $mail->SMTPAuth   = true;                                  //Enable SMTP authentication
     $mail->Username   = 'artisanaldips@crimsonwebs.com';       //SMTP username
     $mail->Password   = 'A,YFSyM0b=5z';                        //SMTP password
     $mail->SMTPSecure = 'tls';         
     $mail->Port       = 587;
    
     $from = "artisanaldips@crimsonwebs.com";
     $to = $email;
     $subject = "From Artisanal Dips. Password Reset ";
     $message = "<p>Your account password has been reset. Please login using the new password below.</p><br><br><h3>Password: ".$newpassword."</h3><br><br><a href='https://crimsonwebs.com/s270012/ArtisanalDips/php/verify.php?email=".$email."&key=".$otp."'>Click here to reactivate your account</a>";
    
     $mail->setFrom($from,"ArtisanalDips");
     $mail->addAddress($to);                                             //Add a recipient
    
     //Content
     $mail->isHTML(true);                                                //Set email format to HTML
     $mail->Subject = $subject;
     $mail->Body    = $message;
     $mail->send();
    }

function random_password($length)
    {//A list of characters that can be used in our random password
     $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
     //Create blank string
     $password = '';
     //Get the index of the last character in our $characters string
     $characterListLength = mb_strlen($characters, '8bit') - 1;
     //Loop from 1 to the length that was specified
     foreach(range(1,$length) as $i)
        {$password .=$characters[rand(0,$characterListLength)];
        }
     return $password;
    }
?>