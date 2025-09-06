<?php
	session_start();

	$user_role = $_SESSION['Role'];
    $emp_id = $_SESSION['Employee_id'];

	include 'php/connect_db.php';
	
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
	<title>New Order</title>
	<meta http-equiv="Content-Type" Content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="css/main.css">   
    <link rel="stylesheet" href="js/jquery-ui-1.12.1/jquery-ui.css" />
    <script type="text/javascript" src="js/jquery-3.5.1.js"></script>       
    <script type="text/javascript" src="js/jquery-ui-1.12.1/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/script_new_order.js"></script>
	<script>
		var emp_id = <?php echo $emp_id; ?>;
	</script>
    <style>
		/* Add your styles here */
		body {
			font-family: 'Arial', sans-serif;
			margin: 0;
			padding: 0;
			/*display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
			background-color: #f4f4f4;*/
		}

        #search_result{
            text-align: center;
        }

		.dropdown {
    		position: relative;
		}

		select {
			appearance: none;
			-webkit-appearance: none;
			-moz-appearance: none;
			width: 200px;
			padding: 10px;
			font-size: 16px;
			border: 1px solid #ccc;
			border-radius: 5px;
			outline: none;
			cursor: pointer;
			background-color: #fff;
		}

		select:hover {
			border-color: #aaa;
		}

		select:focus {
			border-color: #4CAF50;
			box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
		}

		/* Style the arrow */
		select::after {
			content: '\25BC'; /* Unicode character for down arrow ▼ */
			position: absolute;
			top: 50%;
			right: 10px;
			transform: translateY(-50%);
			color: #555;
		}

		/* Style the options */
		option {
			background-color: #fff;
			color: #555;
		}

		option:hover {
			background-color: #eee;
		}			
		
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
			text-align: center;
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

        ul {
			font-size : 22px;
            list-style: none;
            padding: 0;
			display: flex;
            flex-direction: column;
            align-items: center;
        }

        li {
			font-size : 18px;
            margin-bottom: 5px;
        }

		

    </style>
</head>
<body>
	<div class="container" >
		<h3 style="margin-bottom : 12px;">This is New Order Page !!! </h3>
		Username : <?php echo $emp_name?>	
		<div class="button-container">
			<button class="btn-head" id="btnBack" onclick="location.href='take_order_page.php';"><< Order Page</button>
			<button class="btn-head" id="btnLogout" onclick="location.href='php/logout.php';">Logout</button>			
		</div>
	</div>
	<h4 class="line_cut">----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</h4>
    
    <?php
		$sql = "SELECT * FROM menu WHERE branch_available = ".$branch;
		//echo $sql;
		$result = mysqli_query($conn, $sql);    
    	$cnt = 0;
    ?>


	<div id="menu_container" class="container">
		<div class="dropdown">
			<select id="txtPlace" name="txtPlace">
				<option value="" disabled selected>Select Place</option>
				<option value="eat in" >Eat In</option>
				<option value="take away">Take Away</option>
				<option value="rider">Rider</option>
			</select>
		</div>
		<br>

		<div class="menu_list">
		<table class="menu-table">
			<thead>
				<tr>
					<th style="width:20px">ID</th>	
					<th style="width:180px">Menu Name</th>					
					<th style="width:45px">Qty</th>
					<th style="width:40px">Extra</th>
					<th style="width:80px">Remark</th>
				</tr>
			</thead>
			<tbody id="menu-body">
				<?php while ($menu = mysqli_fetch_assoc($result)) {  ?>				
					<tr>
						<td><?php echo $menu['menu_id']; ?></td>
						<td><?php echo $menu['menu_name']; ?></td>
						<td><input type="number" id="quantity<?php echo $cnt; ?>" name="quantity[]" value="0" min="0"></td>
						<td><input type="checkbox" id="extra<?php echo $cnt; ?>" name="extra[]"></td>
						<td><textarea id="remark<?php echo $cnt; ?>"name="remark[]" rows="1" cols="15"></textarea></td>
					</tr>
					
				
				<?php $cnt += 1;} ?>

			</tbody>
		</table>

		</div>

		<button id="btnCheckout" onclick="submitOrder()">Checkout</button>
	</div>
	<div class="container">
		<div class="order-summary" id="order-summary">
			<h2 style="margin : 0px;">Order Summary</h2>
			<ul id="summary-list" style="margin : 0px; margin-top : 12px;"></ul>			
		</div>	
	</div>
	
</body>
</html>