<?php
    include "php/connect_db.php";
?>

<html>
<head>
	<title>Kung Noodle</title>
</head>
<body>

<!-- ยอดขายรายวัน -->
<?php		
	/*
    // Fetch data from the database
    $sql = "SELECT DISTINCT order_date FROM order_summary ORDER BY order_date ASC LIMIT 15";
    $result = $conn->query($sql);

    // Process the result and prepare data for JSON response
    $date = [];
    $sales = [];

    $cnt = 0;

    if ($result->num_rows > 0) {
        while ($date_row = $result->fetch_assoc()) {
            echo $date_row['order_date'];
            echo "<br>";

            $date[] = $date_row['order_date'];
            //$sales[] = $row['amount'];

            $day_sale = 0;

            $subSql = "SELECT DISTINCT order_id FROM order_summary WHERE order_date = '".$date_row['order_date']."'";
            echo $subSql;
            echo "<br>";
            
            $ObjResult = $conn->query($subSql);

            while ($order_row = $ObjResult->fetch_assoc()) {
                echo "ID : ".$order_row['order_id'];
                echo "<br>";

                $cal_sql = "SELECT * FROM order_summary WHERE order_id = ".$order_row['order_id'];
                $sqlResult = $conn->query($cal_sql);

                while ($menu_row = $sqlResult->fetch_assoc()) {
                    /*echo "--->>".$menu_row['menu_id'];
                    echo "<br>";*/
                    /*$item_sale = $menu_row['quantity'] * $menu_row['price'];
                    $day_sale += $item_sale;
                    echo "--->>".$item_sale;
                    echo "<br>";

                }

            }

            echo "<br>";
            echo "Day Sale : ".$day_sale;
            $sales[] = $day_sale;
            //array_push($sales,$day_sale);
            echo "<br>-------------------------------------------<br>";
        }
    }    

    echo count($date);
    echo "<br>";
    echo count($sales);
    // Return the data as JSON
    /*header('Content-Type: application/json');
    echo json_encode(['date' => $date, 'sales' => $sales]);*/
?>

<!-- ยอดขายตามสถานที่ -->
<?php		
	/*
    // Fetch data from the database
    $sql = "SELECT DISTINCT place FROM order_summary";
    $result = $conn->query($sql);

    // Process the result and prepare data for JSON response
    $place = [];
    $sales = [];

    $cnt = 0;

    if ($result->num_rows > 0) {
        while ($place_row = $result->fetch_assoc()) {
            echo $place_row['place'];
            echo "<br>";

            $place[] = $place_row['place'];

            $place_sale = 0;

            $subSql = "SELECT DISTINCT order_id FROM order_summary WHERE place = '".$place_row['place']."'";
            echo $subSql;
            echo "<br>";
            
            $ObjResult = $conn->query($subSql);

            while ($order_row = $ObjResult->fetch_assoc()) {
                echo "ID : ".$order_row['order_id'];
                echo "<br>";

                $cal_sql = "SELECT * FROM order_summary WHERE order_id = ".$order_row['order_id'];
                $sqlResult = $conn->query($cal_sql);

                while ($menu_row = $sqlResult->fetch_assoc()) {
                    echo "--->>".$menu_row['menu_id'];
                    echo "<br>";
                    $item_sale = $menu_row['quantity'] * $menu_row['price'];
                    $place_sale += $item_sale;
                    echo "--->>".$item_sale;
                    echo "<br>";

                }

            }

            echo "<br>";
            echo "Place Sale : ".$place_sale;
            $sales[] = $place_sale;
            //array_push($sales,$day_sale);
            echo "<br>-------------------------------------------<br>";
        }
    }    

    echo count($place);
    echo "<br>";
    echo count($sales);
    // Return the data as JSON
    /*header('Content-Type: application/json');
    echo json_encode(['date' => $date, 'sales' => $sales]);*/
?>

<!-- ยอดขายตามเมนู -->
<?php
		
	include "php/connect_db.php";
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
            echo $menu_title;
            echo "<br>";

            $menu_name[] = $menu_title;

            $menu_sale = $menu_row['price'] * $menu_row['sum_qty'];   
            echo "Sale : ".$menu_sale;    
            echo "<br>-----------------------------------------------";
            echo "<br>";     

            $sales[] = $menu_sale;
        }
    }    

    echo count($menu_name);
    echo "<br>";
    echo count($sales);
    // Return the data as JSON
    /*header('Content-Type: application/json');
    echo json_encode(['date' => $date, 'sales' => $sales]);*/
?>



</body>
</html>