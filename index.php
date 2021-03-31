<?php 

include('server.php'); 

//Get Pizzas

// write query for all pizzas
$GetPizza = 'SELECT id, image, title, ingredients, pizza_id FROM pizzas ORDER BY created_at';

// get the result set (set of rows)
$GetResult = mysqli_query($db, $GetPizza);

// fetch the resulting rows as an array
$pizzas = mysqli_fetch_all($GetResult, MYSQLI_ASSOC);

// free the $result from memory (good practise)
mysqli_free_result($GetResult);

// close connection
mysqli_close($db);

//Debug
//print_r($pizzas);


?>

    <?php include('templates/header.php'); ?>

    <div class="header">
        <h1 class="center grey-text title">Pizza Generator!</h1>
    </div>

    <?php if($pizzas > 0){ ?>

        <div class="container">
            <div class="row">

                <?php foreach($pizzas as $pizza): 

                    $imageURL = 'uploads/'. $pizza['image'];
                    
                ?>

                    <div class="col">
                        <div class="">
                            <!-- <img src="img/pizza.svg"class="pizza"> -->
                            <div class="">
                            <img src="<?=$imageURL;?>" alt="pizza">
                                <h6><?php echo htmlspecialchars($pizza['title']); ?></h6>
                                <ul class="">
                                    <?php foreach(explode(',', $pizza['ingredients']) as $ing): ?>
                                        <li><?php echo htmlspecialchars($ing); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="">
                                <a class="" href="details.php?id=<?php echo $pizza['id'] ?>">more info</a>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>

            </div>
        </div>

    <?php } ?>
	
 
    <?php include('templates/footer.php'); ?>
