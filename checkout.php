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
        }
    }

        $sum = 0;
        $discount = 0;
        $shipment_price = 40;


    foreach($_SESSION['cart'] as $key => $value){
        $sql = "SELECT * FROM Product WHERE ID = ".$value['product_id']."";
        $query = mysqli_query($connect, $sql);
        if($query) {
             $result = $connect->query($sql);
             $row = $result->fetch_assoc();
            
        }
        $sum += $row['PRICE'] * $value['quantity'];
        if ($value['quantity'] >=16){
        $discount += $row['PRICE'] * $value['quantity'] * 0.16;
        } else if ($value['quantity'] >=8){
            $discount += $row['PRICE'] * $value['quantity'] * 0.8;
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
            
            <div class="container mt-3">
  <main>
   

    <div class="row g-5 ">
      <div class="col-md-5 col-lg-4 order-md-last">

        <ul class="list-group mb-3">
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">Product price</h6>
            </div>
            <span class="text-muted"><?php echo $sum ?> &euro;</span>
          </li>
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">Shipment</h6>
            </div>
            <span id="shipment_price" class="text-muted">40 &euro;</span>
          </li>
          <li class="list-group-item d-flex justify-content-between bg-light">
            <div class="text-success">
              <h6 class="my-0">Discount</h6>
            </div>
            <span class="text-success"><?php echo $discount ?>&euro;</span>
          </li>
          <li class="list-group-item d-flex justify-content-between">
            <span >Total with discount (EUR)</span>
            <strong> <input name='price' id='total' value=<?php echo $sum + $shipment_price - $discount ?>>&euro;</strong>
          </li>
        </ul>

       
      </div>
      <div class="col-md-7 col-lg-8">
        <h4 class="mb-3">Billing address</h4>
        <form class="needs-validation" method='post' action='create_order.php'>
        <input hidden name='price' id='total' value=<?php echo $sum + $shipment_price - $discount ?>>
          <div class="row g-3">
            <div class="col-sm-6">
              <label for="firstName" class="form-label">First name</label>
              <input type="text" class="form-control" id="first_name_input" name='first_name' placeholder="" value="" required>
              <div class="invalid-feedback">
                Valid first name is required.
              </div>
            </div>

            <div class="col-sm-6">
              <label for="lastName" class="form-label">Last name</label>
              <input type="text" class="form-control" id="second_name_input" name='second_name' placeholder="" value="" required>
              <div class="invalid-feedback">
                Valid last name is required.
              </div>
            </div>



            <div class="col-12">
              <label for="email" class="form-label">Email <span class="text-muted"></span></label>
              <input name='email' type="email" class="form-control" id="email" placeholder="you@example.com">
              <div class="invalid-feedback">
                Please enter a valid email address for shipping updates.
              </div>
            </div>

            <div class="col-12">
              <label for="address" class="form-label">Address</label>
              <input type="text" class="form-control" id="address" name='address' placeholder="1234 Main St" required>
              <div class="invalid-feedback">
                Please enter your shipping address.
              </div>
            </div>


          <hr class="my-4">

          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="save-info">
            <label class="form-check-label" for="save-info">Allow processing of the data</label>
          </div>

          <hr class="my-4">

          <h4 class="mb-3">Shipment</h4>

            <div class="my-3">
            <div class="form-check">
                <input id="credit" name="shipment" type="radio" class="form-check-input" value='DHL' checked required>
                <label class="form-check-label" >DHL | 40 &euro;</label>
            </div>
            <div class="form-check">
                <input id="debit" name="shipment" type="radio" class="form-check-input" value='DPD' required>
                <label class="form-check-label" >DPD | 25 &euro;</label>
           
            </div>
            <div class="form-check">
                <input id="debit" name="shipment" type="radio" class="form-check-input" value='DHL Express' required>
                <label class="form-check-label" >DHL Express | 40 + 67 &euro;</label>
           
            </div>


            
          <h4 class="mb-3">Payment</h4>

          <div class="my-3">
            <div class="form-check">
              <input id="credit" name="paymentMethod" type="radio" class="form-check-input" checked required>
              <label class="form-check-label" for="credit">Credit card</label>
            </div>
            <div class="form-check">
              <input id="debit" name="paymentMethod" type="radio" class="form-check-input" required>
              <label class="form-check-label" for="debit">Debit card</label>
            </div>
            <div class="form-check">
              <input id="paypal" name="paymentMethod" type="radio" class="form-check-input" required>
              <label class="form-check-label" for="paypal">PayPal</label>
            </div>
          </div>

          <div class="row gy-3">
            <div class="col-md-6">
              <label for="cc-name" class="form-label">Name on card</label>
              <input type="text" class="form-control" id="cc-name" placeholder="" required>
              <small class="text-muted">Full name as displayed on card</small>
              <div class="invalid-feedback">
                Name on card is required
              </div>
            </div>

            <div class="col-md-6">
              <label for="cc-number" class="form-label">Credit card number</label>
              <input type="text" class="form-control" id="cc-number" placeholder="" required>
              <div class="invalid-feedback">
                Credit card number is required
              </div>
            </div>

            <div class="col-md-3">
              <label for="cc-expiration" class="form-label">Expiration</label>
              <input type="text" class="form-control" id="cc-expiration" placeholder="" required>
              <div class="invalid-feedback">
                Expiration date required
              </div>
            </div>

            <div class="col-md-3">
              <label for="cc-cvv" class="form-label">CVV</label>
              <input type="text" class="form-control" id="cc-cvv" placeholder="" required>
              <div class="invalid-feedback">
                Security code required
              </div>
            </div>
          </div>

          <hr class="my-4">
        <script>
            function submit(){
                alert('cock')
                first_name = document.querySelector('#first_name_input');
            second_name = document.querySelector('#second_name_input');
            email = document.querySelector('#email');
            price = <?php echo $sum + $shipment_price ?>;
            let address = document.querySelector('#address').innerHTML;

            

            $.post('create_order.php', {'first_name': first_name, 'second_name': second_name, 'email':email, "price": price, "address": address})
            }
        </script>
          <button id='submit' class="w-100 btn btn-outline-secondary " type="submitцц" onclick="{
            
                   first_name = document.querySelector('#first_name_input');
            second_name = document.querySelector('#second_name_input');
            email = document.querySelector('#email');
            
            price = <?php echo $sum + $shipment_price ?>;
            let address = document.querySelector('#address').innerHTML;

            $.get('create_order.php', {'first_name': first_name, 'second_name': second_name, 'email':email, 'price' : price, 'address': address})
        
          }">Pay</button>
        </form>
      </div>
    </div>
  </main>


</div>

            </div>
            
            <div class='col-1'>
                
            </div>
            
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script>
        $('input[type=radio][name=shipment]').change(function() {
            if (this.value == 'DHL'){
                <?php $shipment_price = 40 ?>
                document.querySelector('#shipment_price').innerHTML = 40 + '&euro;';
                document.querySelector("#total").value = <?php echo $sum + $shipment_price  ?>
            }
            else if(this.value == 'DPD'){
                console.log(this.value)
                <?php $shipment_price = 25 ?>
                document.querySelector('#shipment_price').innerHTML = 25 + '&euro;';
                document.querySelector("#total").value = <?php echo $sum + $shipment_price  ?>
            } else if  (this.value == 'DHL Express'){
                <?php $shipment_price = 107 ?>
                document.querySelector('#shipment_price').innerHTML = 107 + '&euro;';
                document.querySelector("#total").value = <?php echo $sum + $shipment_price  ?>
            }
            
            
        });

        



    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>

