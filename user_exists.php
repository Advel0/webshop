<?php
$email = $_GET['email'];

$connect = mysqli_connect('localhost', 'root','', 'webshop') or die('Connecion failed');

    if ($connect) {
        if (isset($_GET['email']) ){
            $email = $_GET['email'];

            $sql = "SELECT * FROM User WHERE Email = '$email' ";
            $query = mysqli_query($connect, $sql);
            if($query) {
                $result = $connect->query($sql);
                $row = $result->fetch_assoc();
                if ($row){
                    echo 1;
                } else {
                echo 0;
                }
            } 
        }
        
    }



?>