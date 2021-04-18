<?php 

    include('server.php');

    // if user is not logged in, they cannot access this page
    if (empty($_SESSION['username'])){
        header('location: login.php');
    }

    //print_r($_SESSION['user_id']);
    $userId = $_SESSION['user_id'];
    //print_r($userId);



    //Get Confirmed Orders

    // write query for all orders
    $GetOrder = "SELECT id_of_order,id_of_pizza,image,title,ingredients,customer_name,phone,email,comments,order_date,order_status FROM confirm_orders WHERE id_of_pizza = $userId ORDER BY order_date";
    
    // get the result set (set of rows)
    $GetResult = mysqli_query($db, $GetOrder);

    // fetch the resulting rows as an array
    $confirmed_orders = mysqli_fetch_all($GetResult, MYSQLI_ASSOC);

    // free the $result from memory (good practice)
    mysqli_free_result($GetResult);

    //Debug
    //print_r($confirmed_orders);

    // close connection
    mysqli_close($db);


?>



<?php include('templates/header.php'); ?>

<INPUT type="button" value="Back" onClick="history.go(-1);">


<section class="orders-history-section">

    <h4>Orders History:</h4>

    <?php if($confirmed_orders > 0){ ?>

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

                    <?php foreach($confirmed_orders as $order): 

                        $imageURL = 'uploads/'. $order['image'];

                        // Format Date 
                        $myDateTime = $order['order_date'];
                        $new_date = date('D M Y H:i:s', strtotime($myDateTime));
                                
                    ?>
        
                        <tr>
                            <td style="border: 1px solid"><?php echo $order['id_of_order'] ?></td>
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
                            <td style="border: 1px solid"><?php echo $order['order_status']?></td>
                            
                        </tr>
               

                    <?php endforeach; ?>
            
                </table>
        
            </div>
        </div>

    <?php } ?>

</section>


<?php include('templates/footer.php'); ?>