<?php include('server.php');

    // if user is not logged in, they cannot access this page
    if (empty($_SESSION['username'])){
        header('location: login.php');
    }

?>

<?php include('templates/header.php'); ?>


<div class="header">
    <h2 class="title">Dashboard</h2>
</div>


<div class="content">
    <?php if (isset($_SESSION['success'])): ?>
        <div class="error success">
            <h3> 
                <?php 
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
             </h3>
        </div>
    <?php endif ?>

    <?php if (isset($_SESSION['username'])): ?>
        <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
        <p class=''><a href="dashboard.php?logout='1'">Logout</a></p>
    <?php endif ?>
</div>


<?php include('templates/footer.php'); ?>