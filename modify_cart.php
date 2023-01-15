<?php 
session_start();
$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];
$o_product = [
    "product_id" => $product_id,
    "quantity" => $quantity
];


foreach($_SESSION['cart'] as $key => $value){
   if ($value['product_id'] == $product_id){
    $_SESSION['cart'][$key]['quantity'] = $quantity;    
   }
}
print_r($_SESSION);
?>