<?php		
	include "php/connect_db.php";
?>


<html>
<head>
	<title>Kung Noodle</title>
</head>
<body>


<?php		
	include "php/connect_db.php";
    // Fetch data from the database
    $sql = "SELECT DISTINCT order_date FROM order_data ORDER BY order_date DESC LIMIT 15";
    $result = $conn->query($sql);

    // Process the result and prepare data for JSON response
    $date = [];
    $sales = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo $row['order_date'];
            echo "<br>";

            $date[] = $row['order_date'];
            //$sales[] = $row['amount'];

            $day_sale;

            $subSql = "SELECT * FROM order_data WHERE order_date = '".$row['order_date']."'";
            echo $subSql;
            echo "<br>";
            



        }
    }    

    // Return the data as JSON
    /*header('Content-Type: application/json');
    echo json_encode(['date' => $date, 'sales' => $sales]);*/
?>

</body>
</html>