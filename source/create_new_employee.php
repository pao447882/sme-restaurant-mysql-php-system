<?php
	session_start();
	
	include 'php/connect_db.php';
	
	if($_SESSION['Employee_id'] == "")
	{
		echo "Please Login!";
		exit();
	}	

	if($_SESSION['Role']  == "admin" || $_SESSION['Role'] == "owner"){

	} else	{
		$_SESSION["Alert"] = "Please Login as Admin !!!";	
        session_write_close();	
		header("location:index.php");
		exit();
	}	
	
?>

<html>
<head>
<title>Create New Employee Profile</title>
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
	<div class="container" >
		<h3 style="margin-bottom : 12px;">Create New Account</h3>
		<div class="button-container">			
			<button class="btn-head" onclick="location.href='employee_account.php';"><< Employee & Account Page</button>			
		</div>
	</div>	
	
	<h4 class="line_cut">----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</h4>
	
	<div style = "text-align : center;">
	<form class = "input_form" name="form1" method="post" action="save_edit_account.php">
	<table class="table_form" width="400" border="1" style="width: 400px">
		<tbody>
			<tr>
				<td width="125"> &nbsp;Next UserID</td>				
				<?php 
					$sql = "SELECT MAX(employee_id) FROM employee";	
					$sqlQuery = mysqli_query($conn, $sql);
					$objResult = mysqli_fetch_array($sqlQuery);
					
					$new_emp_id = $objResult[0] + 1;
				
				?>
				<td width="180"><input name="emp_id" type="text" id="emp_id" value="<?php echo $new_emp_id;?>" readonly></td>
			</tr>
			<tr>
				<td> &nbsp;Name</td>
				<td><input name="emp_name" type="text" id="emp_name" value="" placeholder="Employee Name"></td>
			</tr>
			<tr>
				<td> &nbsp;Role</td>
				<td>
					<select id="txtRole" name="txtRole" value="">
						<option value="admin">admin</option>
						<option value="owner">owner</option>
						<option value="manager">manager</option>
						<option value="staff">staff</option>
					</select></td>
			</tr>
			<tr>
				<td> &nbsp;Branch</td>
				<td><input name="branch" type="number" id="branch" value="" placeholder="Branch"></td>
			</tr>				
			<tr>
				<td> &nbsp;Salary</td>
				<td><input name="salary" type="number" id="salary" value="" placeholder="Salary"></td>
			</tr>
			<tr>
				<td> &nbsp;Password</td>
				<td><input name="txtPassword" type="password" id="txtPassword" value="" placeholder="Password"></td>
			</tr>
			<tr>
				<td> &nbsp;Confirm Password</td>
				<td><input name="txtConPassword" type="password" id="txtConPassword" value="" placeholder="Confirm Password"></td>
			</tr>
		</tbody>
	</table>
	<br>
	<input type="submit" name="Submit" value="Save">
	</form>
</body>
</html>