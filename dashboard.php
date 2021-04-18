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
    $GetOrder = "SELECT id,id_of_pizza,image,title,ingredients,customer_name,phone,email,comments,order_date FROM orders WHERE id_of_pizza = $userId ORDER BY order_date";
    
    // get the result set (set of rows)
    $GetResult = mysqli_query($db, $GetOrder);

    // fetch the resulting rows as an array
    $orders = mysqli_fetch_all($GetResult, MYSQLI_ASSOC);

    // free the $result from memory (good practice)
    mysqli_free_result($GetResult);

    // close connection
    //mysqli_close($db);

    //Debug
    //print_r($orders);





    //Confirm Orders:

    //Insert in Confirmed Orders Table
    if(isset($_POST['confirm'])){
        
        //Sanitize
        $id_to_confirm = mysqli_real_escape_string($db, $_POST['id_to_confirm']);
        //print_r($id_to_confirm);

        $order_status = mysqli_real_escape_string($db, $_POST['status']);
        //print_r($order_status);

        $sql = "SELECT * FROM orders WHERE id = $id_to_confirm";
        // get the query result
        $result = mysqli_query($db, $sql);
        // fetch result in array format
        $order = mysqli_fetch_assoc($result);
        //print_r($order);


        //Set variable values for Pizza Details
        $order_id = $order['id'];
        $order_pizza_id = $order['id_of_pizza'];
        $order_image = $order['image'];
        $order_title = $order['title'];
        $order_ingredients = $order['ingredients'];
        $order_customer_name = $order['customer_name'];
        $order_phone = $order['phone'];
        $order_email = $order['email'];
        $order_comments = $order['comments'];
        $order_date = $order['order_date'];
        //print_r($order_date);


        //Insert into Confirm Orders Table
        $sql = "INSERT INTO confirm_orders(id_of_order,id_of_pizza,image,title,ingredients,customer_name,phone,email,comments,order_date,order_status) VALUES('$order_id','$order_pizza_id','$order_image','$order_title','$order_ingredients','$order_customer_name','$order_phone','$order_email','$order_comments','$order_date','$order_status')";

        if(mysqli_query($db, $sql)){
            mysqli_free_result($result);
            //mysqli_close($db);
            //header('Location: dashboard.php');
        } else {
            echo 'query error: '. mysqli_error($db);
        }



        //Delete current order

        $sql2 = "DELETE FROM orders WHERE id = $order_id";

        if(mysqli_query($db, $sql2)){
            header('Location: dashboard.php');
        } else {
            echo 'query error: '. mysqli_error($db);
        }



    }
 





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

    <h4>Current Orders:</h4>

    <?php if($orders > 0){ ?>

        <div class="">

            <div class="">

                <table border="1" cellspacing="0">
                    <tr>
                        <th style="border: 1px solid">Order N°</th>
                        <th style="border: 1px solid">Image</th>
                        <th style="border: 1px solid">Pizza Name</th>
                        <th style="border: 1px solid">Ingredients</th>
                        <th style="border: 1px solid">Customer</th>
                        <th style="border: 1px solid">Phone</th>
                        <th style="border: 1px solid">Email</th>
                        <th style="border: 1px solid">Comments</th>
                        <th style="border: 1px solid">Order Date</th>
                        <th style="border: 1px solid">Status</th>
                    </tr>

                    <?php foreach($orders as $order): 

                        $imageURL = 'uploads/'. $order['image'];

                        // Format Date 
                        $myDateTime = $order['order_date'];
                        $new_date = date('D M Y H:i:s', strtotime($myDateTime));
                                
                    ?>
        
                        <tr>
                            <td style="border: 1px solid"><?php echo $order['id'] ?></td>
                            <td style="border: 1px solid"><img src="<?=$imageURL;?>" alt="pizza"></td>
                            <td style="border: 1px solid"><?php echo htmlspecialchars($order['title']); ?></td>
                            <td style="border: 1px solid">
                                <ul class="">
                                    <?php foreach(explode(',', $order['ingredients']) as $ing): ?>
                                        <li><?php echo htmlspecialchars($ing); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </td>
                            <td style="border: 1px solid"><?php echo $order['customer_name'] ?></td>
                            <td style="border: 1px solid"><?php echo $order['phone'] ?></td>
                            <td style="border: 1px solid"><?php echo $order['email'] ?></td>
                            <td style="border: 1px solid"><?php echo $order['comments'] ?></td>
                            <td style="border: 1px solid"><?php echo $new_date?></td>
                            <td style="border: 1px solid">
                                <form action="<?=$_SERVER['PHP_SELF'];?>" method="POST" class="confirmOrderForm">
                                    <input type="hidden" name="id_to_confirm" value="<?php echo $order['id']; ?>">
                                        <select name="status" id="statusSelect" class="statusSelect">
                                            <option value="n/a" disabled selected>Select</option>
                                            <option value="paid">Paid</option>
                                            <option value="cancelled">Cancelled</option>
                                        </select>
                                    <input type="submit" name="confirm" value="Confirm" class="btn confirmOrder" id="confirmOrder">
                                </form>
                            </td>
                            
                        </tr>
               

                    <?php endforeach; ?>
            
                </table>
        
            </div>
        </div>

    <?php } ?>

</section>



<h4>Check Orders <a href="order-history.php">History</a></h4>


<?php include('templates/footer.php'); ?>