
<?php
    if(session_id() === "") session_start();
    if (!isset($_SESSION['email'])){
    header('Location: index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./source/css/basic.css">
    <title>Home Page</title>
</head>
<body>
    <div class="container d-flex">
        <div class="row">
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="./home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./index.php">Products</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                        <li class="nav-item">
                            <?php if (isset($_SESSION["email"])){
                                echo '<a class="nav-link" href="./logout.php">Log Out</a>';
                            } else 
                            echo '<a class="nav-link" href="./login.php">Log In</a>';
                            ?>
                        </li> 
                            <a class="nav-link" href="./cart.php">
                                <?php if(!isset($_SESSION['cart'])) {
                                    echo 0;
                                    } else {
                                    $counter = 0;
                                    foreach($_SESSION['cart'] as $key => $value){
                                        $counter += 1;
                                    }
                                    echo $counter;
                                    } ?> <i class="bi bi-cart4 h-100"></i>
                            </a>
                        </li> 
                        
                    </ul>
                </div>
            </nav>
        </div>
        <div class="row mt-3">
        
            
            <div class='col'>
                
            </div>
            
            <div class='col-10 '>
                
            <?php 
                   
                    
                    $connect = mysqli_connect('localhost', 'root','', 'webshop') or die('Connecion failed');
                                                            

                    echo '<table class="table table-striped">
                        <tr> <th>Product ID</th> <th>Name</th> <th>Quantity</th> <th>Price</th> <th>Total</th><th></th></tr>';

                    $sum = 0;
                    if (isset($_SESSION['cart'])){
                        foreach($_SESSION['cart'] as $key => $value){
                            $sql = "SELECT * FROM Product WHERE ID = ".$value['product_id']."";
                            $query = mysqli_query($connect, $sql);
                            if($query) {
                                $result = $connect->query($sql);
                                $row = $result->fetch_assoc();
                                    
                            }
                            $sum += $row['PRICE'] * $value['quantity'];
                            echo '<tr> <td>'.$value['product_id'].'</td> <td>'.$row['NAME'].'</td> <td><input id="'.$value['product_id'].'" type="number" name="quantity" value='.$value['quantity'].' class="quantity form-control text-center" style="width:80px" min="1" ></td> <td><span class="price">'.$row['PRICE'].'</span></td><td><span class="total">'.$row['PRICE']*$value['quantity'].'</span></td> <td><button class="remove-product btn btn-outline-danger" value="'.$value['product_id'].'">X</button></td></tr>';
                        }
                    }
                    

                    echo '
                    <tr> <td></td> <td></td> <td></td> <td></td><td><span id="total">'.$sum.'</span></td> <td></td></tr>
                    </table>
                    <div class="row">
                        <div class="col d-flex flex-row-reverse">
                            <button id="order" type="button" class="btn btn-outline-success" style="width:105px">Order</button>
                        </div>

                    </div>
                    
                    ';
                                            
                                ?>

            </div>
            
            <div class='col'>
                
            </div>
            
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script>
        document.querySelectorAll('.quantity').forEach(form=>form.addEventListener('change', event=>{
            event.preventDefault();
            let quantity = event.srcElement.value;
            let product_id = event.srcElement.id;
            
            $.post('modify_cart.php',{'product_id': product_id, 'quantity': quantity})

            event.target.parentElement.parentElement.querySelector('.total').innerHTML =  parseFloat(event.target.parentElement.parentElement.querySelector('.price').innerHTML)*quantity;
            
        })
        )
        document.querySelectorAll('.remove-product').forEach(form=>form.addEventListener('click', event=>{
            event.preventDefault();

            let product_id = event.srcElement.value;

            $.post('remove_from_cart.php',{'product_id': product_id})
            event.target.parentElement.parentElement.remove()

            let sum = 0
            document.querySelectorAll('.total').forEach((el)=>{
                sum += parseFloat(el.innerHTML)
            })
            document.querySelector('#total').innerHTML = sum;

        })
        )

        document.querySelector('#order').addEventListener('click', ()=>{
            window.location.replace('checkout.php')
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>

