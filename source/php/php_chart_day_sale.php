<?php		
	include "connect_db.php";
    // Fetch data from the database
    $sql = "SELECT DISTINCT order_date FROM order_summary ORDER BY order_date ASC LIMIT 15";
    $result = $conn->query($sql);

    // Process the result and prepare data for JSON response
    $date = [];
    $sales = [];

    $cnt = 0;

    if ($result->num_rows > 0) {
        while ($date_row = $result->fetch_assoc()) {

            $date[] = $date_row['order_date'];

            $day_sale = 0;

            $subSql = "SELECT DISTINCT order_id FROM order_summary WHERE order_date = '".$date_row['order_date']."'";
            
            $ObjResult = $conn->query($subSql);

            while ($order_row = $ObjResult->fetch_assoc()) {

                $cal_sql = "SELECT * FROM order_summary WHERE order_id = ".$order_row['order_id'];
                $sqlResult = $conn->query($cal_sql);

                while ($menu_row = $sqlResult->fetch_assoc()) {
                    $item_sale = $menu_row['quantity'] * $menu_row['price'];
                    $day_sale += $item_sale;
                }

            }

            $sales[] = $day_sale;
        }
    }    

    header('Content-Type: application/json');
    echo json_encode(['date' => $date, 'sales' => $sales]);
?>