
<?php
	if(session_id() === "") session_start();
    $email = $_SESSION['email']
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
                            <a class="nav-link" href="./products.php">Products</a>
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
                                <i class="bi bi-cart4 h-100"></i>
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
                    <form class="" action='change_password.php' method="post">
                        <div class="container"> 
                        

                            <div class='row'>
                                <input type="password" id="old_pass" name="old_password" placeholder="Old password">
                            </div>
                            <div class='row'>
                                <input type="password" id="new_pass_1" name="new_password_1" placeholder="New password">
                            </div>
                            <div class='row'>
                                <input type="password" id="new_pass_2" name="new_password_2" placeholder="New password">
                            </div>
                            <div class='row'>
                                <button type="submit" class="btn btn-outline-secondary">Reset Password</button>
                            </div>


                        </div>
                    </form> 
                </div>
            </div>
            
            <div class='col'>
                
            </div>
            
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script>
        
        document.querySelector('#old_pass').setCustomValidity('Enter old password')
        document.querySelector('#new_pass_1').setCustomValidity('Enter new password')
        document.querySelector('#new_pass_2').setCustomValidity('Confirm new password')
        let email = "<?php echo $email ?>"
       

        $('#old_pass').keyup(function(e){
            $.get('is_the_old_pass.php', { 'email': email, 'old_pass' : document.querySelector('#old_pass').value }).then(
                (data)=>{
                   
                if (data == 1 ){
                    document.querySelector('#old_pass').setCustomValidity('')
                } else {
                    document.querySelector('#old_pass').setCustomValidity('Enter old password')
                }
                    
                }
            );
            
        })
        
        $('#new_pass_1').keyup(function(e){
            if (document.querySelector('#new_pass_1').value==''){
                document.querySelector('#new_pass_1').setCustomValidity('Enter new password')
            } else if (document.querySelector('#new_pass_1').value == document.querySelector('#old_pass').value ){
                document.querySelector('#new_pass_1').setCustomValidity('The new password is the same as the old one')
            } else {
                document.querySelector('#new_pass_1').setCustomValidity('')
            }
            
        })

        $('#new_pass_2').keyup(function(e){
            if (document.querySelector('#new_pass_2').value==''){
                document.querySelector('#new_pass_2').setCustomValidity('Enter new password')
            } else if (document.querySelector('#new_pass_1').value != document.querySelector('#new_pass_2').value ){
                document.querySelector('#new_pass_2').setCustomValidity('New passwords don`t match')
            } else {
                document.querySelector('#new_pass_2').setCustomValidity('')
            }
            
        })
        

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>


