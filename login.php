<?php include('server.php'); 

    // if user is logged in redirect to dashboard until logout
    if (!empty($_SESSION['username'])){
        header('location: dashboard.php');
    }

?>



<?php include('templates/header.php'); ?>

<div class="header">
    <h2 class="title">Login</h2>
</div>


<form class="" method="post" action="login.php">

     <!-- Display validation errors here -->
     <?php //include('errors.php'); ?>

    <div class="input-group">
        <label class="text" for="">Username</label>
        <input type="text" name="username">
        <div class="warning"><?php echo $errors['username']; ?></div>
    </div>
    <div class="input-group">
        <label class="text" for="">Password</label>
        <input type="password" name="password_1">
        <div class="warning"><?php echo $errors['password_1']; ?></div>
    </div>
    <div class="input-group">
        <button type="submit" name="login" class="btn">Login</button>
    </div>
    <p class="text">Not yet a member? <a href="<?php echo 'register.php'; ?>">Sign up</a></p>
</form>


<?php include('templates/footer.php'); ?>