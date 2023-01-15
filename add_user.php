<?php 

require "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}


$connect = mysqli_connect('localhost', 'root','', 'webshop') or die('Connecion failed');
if ($connect) {
    $pass = randomPassword();
    $passHash = hash('sha512', $pass);
    $first_name = $_POST['first_name'];
    $second_name = $_POST['second_name'];
    $email = $_POST['email'];



    $sql = "INSERT INTO User(FirstName, LastName,Email, PassHash )
            VALUES('$first_name', '$second_name', '$email', '$passHash' )
    ";
    // $query = mysqli_query($connect, $sql);

    if ($connect->query($sql) === TRUE) {
        echo "New record created successfully";
      } else {
        echo "Error: " . $sql . "<br>" . $connect->error;
      }
    




    $subject = 'New Account at WEBSHOP';
    $message = "Thank you for registering at WEBSHOP.You may now log in by going to the login page, and using next credantials:
        Login: ".$email. 
        "Password: ". $pass.
        "After the first login you will be asked to set your own password";


    $mail = new PHPMailer(true);


    $mail->isSMTP();
    $mail->SMTPAuth = true;

    $mail->Host = "smtp.gmail.com";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->Username = "0advel0@gmail.com";
    $mail->Password = "gexkzhpdwzqhfzzm";

    $mail->setFrom($email, "WEPSHOP");
    $mail->addAddress($email, $first_name );

    $mail->Subject = $subject;
    $mail->Body = $message;

    $mail->send();

    header('Location: login.php');
}
?>