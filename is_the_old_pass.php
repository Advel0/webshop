<?php
$old_pass_entered = $_GET['old_pass'];
$email = $_GET['email'];
$connect = mysqli_connect('localhost', 'root','', 'webshop') or die('Connecion failed');

if ($connect) {
        

    $pass_hash = hash('sha512', $old_pass_entered);

    $sql = "SELECT * FROM User WHERE Email = '$email' AND PassHash  = '$pass_hash'";

    $query = mysqli_query($connect, $sql);
    if($query) {
        $result = $connect->query($sql);
        $row = $result->fetch_assoc();
        if ($row){
            echo 1;
        } else{
            echo 0;
        }
    } 

}


?>