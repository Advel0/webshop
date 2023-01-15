<?php 

    function first_login($email,  $connect){
        $sql = "SELECT LastTimeOnline FROM User WHERE Email = '$email'";
        $query = mysqli_query($connect, $sql);
        if($query) {
            
            $result = $connect->query($sql);
            $row = $result->fetch_assoc();
            if ($row){
                $lastTimeOnline = $row['LastTimeOnline'];
                if ($lastTimeOnline == NULL){
                return true;
            } else
                return false;
                
            }
        } 
    }


    if(session_id() === "") session_start();
    $connect = mysqli_connect('localhost', 'root','', 'webshop') or die('Connecion failed');
    if (! isset($_SESSION['email'])){
        

    if ($connect) {
    
        if (isset($_POST['email']) && isset($_POST['password'])){
            $email = $_POST['email'];
            $pass_hash = hash('sha512', $_POST['password']);

            $sql = "SELECT * FROM User WHERE Email = '$email' AND PassHash  = '$pass_hash'";
            $query = mysqli_query($connect, $sql);
            if($query) {
                $result = $connect->query($sql);
                $row = $result->fetch_assoc();
                if ($row){
                    $_SESSION['email'] = $email;
                    $_SESSION['first_name'] = $row['FirstName'];
                    
                    if (first_login($email, $connect)) {
                    header('Location: reset_password.php');
                    }
                }
            } 
        }
        
    }
    } else {
        if (first_login($_SESSION['email'], $connect)){
        header('Location: reset_password.php');
        } else {
        header('Location: login.php');
        }
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
        
            
            <div class='col-1'>
                
            </div>
            
            <div class='col '>
                <div class="row flex-grow-1">
                <h2 class='text-center mb-5 mt-3'>
                        <?php
                            $connect = mysqli_connect('localhost', 'root','', 'webshop') or die('Connecion failed');
                            

                            if(isset($_SESSION['email'])){
                                $email = $_SESSION['email'];
                                $sql = "SELECT * FROM User WHERE Email = '$email'";
                                $query = mysqli_query($connect, $sql);
                                if($query) {
                                    $result = $connect->query($sql);
                                    $row = $result->fetch_assoc();
                                echo "Welcome Mr/Mrs ".$row["LastName"].". You were last online on ".$row["LastTimeOnline"];
                                } 
                            } else {
                            header('Location: index.php');
                            }
                        
                        ?>
                        </h2>
                </div>
                <div class="row">
                            <div class='col'>
                            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                        <img src="/source/img/car1.jpg" class="d-block w-100" alt="..." data-bs-interval="10000">
                        </div>
                        <div class="carousel-item">
                        <img src="/source/img/car2.jpg" class="d-block w-100" alt="..."data-bs-interval="2000">
                        </div>
                        <div class="carousel-item">
                        <img src="/source/img/car3.jpg" class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                    </div>
                            </div>
                </div>
            </div>
            
            <div class='col-1'>
                
            </div>
            
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>

