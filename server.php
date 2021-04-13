<?php

session_start();

$user_id = 0;
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

//Register
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

    //Check if user is registerd
    $select = mysqli_query($db,"SELECT `email` FROM `users` WHERE `email` = '".$_POST['email']."'");
    if(mysqli_num_rows($select)) {
        //exit('This email is already being used');
        $errors['password_1'] = "This email is already being used";
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

        // encrypt password before storing in the db
        $password = md5($password_1);

        // create sql
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username','$email','$password')";

        // save to db and check
        if(mysqli_query($db, $sql)){
            // success

            // select user from db
            $query = "SELECT * FROM users WHERE email = '$email'";

            $result = mysqli_query($db, $query);

            // Get user ID
            $row = mysqli_fetch_assoc($result);
            $user_id =  $row['id'];
            $_SESSION['user_id'] = $user_id;
            //echo $user_id;
            //print_r($_SESSION['user_id']);

            // session
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";

            // redirect
           header('Location: dashboard.php');

        } else {
            echo 'query error: '. mysqli_error($db);
        }


    }

}


//Login
// log user in from login page
if (isset($_POST['login'])){

    // ensure that all fields are filled properly
    if(empty($_POST['username'])){
        $errors['username'] = "Username is required";
    }

    if(empty($_POST['password_1'])){
        $errors['password_1'] = "Password is required";
    }

     // if there are no errors, look for user in db
    if ($errors['username'] == '' && $errors['email'] == '' && $errors['password_1'] == '' && $errors['password_2'] == '' ){
    
        // escape sql chars
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);

        // encrypt password befor retrieving user in the db
        $password = md5($password_1);

        // select user from db
        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password' ";

        $result = mysqli_query($db, $query);

        if (mysqli_num_rows($result) == 1){

            //log user in

             // user ID
             $row = mysqli_fetch_assoc($result);
             $user_id =  $row['id'];
             $_SESSION['user_id'] = $user_id;
             //echo $user_id;
 
             // session
             $_SESSION['username'] = $username;
             $_SESSION['success'] = "You are now logged in";
 
             // redirect
             header('Location: dashboard.php');

        } else {

            $errors['password_1'] = "Wrong username/password combination";
            
        }
    }

}


// logout
if (isset($_GET['logout'])){
    session_destroy();
    unset($_SESSION['username']);
    header('location: login.php');
}



// add a pizza
$addErrors = array('file' => '', 'title' => '', 'ingredients' => '');
$file = $title = $ingredients = '';

if(isset($_POST['add'])){

    // Upload image setup
    $targetDir = 'uploads/';
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // check image upload
    if(empty($_FILES['file']['name'])){
        $addErrors['file'] = 'Empty File upload';
    
    } 
    

     // check title
     if(empty($_POST['title'])){
        $addErrors['title'] = 'A title is required';
    } else{
        $title = $_POST['title'];
        if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
            $addErrors['title'] = 'Title must be letters and spaces only';
        }
    }


    // check ingredients
    if(empty($_POST['ingredients'])){
        $addErrors['ingredients'] = 'At least one ingredient is required';
    } else{
        $ingredients = $_POST['ingredients'];
        if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)){
            $addErrors['ingredients'] = 'Ingredients must be a comma separated list';
        }
    }


    if(array_filter($addErrors)){

        //echo 'errors in form add';
        print_r('error');

    } else {

        // If all fields are filled correctly

        // Upload image
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if(!file_exists($targetFilePath)){
            if(in_array(strtolower($fileType), $allowTypes)){
                
                move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath);

                // if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
                // } else {
                //     $addErrors['file'] = 'Error uploading file';
                //     //unlink($_POST['filename']);
                // }

            }  else {
                $addErrors['file'] = 'Only JPG, PNG, JPEG & GIF files allowed';
            } 

        }  else {
            $addErrors['file'] = 'This file already exists';

        } 


        // escape sql chars
        //$file = mysqli_real_escape_string($db, $_POST['file']);
        $intUser = mysqli_real_escape_string($db, $_SESSION['user_id']); //get current user id from session variable
        $title = mysqli_real_escape_string($db, $_POST['title']);
        $ingredients = mysqli_real_escape_string($db, $_POST['ingredients']);

        //print_r($intUser);

        // create sql
        $sql = "INSERT INTO pizzas(pizza_id,image,title,ingredients) VALUES('$intUser', '$fileName','$title','$ingredients')";


        //$insert = $db -> query("INSERT INTO pizzas(image) VALUES('$fileName')");
                
        if($sql){
            $addErrors['file'] = 'File uploaded';
        } else{
            $addErrors['file'] = 'File upload failed';
        } 

        // save to db and check
        if(mysqli_query($db, $sql)){
            // success
            header('Location: index.php');
        } else {
            echo 'query error: '. mysqli_error($db);
        }

    }

} // end POST check





?>