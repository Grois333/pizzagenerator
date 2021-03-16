<?php

$username = '';
$email = '';
$password_1 = '';
$password_2 = '';

//$errors = array();
$errors = array('username' => '', 'email' => '', 'password_1' => '', 'password_2' => '');


// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'pizzagenerator');

// check connection
if(!$db){
    echo 'Connection error: '. mysqli_connect_error();
}

// if the register button is clicked
if (isset($_POST['register'])){
    
    // $username = mysqli_real_escape_string($db, $_POST['username']);
    // $email = mysqli_real_escape_string($db, $_POST['email']);
    // $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    // $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);


    // ensure that form fields are filled properly:

    // if(empty($username)){
    //     array_push($errors, "Username is required");
    // }

    if(empty($_POST['username'])){
        $errors['username'] = "Username is required";
    }

    if(empty($_POST['email'])){
        $errors['email'] = "Email is required";

    }  else {
            $email = $_POST['email'];
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $errors['email'] = 'Email must be a valid address';
                }
        }

    if(empty($_POST['password_1'])){
        $errors['password_1'] = "Password is required";
    }

    if($_POST['password_1'] != $_POST['password_2']){
        $errors['password_2'] = "The two passwords do not match";
    }


    // if there are no errors, save user to database
    if ($errors['username'] == '' && $errors['email'] == '' && $errors['password_1'] == '' && $errors['password_2'] == '' ){
    
        // // encrypt password befor storing in the db
        // $password = md5($password_1);

        // $sql = "INSERT INTO users (username, email, password)
        //     VALUES ('$username', '$email', '$password')";
        
        // mysqli_query($db, $sql);


        // escape sql chars
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);

        // encrypt password befor storing in the db
        $password = md5($password_1);

        // create sql
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username','$email','$password')";

        // save to db and check
        if(mysqli_query($db, $sql)){
            // success
            header('Location: index.php');
        } else {
            echo 'query error: '. mysqli_error($db);
        }
    }

}



?>