<?php
    include "connect_db.php";
    
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the raw POST data
        $postData = file_get_contents('php://input');
        //echo "Get Data";
        // Decode the JSON data
        $requestData = json_decode($postData, true);

        $orderData = $requestData['orderData'];
        $orderDetail = $requestData['orderDetail'];

        // Process and save the order data to the database
        saveOrderToDatabase($orderData, $orderDetail);

        // Respond to the client
        /*$response = ['message' => $orderData];   
        echo json_encode($response);*/
        
        
    } else {
        http_response_code(405); // Method Not Allowed
        $response = ['error' => 'Invalid request method'];
        echo json_encode($response);
    }

    function saveOrderToDatabase($orderData, $orderDetail) {    
        include "connect_db.php";
       

        // add order detail in order database
        foreach ($orderDetail as $detailItem) {
            $employee_id = $detailItem['EmpID'];
            $place = $detailItem['Place'];
            $status = "serving";      
            
            $msg;
            
            $values = "(curdate(), curtime(), '".$place."','".$status."',".$employee_id.", now())";
            $sql = "INSERT INTO order_table (order_date, order_time, place, order_status, employee_id, update_time) VALUES".$values;
           
            if ($conn->query($sql) === TRUE) {
                //$msg = "Add New Order :  successfully";
            } else {
                //$msg = "Error Adding New Order: " . $conn->error;
            }
                    
            /*$response = ['message' =>  $msg];  
            echo json_encode($response);*/
        }

        $sql = "SELECT max(order_id) FROM order_table";
        $sqlQuery = mysqli_query($conn, $sql);
		$objResult = mysqli_fetch_array($sqlQuery);
					
		$order_id = $objResult[0];
    
        // Assuming you have a table named "orders" with columns "item", "description", and "quantity"
        $msg_out;

        foreach ($orderData as $orderItem) {
            $menu_id = $orderItem['item_id'];
            $description = $orderItem['extra']." - ".$orderItem['remark'];
            $quantity = $orderItem['quantity'];            
    
            // Insert data into the "orders" table
            $sql = "INSERT INTO order_detail (order_id , menu_id, description, quantity) VALUES ($order_id, $menu_id, '$description', $quantity)";
            
            $msg_out = $sql;

            if ($conn->query($sql) !== TRUE) {
                $response = ['error' => 'Error saving order to the database'];
                echo json_encode($response);
                die();
            }
        }

        $response = ['message' => $msg_out];
        echo json_encode($response);
    
    }


?>
