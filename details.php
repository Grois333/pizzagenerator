<?php 

include('server.php'); 

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

    print_r($pizza);

}


?>




<?php include('templates/header.php'); ?>




<?php include('templates/footer.php'); ?>