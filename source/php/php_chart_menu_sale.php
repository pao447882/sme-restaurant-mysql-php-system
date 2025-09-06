<?php		
	include "connect_db.php";
   // Fetch data from the database
   $sql = "SELECT menu_id,menu_name, sum(quantity) AS sum_qty , price FROM order_summary GROUP BY menu_id";
   $result = $conn->query($sql);

   // Process the result and prepare data for JSON response
   $menu_name = [];
   $sales = [];

   $cnt = 0;

   if ($result->num_rows > 0) {
       while ($menu_row = $result->fetch_assoc()) {
           $menu_title = "ID : ".$menu_row['menu_id']." ".$menu_row['menu_name'];
           //$menu_title = $menu_row['menu_name'];

           $menu_name[] = $menu_title;

           $menu_sale = $menu_row['price'] * $menu_row['sum_qty'];   

           $sales[] = $menu_sale;
       }
   }    

   header('Content-Type: application/json');
   echo json_encode(['menu_name' => $menu_name, 'sales' => $sales]);
?>