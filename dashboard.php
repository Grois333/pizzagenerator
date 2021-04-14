<?php 

    include('server.php');

    // if user is not logged in, they cannot access this page
    if (empty($_SESSION['username'])){
        header('location: login.php');
    }

    //print_r($_SESSION['user_id']);
    $userId = $_SESSION['user_id'];
    //print_r($userId);



    //Get Orders

    // write query for all orders
    $GetOrder = "SELECT id,id_of_pizza,image,title,ingredients,customer_name,phone,email,comments FROM orders WHERE id_of_pizza = $userId ORDER BY order_date";
    
    // get the result set (set of rows)
    $GetResult = mysqli_query($db, $GetOrder);

    // fetch the resulting rows as an array
    $orders = mysqli_fetch_all($GetResult, MYSQLI_ASSOC);

    // free the $result from memory (good practice)
    mysqli_free_result($GetResult);

    // close connection
    mysqli_close($db);

    //Debug
    print_r($orders);




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


<section class="orders-section">

        <h4>Orders</h4>

</section>


<?php include('templates/footer.php'); ?>