<?php include('templates/header.php'); ?>

<div class="header">
    <h2 class="title">Login</h2>
</div>


<form class="" method="post" action="login.php">
    <div class="input-group">
        <label class="text" for="">Username</label>
        <input type="text" name="username">
    </div>
    <div class="input-group">
        <label class="text" for="">Password</label>
        <input type="password" name="password_1">
    </div>
    <div class="input-group">
        <button type="submit" name="login" class="btn">Login</button>
    </div>
    <p class="text">Not yet a member? <a href="<?php echo 'register.php'; ?>">Sign up</a></p>
</form>


<?php include('templates/footer.php'); ?>