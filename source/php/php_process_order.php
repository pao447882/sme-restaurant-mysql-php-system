<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Process the form data (validate and save to database, for example)

        $menu_id = $_POST['menu_id'];
        $quantity = $_POST['quantity'];
        $descripton = $_POST['description'];

        // Here, you would typically save the order to the database and get the order ID
        // For demonstration purposes, we're just creating a simple message
        $orderItem = "Order (ID: $menu_id, Qty :  $quantity, Desc :  $descripton)";

        $response = array('message' => 'Order added successfully!', 'orderItem' => $orderItem);

        echo json_encode($response);
    } else {
        // Handle non-POST requests
        http_response_code(405); // Method Not Allowed
        echo json_encode(array('message' => 'Method Not Allowed'));
    }
?>