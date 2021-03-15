<?php include('templates/header.php'); ?>

<div class="header">
    <h2 class="title">Register</h2>
</div>


<form class="" method="post" action="login.php">
    <div class="input-group">
        <label class="text" for="">Username</label>
        <input type="text" name="username">
    </div>
    <div class="input-group">
        <label class="text" for="">Email</label>
        <input type="email" name="email">
    </div>
    <div class="input-group">
        <label class="text" for="">Password</label>
        <input type="password" name="password_1">
    </div>
    <div class="input-group">
        <label class="text" for="">Confirm Password</label>
        <input type="password" name="password_2">
    </div>
    <div class="input-group">
        <button type="submit" name="login" class="btn">Register</button>
    </div>
    <p class="text">Already a member? <a href="<?php echo 'login.php'; ?>">Login</a></p>
</form>


<?php include('templates/footer.php'); ?>