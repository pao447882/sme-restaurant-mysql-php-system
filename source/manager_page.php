<?php
	session_start();
	
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

	if($_SESSION['Role'] != "manager") {
        #$alert_msg = "This page for Manager !!!";
		$_SESSION["Alert"] = "This page for Manager only !!!";	
        session_write_close();	
		#phpAlert($alert_msg);	
		header("location:index.php");
		exit();
    }
	
	$sql = "SELECT * FROM employee WHERE employee_id = '".$_SESSION["Employee_id"]."' ";
	$sqlQuery = mysqli_query($conn, $sql);

	$objResult = mysqli_fetch_array($sqlQuery);
	$emp_name = $objResult["emp_name"];
	$user_role = $objResult["role"];
?>
<html>
<head>
	<title>Manager Page Test ver 1.0</title>
	<meta http-equiv="Content-Type" Content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="css/main.css">   
    <link rel="stylesheet" href="js/jquery-ui-1.12.1/jquery-ui.css" />
    <script type="text/javascript" src="js/jquery-3.5.1.js"></script>       
    <script type="text/javascript" src="js/jquery-ui-1.12.1/jquery-ui.min.js"></script>
    <style>
        #search_result{
            text-align: center;
        }

    </style>
</head>
<body>
	<div class="container" >
		<h3 style="margin-bottom : 12px;">Manager Page !!! </h3>
		Username : <?php echo $emp_name?>	
		<div class="button-container">
			<button class="btn-head" id="btnLogout" onclick="location.href='php/logout.php';">Logout</button>			
		</div>
	</div>
	<h4 class="line_cut">----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</h4>
	
	<div class="inline_menu">
		<ul>
			<li class="menu-li"><a href="employee.php">Employee</a></li>
			<li class="menu-li"><a href="menu_list_edit.php">Menu List</a></li>
			<li class="menu-li"><a href="ingredient_page.php">Ingredient</a></li>	
			<li class="menu-li"><a href="sale_summary_page.php">Sale Summary</a></li>
			<li class="menu-li"><a href="take_order_page.php">Order Page</a></li>
		</ul>
	</div>
</body>
</html>