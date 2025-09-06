<?php
    include "connect_db.php";

    $order_id = $_POST['order_id'];    

    $sql = "UPDATE order_table SET order_status = 'paid' WHERE order_id = $order_id";

    if ($conn->query($sql) === TRUE) {
        echo "<br><br>Update Order : ".$order_id." : Paid successfully";        
    } else {
        echo "<br>Error Updating Record: " . $conn->error;
    }
?>

