<?php


if(session_id() === "") session_start();
    $connect = mysqli_connect('localhost', 'root','', 'webshop') or die('Connecion failed');


    if ($connect){

        $sql = 'SELECT * FROM USER WHERE Email = "'.$_SESSION['email'].'"';
  
        $query = mysqli_query($connect, $sql);
  
    if ($query) {
   
        $result = $connect->query($sql);
        $row = $result->fetch_assoc();
        }
    }
    $user_id = $row['ID'];



    // header('Location: home.php');

    // $user_id = $row['ID'];

    

    $sql = 'INSERT INTO ProductOrder(
    CustomerID ,
    Address,
    RecieverName ,
    RecieverSurname,
    RecieverEmail,
    Price,
    Date) 
    VALUES('.$user_id.', '.$_POST['address'].', '.$_POST['first_name'].', '.$_POST['second_name'].','.$_POST['email'].', '.$_POST['price'].', NOW())';
    $query = mysqli_query($connect, $sql);
    $result = $connect->query($sql);

    $sql = 'SELECT * FROM ProductOrder WHERE TIMESTAMPDIFF(MINUTE, NOW(),Date) <= 2;';
    $query = mysqli_query($connect, $sql);
    $result = $connect->query($sql);

    $row = $result->fetch_assoc();

    $order_id = $row['ID'];


    foreach($_SESSION['cart'] as $key => $value){
        $sql = 'INSERT INTO OrderedProduct (ProductID,
        OrderID)
        VALUES (' . $value['product_id'] . ', ' . $order_id . ')';  
        $query = mysqli_query($connect, $sql);
        $result = $connect->query($sql);
    }

    session_destroy();
    header('Location: home.php');

?>