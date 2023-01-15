<?php 
session_start();
$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];
$o_product = [
    "product_id" => $product_id,
    "quantity" => $quantity
];
$_SESSION['cart'][] = $o_product;
?>