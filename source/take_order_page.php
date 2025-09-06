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
	<title>Order Page</title>
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
		<h3 style="margin-bottom : 12px;">Take Order Page !!! </h3>
		Username : <?php echo $emp_name?>	
		<div class="button-container">        
			<?php
				if($_SESSION['Role'] == "admin") {                     
					$dest = "'admin_page.php'";
					echo '<button class="btn-head" onclick="location.href='.$dest.';"><< Admin Page</button>';	    

				}
				if($_SESSION['Role'] == "owner") {
					$dest = "'owner_page.php'";
					echo '<button class="btn-head" onclick="location.href='.$dest.';"><< Owner Page</button>';	
				}
				if($_SESSION['Role'] == "manager") {
					$dest = "'manager_page.php'";
					echo '<button class="btn-head" onclick="location.href='.$dest.';"><< Manager Page</button>';	
				}
			?>

			<button class="btn-head" id="btnLogout" onclick="location.href='php/logout.php';">Logout</button>			
		</div>			
	</div>

	<h4 class="line_cut">----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</h4>
	
    <div class="menu">
        <span class="menu-item"><a href="new_order.php">New Order</a></span>
        <span class="menu-item"><a href="order_list.php">Order List</a></span>
    </div>

</body>
</html>