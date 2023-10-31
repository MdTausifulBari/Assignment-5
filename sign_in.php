<?php
session_start();

$usersFile = 'users.json';

$users = file_exists( $usersFile ) ? json_decode( file_get_contents( $usersFile ), true ) : [];

//print_r( $_POST );

if( isset( $_POST['login']) ){

    $email    = $_POST['email'];
    $password = $_POST['password'];

    if ( empty( $email ) || empty( $password ) ) {
        $errorMsg = "Please fill  all the fields.";
    } else {
        if ( !((isset( $users[$email] )) && ($users[$email]['password'] == $password))) {
            $errorMsg = "Invalid email or password.";
        } else {
            $_SESSION["email"] = $email;
            
            if($users[$email]["role"] == 'Admin'){
                $_SESSION['role'] = $users[$email]['role'];
                header('Location: role_management.php');
            }else{
                header('Location: user_page.php');
            }

        }
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Login System</title>
    <?php
include 'bootstrap.php';
?>
</head>

<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-8 mx-auto">
                <h3 class="text-center mb-4">Use Role Management App</h3>
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between">
                        <h3>User Log In</h3>
                        <a href="registration.php" class="btn btn-info text-white">
                            Don't have an account?
                        </a>
                    </div>
                    <div class="card-body">
                        <?php

if ( isset( $errorMsg ) ) {
    echo "<p>$errorMsg</p>";
}

?>
                        <form class="form" method="POST">
                            <input class="form-control" type="email" name="email" placeholder="Email"><br>
                            <input class="form-control" type="password" name="password" placeholder="Password"><br>
                            <input class="btn btn-primary" type="submit" name="login" value="Log In">
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
</body>

</html>