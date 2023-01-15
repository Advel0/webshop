
<?php
    if(session_id() === "") session_start();
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
                        </li> 
                        
                    </ul>
                </div>
            </nav>
        </div>
        <div class="row flex-grow-1">
        
            
            <div class='col'>
                
            </div>
            
            <div class='col d-flex'>
                <div class="row flex-grow-1 d-flex align-items-center">
                    <form class="" action='home.php' method="post">
                        <div class='container'> 
                        
                        
                        
                        

                        <div class='row'>
                            <input type="email" name="email" placeholder="Email">
                        </div>

                        <div class='row'>
                        <input type="password" name="password" placeholder="Password">
                        </div>
                        <div class='row'>
                        <button type="submit" class="btn btn-outline-secondary">Login</button>
                        </div>
                        <div class='row text-center'>
                            <a class="nav-link" href="./signup.php">Sign Up</a>
                        </div>
                        </div>
                        <!-- <input type="submit" name="submit" value="Login"> -->
                    </form> 
                </div>
            </div>
            
            <div class='col'>
                
            </div>
            
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>


