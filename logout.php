<?php
session_start();
$connect = mysqli_connect('localhost', 'root','', 'webshop') or die('Connecion failed');
// $email = $_SESSION['email'];
// $sql = "UPDATE User 
//         SET LastTimeOnline = NOW()";
// $query = mysqli_query($connect, $sql);

// $result = $connect->query($sql);
// $row = $result->fetch_assoc();


                            
session_destroy();
header('Location: index.php');
?>