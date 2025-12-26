<?php

session_start();

include_once('config.php');

if(isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        echo "Please fill in all fields";
    } else {
        $sql = "SELECT id, name, username, email, password, is_admin FROM users WHERE username=:username";
        $selectUser = $conn->prepare($sql);
        $selectUser->bindParam(":username", $username);
        $selectUser->execute();
        $data = $selectUser->fetch();

        if ($data == false) {
            echo "The user does not exist";
        } else {
            // vetem admina te caktum
            $allowed_admins = ['dionsherifi'];  // ← username t'adminav (nkit rast veq un)
            if (!in_array($data['username'], $allowed_admins)) {
                echo "Access denied: You are not authorized to access the admin dashboard.";
                exit();
            }

            if (password_verify($password, $data['password'])) {
                $_SESSION['id'] = $data['id'];
                $_SESSION['username'] = $data['username'];
                $_SESSION['email'] = $data['email'];
                $_SESSION['name'] = $data['name'];
                $_SESSION['is_admin'] = $data['is_admin'];

                header('Location: adminHome.php');
            } else {
                echo "The password is not valid";
            }
        }
    }
}


?>