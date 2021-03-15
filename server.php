<?php

$username = '';
$email = '';
$errors = array('username' => '', 'email' => '', 'password_1' => '');
//$errors = array();

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


    // ensure that form fields are filled properly

    // if(empty($username)){
    //     array_push($errors, "Username is required");
    // }

    if(empty($_POST['username'])){
        $errors['username'] = "Username is required";
    }

    if(empty($_POST['email'])){
        $errors['email'] = "Email is required";
    }

    // if(empty($password_1)){
    //     array_push($errors, "Password is required");
    // }

    // if($password_1 != $password_2){
    //     array_push($errors, "The two passwords do not match");
    // }

    // if there are no errors, save user to database
    if (count($errors) == 0){

        // encrypt password befor storing in the db
        $password = md5($password_1);

        $sql = "INSERT INTO users (username, email, password)
            VALUES ('$username', '$email', '$password')";
        
        mysqli_query($db, $sql);
    }

}



?>