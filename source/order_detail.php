<?php
	session_start();
	
	include 'php/connect_db.php';

	$user_role = $_SESSION['Role'];
    $emp_id = $_SESSION['Employee_id'];    
  
	$order_id = $_GET["order_id"];

	function phpAlert($msg) {
        echo '<script type="text/javascript">alert("' . $msg . '")</script>';
    }

    if($_SESSION['Role'] == "") {
        #$alert_msg = "Please Login !!!";
		#phpAlert($alert_msg);
		$_SESSION["Alert"] = "Please Login !!!";	
        session_write_close();	
		header("location:index.php");
		exit();
    }

    if($_SESSION['Employee_id'] == "") {
        #$alert_msg = "Please Login !!!";
		#phpAlert($alert_msg);
		$_SESSION["Alert"] = "Please Login !!!";	
        session_write_close();	
		header("location:index.php");
		exit();
    }	
	
	$sql = "SELECT * FROM employee WHERE employee_id = '".$_SESSION["Employee_id"]."' ";
	$sqlQuery = mysqli_query($conn, $sql);

	$objResult = mysqli_fetch_array($sqlQuery);
	$emp_name = $objResult["emp_name"];
	$user_role = $objResult["role"];
    $branch = $objResult["branch"];
?>

<html>
<head>
	<title>Order Detail</title>
	<meta http-equiv="Content-Type" Content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="css/main.css">   
    <link rel="stylesheet" href="js/jquery-ui-1.12.1/jquery-ui.css" />
    <script type="text/javascript" src="js/jquery-3.5.1.js"></script>       
    <script type="text/javascript" src="js/jquery-ui-1.12.1/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/script_update_order.js"></script>
	<style>
		.menu-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .menu-table th, .menu-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .menu-table th {
            background-color: #4CAF50;
            color: white;
        }

        .menu-table input {
            width: 40px;
            text-align: center;
        }

        button {
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .order-summary {
            display: none;
            margin-top: 20px;
			/*display: flex;*/
			flex-direction: column; 
			align-items: center;
        }

	</style>
</head>
<body>
	<div class="container">
		<h3 style="margin-bottom : 12px;">Order Detail Page </h3>
		Username : <?php echo $emp_name?>	
		<div class="button-container">
			<button class="btn-head" id="btnBack" onclick="location.href='take_order_page.php';"><< Order Page</button>
            <button class="btn-head" id="btnBack" onclick="location.href='order_list.php';"><< Order List</button>
			<button class="btn-head" id="btnLogout" onclick="location.href='php/logout.php';">Logout</button>			
		</div>
	</div>
	<h4 class="line_cut">----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</h4>
    <?php
        
		
    ?>

	<div id="menu_container" class="container">


	<?php
		//echo "Order ID : ".$order_id;
		$sql = "SELECT * FROM order_table  WHERE order_id = ".$order_id;
		//echo $sql;
		$result = mysqli_query($conn, $sql);  
		
		$order_detail =  mysqli_fetch_array($result);

		echo "Order # ".$order_detail['order_id'];
		echo "<br>Order Date : ".$order_detail['order_date'];
		echo " ".$order_detail['order_time'];
		echo "<br>Place : ".$order_detail['place'];
		echo "<br><br>";	

		$sql = "SELECT * FROM order_detail LEFT JOIN menu USING (menu_id) WHERE order_id = ".$order_id;
		//echo $sql;
		$result = mysqli_query($conn, $sql);    
    	$cnt = 0;
	?>	

	<div id="order-summary" class="menu_list">
		<table class="menu-table">
			<thead>
				<tr>
					<th style="width:20px">#</th>	
					<th style="width:180px">Menu Name</th>					
					<th style="width:45px">Qty</th>
					<th style="width:80px">Remark</th>
				</tr>
			</thead>
			<tbody id="menu-body">
				<?php while ($menu = mysqli_fetch_assoc($result)) { $cnt += 1; ?>				
					<tr>
						<td><?php echo $cnt; ?></td>
						<td><?php echo $menu['menu_name']; ?></td>
						<td><input type="number" id="quantity<?php echo $cnt; ?>" name="quantity[]" value="<?php echo $menu['quantity']; ?>" min="0" readonly></td>
						<td><textarea id="remark<?php echo $cnt; ?>"name="remark[]" rows="1" cols="15" value = "<?php echo $menu['description']; ?>"></textarea></td>
					</tr>				
				<?php } ?>

			</tbody>
		</table>
	</div>	
	<button id="btnSumOrder" onclick="SumOrder()">Summary</button>
	</div>
	<div class="container">
		<div class="order-update" id="order-update">
			<!--<h2 style="margin : 0px;">Order Update</h2>
			<ul id="update-list" style="margin : 0px; margin-top : 12px;"></ul>	-->		
		</div>
	</div>

	<script>
		var order_id = <?php echo $order_id;?>;
				

		function SumOrder() {
			 // Send data to the server for saving
			 $.ajax({
                    url: 'php/php_cal_order_sum.php', // Replace with the actual path to your server-side script for saving
                    method: 'POST',
                    data: { order_id: order_id },
                    success: function(data) {
                        //console.log(data);
                        // You can handle the response as needed
                        //alert(response);
                        $("#menu_container").html(data);
                    }
                });
		}

		function PayOrder() {
			 // Send data to the server for saving
			 $.ajax({
                    url: 'php/save_paid_order.php', // Replace with the actual path to your server-side script for saving
                    method: 'POST',
                    data: { order_id: order_id },
                    success: function(data) {
                        //console.log(response);
                        // You can handle the response as needed
                        //alert(response);
                        $("#order-update").html(data);
                    }
                });
		}

	</script>

</body>
</html>