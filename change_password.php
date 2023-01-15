<?php
if(session_id() === "") session_start();

$email = $_SESSION['email'];
$pass = $_POST['new_password_2'];
$connect = mysqli_connect('localhost', 'root','', 'webshop') or die('Connecion failed');

if ($connect) {
        

    $pass_hash = hash('sha512', $pass);

    $sql = "UPDATE USER 
            SET PassHash = '$pass_hash',
            LastTimeOnline=NOW()
            WHERE Email='$email'";

    $query = mysqli_query($connect, $sql);
    if($query) {
        $result = $connect->query($sql);
        
    }

    header("Location: home.php");
}
?>