<?php

session_start();

if(!isset($_SESSION['email'])){
    header('Location: sign_in.php');
}elseif(!isset($_SESSION['role'])){
    header('Location: user_page.php');
}

function loadUsers() {
    $usersData = file_get_contents('users.json');
    return json_decode($usersData, true);
}

function saveUsers($users) {
    file_put_contents('users.json', json_encode($users, JSON_PRETTY_PRINT));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'edit_role') {
        $email = $_POST['email'];
        $role = $_POST['role'];
        
        $users = loadUsers();
        if (isset($users[$email])) {
            $users[$email]['role'] = $role;
            saveUsers($users);
        }
    } elseif ($_POST['action'] === 'delete_user') {
        $email = $_POST['email'];
        
        $users = loadUsers();
        if (isset($users[$email])) {
            $count = 0;

            foreach( $users as $email => $data){
                if( $data['role'] == "Admin" ) {
                    $count++;
                }

                if($count > 1) { break; }
            }

            if($count > 1){
                unset($users[$email]);
                saveUsers($users);
            }else{
                $errorMsg = "Atleast 1 Admin is required!";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Admin Panel</title>
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
                        <h3>Role Management System</h3>
                        <form action="log_out.php" method="POST">
                            <input class="btn btn-danger btn-sm" type="submit" name="logout" value="Log out">
                        </form>
                    </div>
                    <div class="card-body">
                    <?php

if ( isset( $errorMsg ) ) {
    echo "<h4>$errorMsg</h4>";
}

?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Edit Role</th>
                                    <th>Delete User</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $users = loadUsers();
                                foreach ($users as $email => $userData) {
                                    echo "<tr>
                                            <td>{$email}</td>
                                            <td>{$userData['role']}</td>
                                            <td>
                                                <form method='post' class='d-inline'>
                                                    <input type='hidden' name='email' value='{$email}'>
                                                    <input type='hidden' name='action' value='edit_role'>
                                                    <div class='form-group'>
                                                        <select class='form-control' name='role' required>
                                                            <option value='user' " . ($userData['role'] == 'user' ? 'selected' : '') . ">User</option>
                                                            <option value='manager' " . ($userData['role'] == 'manager' ? 'selected' : '') . ">manager</option>
                                                            <option value='admin' " . ($userData['role'] == 'admin' ? 'selected' : '') . ">Admin</option>
                                                        </select>
                                                    </div>
                                                    <button type='submit' class='btn btn-primary btn-sm'>Edit Role</button>
                                            </td>
                                            <td>
                                                </form>
                                                    <form method='post' class='d-inline ml-2'>
                                                        <input type='hidden' name='email' value='{$email}'>
                                                        <input type='hidden' name='action' value='delete_user'>
                                                        <button type='submit' class='btn btn-danger btn-sm'>Delete User</button>
                                                    </form>
                                            </td>
                                        </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>
</body>

</html>
