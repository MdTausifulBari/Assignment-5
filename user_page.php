<?php
session_start();

if(!isset($_SESSION['email'])){
    header('Location: sign_in.php');
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>User Interface</title>
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
                        <h3>Dashboard</h3>
                        <form action="log_out.php" method="POST">
                            <input class="btn btn-danger btn-sm" type="submit" name="logout" value="Log out">
                        </form>
                    </div>
                    <div class="card-body">
                        <h1>Welcome 
                            <?php 
                                $usersFile = 'users.json';

                                $users = json_decode( file_get_contents( $usersFile ), true);
                                
                                echo $users[ $_SESSION['email'] ]['username'];
                            ?> 
                            </h1><br>
                    </div>
                </div>


            </div>
        </div>
    </div>
</body>

</html>