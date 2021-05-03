<?php 

include('server.php'); 


//Get Pizza Info

// check GET request id param (from header)
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
    if(isset($_POST['id_to_order'])){
 
        //echo "yes this is just example and working";

        //Sanitize
        $id_to_order = mysqli_real_escape_string($db, $_POST['id_to_order']);
        $customer_name = mysqli_real_escape_string($db, $_POST['name']);
        $phone = mysqli_real_escape_string($db, $_POST['phone']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $comments = mysqli_real_escape_string($db, $_POST['comments']);
        //print_r($id_to_order);
        //print_r($customer_name);
        //print_r($phone);
        //print_r($email);
        //print_r($comments);

        $sql = "SELECT * FROM pizzas WHERE id = $id_to_order";

        // get the query result
        $result = mysqli_query($db, $sql);

        // fetch result in array format
        $pizza = mysqli_fetch_assoc($result);

        //print_r($pizza);
        //print_r($pizza['title']);
        //print_r($pizza['pizza_id']);

        //Set variable values for Pizza Details
        $pizzaImage = $pizza['image'];
        $pizzaTitle = $pizza['title'];
        $pizzaIngredients = $pizza['ingredients'];
        $id_pizza = $pizza['pizza_id'];

        
        // INSERT INFO IN ORDERS TABLE
        $sql = "INSERT INTO orders(id_of_pizza,image,title,ingredients,customer_name,phone,email,comments) VALUES('$id_pizza','$pizzaImage','$pizzaTitle','$pizzaIngredients','$customer_name','$phone','$email','$comments')";


        // Send Email Order
        $to_email = $email;
        $subject = "Pizza Order";
        $body = "Hi,nn This is a Pizza Order Email";
        $headers = "From: sender\'s email";
        
        if (mail($to_email, $subject, $body, $headers)) {
            echo "Email successfully sent to $to_email...";
        } else {
            echo "Email sending failed...";
        }


        if(mysqli_query($db, $sql)){
            mysqli_free_result($result);
            mysqli_close($db);
            //header('Location: order-thanks.php');
        } else {
            echo 'query error: '. mysqli_error($db);
        }
        
    }

?>


<?php include('templates/header.php'); ?>

<INPUT class="back" type="button" value="&larr; Back" onClick="history.go(-1);">

<div class="container-fluid center grey-text text-center">
		<?php if($pizza): ?>
            <div class="pizza-image-wrapper"><img src="<?=$imageURL;?>" alt="pizza"></div>
			<h4 class="title"><?php echo $pizza['title']; ?></h4>
			<div class="text">Ingredients: <?php echo $pizza['ingredients']; ?></div>
            <div class="text">Created on: <?php echo $date; ?></div>


			<!-- DELETE FORM -->

            <!-- Show Only if Pizza was created by the current user -->
            <?php /*
                echo $_SESSION['user_id']; //user ID
                echo $pizza['pizza_id']; //pizza ID 
                */

                //If user is Logged In
                if(isset($_SESSION['user_id'])):

                    if($_SESSION['user_id'] == $pizza['pizza_id']): ?>

                        <form class="delete_form" action="<?=$_SERVER['PHP_SELF'];?>" method="POST">
                            <input type="hidden" name="id_to_delete" value="<?php echo $pizza['id']; ?>">
                            <input type="submit" name="delete" value="Delete" class="btn">
                        </form>
                    <?php endif ?>

                <?php endif ?>


               <!-- ORDER FORM MODAL -->

                <!-- Button trigger modal -->
                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#orderModal">
                Order
                </button>

                <!-- Modal -->
                <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Confirm Order Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                                <div class="modal-body">
                                    <form name="orderForm" action="details.php" method="POST">
                                        <input type="hidden" name="id_to_order" value="<?php echo $pizza['id']; ?>">

                                        <input type="text" name='name' placeholder="Name">
                                        <div class="warning orderName-error"></div>

                                        <input type="tel" name='phone' placeholder="Phone">
                                        <div class="warning orderPhone-error"></div>

                                        <input type="email" name='email' placeholder="Email(opcional)">
                                        <div class="warning orderEmail-error"></div>

                                        <textarea name="comments" id="" cols="10" rows="5" placeholder="comments(optional)"></textarea>
                                    
                                        <input type="submit" name="order" value="Confirm Order" class="btn">
                                    </form>
                                </div>
                        </div>
                    </div>
                </div>

        

		<?php else: ?>
			<h5>No such pizza exists.</h5>
		<?php endif ?>
</div>


<?php include('templates/footer.php'); ?>