<?php 
session_start();
$product_id = $_POST['product_id'];


foreach($_SESSION['cart'] as $key => $value){
   if ($value['product_id'] == $product_id){
        unset($_SESSION['cart'][$key]);
   }
}
print_r($_SESSION);
?>