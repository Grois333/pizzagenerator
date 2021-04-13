<?php 

    include('server.php');

    // if user is not logged in, they cannot access this page
    if (empty($_SESSION['username'])){
        header('location: login.php');
    }

    //print_r($_SESSION['user_id']);

?>


<?php include('templates/header.php'); ?>


<div>The Form was submitted, Thanks for your order!</div>

<div>Go Back To <a href="<?php echo './'; ?>">Home Page</a></div>



<?php include('templates/footer.php'); ?>