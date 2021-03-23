<?php include('server.php');

    // if user is not logged in, they cannot access this page
    if (empty($_SESSION['username'])){
        header('location: login.php');
    }

    //print_r($_SESSION['user_id']);

?>

<?php include('templates/header.php'); ?>


<div class="header">
    <h2 class="title">Dashboard</h2>
</div>


<div class="content">
    <?php if (isset($_SESSION['success'])): ?>
        <div class="error success">
            <h4> 
                <?php 
                //echo $_SESSION['user_id'];
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
             </h4>
        </div>
    <?php endif ?>

    <?php if (isset($_SESSION['username'])): ?>
        <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
        <p class='logout'><a href="dashboard.php?logout='1'">Logout</a></p>
    <?php endif ?>
</div>


<section class="container ">
		<h4 class="center">Add a Pizza</h4>
		<form class="" action="dashboard.php" method="POST" enctype="multipart/form-data">
			<label>Upload Image</label>
            <input type="file" name="file">
            <div class="warning"><?php echo $addErrors['file']; ?></div>

			<label>Pizza Title</label>
			<input type="text" name="title" value="<?php echo htmlspecialchars($title) ?>">
			<div class="warning"><?php echo $addErrors['title']; ?></div>

			<label>Ingredients (comma separated)</label>
			<input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients) ?>">
			<div class="warning"><?php echo $addErrors['ingredients']; ?></div>

			<div class="center">
				<input type="submit" name="add" value="Add" class="btn">
			</div>
		</form>
</section>


<?php include('templates/footer.php'); ?>