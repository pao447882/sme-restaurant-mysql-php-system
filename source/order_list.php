<?php
	session_start();
	
	include 'php/connect_db.php';

	$user_role = $_SESSION['Role'];
    $emp_id = $_SESSION['Employee_id'];
	
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
	<title>Order List</title>
	<meta http-equiv="Content-Type" Content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="css/main.css">   
    <link rel="stylesheet" href="js/jquery-ui-1.12.1/jquery-ui.css" />
    <script type="text/javascript" src="js/jquery-3.5.1.js"></script>       
    <script type="text/javascript" src="js/jquery-ui-1.12.1/jquery-ui.min.js"></script>
    <style>
        #search_result{
            text-align: center;
        }

		.menu-detail {
			border : 4px solid #909497;
			border-radius: 15px;
			font-size: 20px;
			font-weight : bold;
			text-align: left;            
			width : 300px;
			/*height: 45px;*/
			color: #2980B9; /* Text color */
			margin : 10px;
			padding-left: 25px; /* Adjust padding for spacing */
			padding-top: 10px; /* Adjust padding for spacing */
			padding-bottom: 10px; /* Adjust padding for spacing */
			cursor: pointer;
			background-color: #FDEDEC;
			font-family: sans-serif, Tahoma, Verdana, 'Segoe UI';
			/*font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;*/
		}

		.menu-detail:hover {
			border : 4px solid #E59866;
			background-color: #FCF3CF; /* Background color on hover */
			color: #58D68D ; /* Text color */
		}
        
    </style>
</head>
<body>
	<div class="container" >
		<h3 style="margin-bottom : 12px;">Order List Page </h3>
		Username : <?php echo $emp_name?>	
		<div class="button-container">
			<button class="btn-head" id="btnBack" onclick="location.href='take_order_page.php';"><< Order Page</button>
			<button class="btn-head" id="btnLogout" onclick="location.href='php/logout.php';">Logout</button>			
		</div>
	</div>
	<h4 class="line_cut">----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</h4>
    
	
	<div class="menu">

    <?php
		$check_status = "paid";

		$view_tab = "active_order_".$branch;
		/*echo $view_tab;
		echo "<br>";*/

		$sql = "SELECT DISTINCT(order_id) FROM $view_tab";
		//echo $sql;

		$result = mysqli_query($conn, $sql);

		while ($order = mysqli_fetch_assoc($result)) {
			/*echo "<br>";
			echo $order['order_id'];*/

			$order_id = $order['order_id'];
			$subSQL = "SELECT * FROM $view_tab WHERE order_id = $order_id";
			/*echo "<br>";
			echo $subSQL;*/
			$ObjResult = mysqli_query($conn, $subSQL);

			while ($order_detail = mysqli_fetch_assoc($ObjResult)) { 			
				$url = "order_detail.php?order_id=".strval($order_detail['order_id']) ;
				
				?>

					<span class="menu-detail" onclick="location.href='<?php echo $url; ?>';">
						<?php
							echo "Order # ".$order_detail['order_id'];
							echo "<br>Date : ".$order_detail['order_date'];
							echo " ".$order_detail['order_time'];
							echo "<br>Place : ".$order_detail['place'];
							echo "<br>Status : ".$order_detail['order_status'];
							echo "<br>Staff : ".$order_detail['emp_name'];							
						?>
					</span>								
		<?php		
			}
		}?>
	</div>

</body>
</html>