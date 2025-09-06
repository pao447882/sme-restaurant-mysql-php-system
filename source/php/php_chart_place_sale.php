<?php		
	include "connect_db.php";
    // Fetch data from the database
    $sql = "SELECT DISTINCT place FROM order_summary";
    $result = $conn->query($sql);

    // Process the result and prepare data for JSON response   
    $data = array();

    $cnt = 0;

    if ($result->num_rows > 0) {
        while ($place_row = $result->fetch_assoc()) {                    

            $place_sale = 0;

            $subSql = "SELECT DISTINCT order_id FROM order_summary WHERE place = '".$place_row['place']."'";
          
            
            $ObjResult = $conn->query($subSql);

            while ($order_row = $ObjResult->fetch_assoc()) {

                $cal_sql = "SELECT * FROM order_summary WHERE order_id = ".$order_row['order_id'];
                $sqlResult = $conn->query($cal_sql);

                while ($menu_row = $sqlResult->fetch_assoc()) {
                    $item_sale = $menu_row['quantity'] * $menu_row['price'];
                    $place_sale += $item_sale;
                }

            }


            if($place_row['place'] == ""){
                $data[] = [
                    'place' => "Others",
                    'sales' => $place_sale
                ];
            } else {
                $data[] = [
                    'place' => $place_row['place'],
                    'sales' => $place_sale
                ];
            }

        }
    }    

    
    header('Content-Type: application/json');
    echo json_encode($data);
?>