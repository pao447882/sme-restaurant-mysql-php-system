<?php
	session_start();
	
	include 'php/connect_db.php';

	$emp_id = $_GET["edit_id"];
	echo "Employee ID : ".$emp_id;

    function phpAlert($msg) {
        echo '<script type="text/javascript">alert("' . $msg . '")</script>';
    }

    if($_SESSION['Alert'] != "") {
        $alert_msg = $_SESSION['Alert'];
		phpAlert($alert_msg);

		$emp_id = $_SESSION["return_emp_id"];
        $_SESSION['Alert'] = "";

    }
	
	if($_SESSION['Employee_id'] == "")
	{
		echo "Please Login!";
		exit();
	}	

	if($_SESSION['Role']  == "admin" || $_SESSION['Role'] == "owner"){

	} else	{
		$_SESSION["Alert"] = "Please Login as Admin or Owner !!!";	
        session_write_close();	
		header("location:index.php");
		exit();
	}	
	

	//echo "Role : ".$_SESSION['Role'];
	
	$sql = "SELECT * FROM employee WHERE employee_id = '".$emp_id."'";

	#echo $sql."<br>";

    $result = mysqli_query($conn, $sql);
    $result = mysqli_fetch_array($result);
?>

<html>
<head>
	<title>Edit Employee Account</title>
	<meta http-equiv="Content-Type" Content="text/html; charset=utf-8">
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
	<br>
	<h2 class = "page_tag">Edit Employee Account</h2>
	<h4 class="line_cut">----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</h4>
	
	<div class="inline_menu">
		<ul>
			<li><a href="employee_account.php">Employee & Account</a></li>
		</ul>
	</div>
	
	<h4 class="line_cut">----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</h4>
	
	<form class = "input_form" name="form1" method="post" action="save_edit_account.php">
	<h4 style = "text-align : center;">Employee Data</h4>
	<table class="table_form" width="400" border="1" style="width: 400px">
		<tbody>
			<tr>
				<td width="125"> &nbsp;Employee ID</td>
				<td width="180"><input name="emp_id" type="text" id="emp_id" value="<?php echo $result["employee_id"];?>" readonly></td>
			</tr>
			<tr>
				<td> &nbsp;Name</td>
				<td><input name="emp_name" type="text" id="emp_name" value="<?php echo $result["emp_name"];?>"></td>
			</tr>
			<tr>
				<td> &nbsp;Role</td>
				<td>
					<select id="txtRole" name="txtRole" value="">
						<option value="admin" <?php if($result["role"] == 'admin') echo 'selected="selected"';?>>admin</option>
						<option value="owner" <?php if($result["role"] == 'owner') echo 'selected="selected"';?>>owner</option>
						<option value="manager" <?php if($result["role"] == 'manager') echo 'selected="selected"';?>>manager</option>
						<option value="staff" <?php if($result["role"] == 'staff') echo 'selected="selected"';?>>staff</option>
					</select></td>
			</tr>
			<tr>
				<td> &nbsp;Branch</td>
				<td><input name="branch" type="number" id="branch" value="<?php echo $result["branch"];?>"></td>
			</tr>				
			<tr>
				<td> &nbsp;Salary</td>
				<td><input name="salary" type="number" id="salary" value="<?php echo $result["salary"];?>"></td>
			</tr>
			<tr>
				<td> &nbsp;Password</td>
				<td><input name="txtPassword" type="password" id="txtPassword" value="<?php echo $result["password"];?>"></td>
			</tr>
			<tr>
				<td> &nbsp;Confirm Password</td>
				<td><input name="txtConPassword" type="password" id="txtConPassword" value="<?php echo $result["password"];?>"></td>
			</tr>
					
		</tbody>
	</table>	
	<br>
	<input type="submit" name="Submit" value="Save">
	</form>
</body>
</html>