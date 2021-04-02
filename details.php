<?php 

include('server.php'); 


//Get Pizza Info

// check GET request id param
if(isset($_GET['id'])){
		
    // escape sql chars
    $id = mysqli_real_escape_string($db, $_GET['id']);

    // make sql
    $sql = "SELECT * FROM pizzas WHERE id = $id";

    // get the query result
    $result = mysqli_query($db, $sql);

    // fetch result in array format
    $pizza = mysqli_fetch_assoc($result);

    mysqli_free_result($result);
    mysqli_close($db);

    //print_r($pizza);

    // Only date without hours  
    $yourDateTime = $pizza['created_at'];
    $date = date('d-m-Y', strtotime($yourDateTime));
    
    //Getting the Image
    $imageURL = 'uploads/'. $pizza['image'];

}


    //Delete Pizza
    if(isset($_POST['delete'])){

        $id_to_delete = mysqli_real_escape_string($db, $_POST['id_to_delete']);

        $sql = "DELETE FROM pizzas WHERE id = $id_to_delete";

        if(mysqli_query($db, $sql)){
            header('Location: index.php');
        } else {
            echo 'query error: '. mysqli_error($db);
        }

    }


    //Order Pizza
    if(isset($_POST['order'])){

        $id_to_order = mysqli_real_escape_string($db, $_POST['id_to_order']);

        $sql = "SELECT * FROM pizzas WHERE id = $id_to_order";


         // get the query result
        $result = mysqli_query($db, $sql);

        // fetch result in array format
        $pizza = mysqli_fetch_assoc($result);

        print_r($pizza);
        print_r($pizza['title']);
        // INSERT INFO IN ORDERS TABLE
        // POPUP FORM: Name, email, phone, Comments, Confirm Order



    

        if(mysqli_query($db, $sql)){
            mysqli_free_result($result);
            mysqli_close($db);
            //header('Location: index.php');
        } else {
            echo 'query error: '. mysqli_error($db);
        }

    }



?>


<?php include('templates/header.php'); ?>

<div class="container center grey-text">
		<?php if($pizza): ?>
            <img src="<?=$imageURL;?>" alt="pizza">
			<h4><?php echo $pizza['title']; ?></h4>
			<h5>Ingredients:</h5>
			<p><?php echo $pizza['ingredients']; ?></p>
            <p>Created on: <?php echo $date; ?></p>


			<!-- DELETE FORM -->

            <!-- Show Only if Pizza was created by the current user -->
            <?php /*
                echo $_SESSION['user_id']; //user ID
                echo $pizza['pizza_id']; //pizza ID 
                */

                if($_SESSION['user_id'] == $pizza['pizza_id']): ?>

                    <form action="details.php" method="POST">
                    <input type="hidden" name="id_to_delete" value="<?php echo $pizza['id']; ?>">
                    <input type="submit" name="delete" value="Delete" class="btn">
                    </form>
                <?php endif ?>

  <!--*****************************************  CONVERT TO MODAL************************************************************************   -->
                <!-- ORDER FORM MODAL -->
                <form action="details.php" method="POST">
                    <input type="hidden" name="id_to_order" value="<?php echo $pizza['id']; ?>">
                    <input type="submit" name="order" value="Order" class="btn">
                </form>
 <!--*****************************************  CONVERT TO MODAL************************************************************************   -->
 

		<?php else: ?>
			<h5>No such pizza exists.</h5>
		<?php endif ?>
</div>


<?php include('templates/footer.php'); ?>