<?php
	if(session_id() === "") session_start();
    if (!isset($_SESSION['cart']))
    $_SESSION['cart'] = array();
	// $connect = mysqli_connect('localhost', 'root','', 'webshop') or die('Connecion failed');
	// $sql = 'SELECT * FROM User';
	// $query = mysqli_query($connect, $sql);
	
	// $result = $connect->query($sql);

	// while($row = $result->fetch_assoc()) {
	// 	echo "id: " . $row["ID"]. " - Name: " . $row["Login"].  "<br>";
	// }

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
    <div class="container">
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
                            <a class="nav-link" href="./cart.php">
                                <span id="ordered_products_counter"> <?php if(!isset($_SESSION['cart'])) {
                                    echo 0;
                                    } else {
                                    $counter = 0;
                                    foreach($_SESSION['cart'] as $key => $value){
                                        $counter += 1;
                                    }
                                    echo $counter;
                                    } ?> </span> <i class="bi bi-cart4 h-100"></i>
                            </a>
                            </a>
                        </li> 
                        
                    </ul>
                </div>
            </nav>
        </div>
        <div class="row content">
                <div class='container'> 
                       <div class='row'>
                            <div class='col'> </div>
                            <div class='col-10'> 
                                <div class='row'>
                                    <h1 class="text-center">Available Products</h1>
                                </div>
                                <div class='row'>
                                
                                <?php 
                                    $connect = mysqli_connect('localhost', 'root','', 'webshop') or die('Connecion failed');

                                    if ($connect) {
    
                                        $sql = "SELECT * FROM Product";
                                        $query = mysqli_query($connect, $sql);
                                        if($query) {
                                            $result = $connect->query($sql);
                                            while ($row = $result->fetch_assoc()){
                                                echo '<div class="col-md-4 mb-3">
                                                <form class="h-100" action="" method="post">
                                                    <div class="container">
                                                        <div class="container d-flex justify-content-between">
                                                            <div class="">
                                                                <img class="img-fluid" src="./source/img/'.$row['NAME'].'.jpg" >
                                                                <h2>'.$row['NAME'].'</h2>
                                                                <h4>'.$row['DESCRIPTION'].'</h2>
                                                            </div>
                                                            <div class="">
                                                                <h4>'.$row['PRICE'].' &euro;</h2>
                                                                <input type="number" name="product_id" value='.$row['ID'].' hidden ">
                                                                <input type="number" name="quantity" value=1 class="form-control" min="1" ">
                                                                <input type="submit" name="add_to_cart" class="btn btn-light my-2 w-100 " value="Add to cart"">
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </form>
                                                </div>';
                                            }
                                                
                                        } 
                                    }
                                ?>

                                </div>
                            </div>
                            <div class='col'> </div>
                       </div>
                </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script>
        document.querySelectorAll('form').forEach(form=>form.addEventListener('submit', event=>{
            event.preventDefault();
            let els = event.srcElement.firstElementChild.getElementsByTagName("*")
            let product_id = els[7].value;
            let quantity = els[8].value;
            
            $.post('add_to_cart.php',{'product_id': product_id, 'quantity': quantity});
            $('#ordered_products_counter')[0].innerHTML = parseInt($('#ordered_products_counter')[0].innerHTML) + 1 
        })
        )
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>

