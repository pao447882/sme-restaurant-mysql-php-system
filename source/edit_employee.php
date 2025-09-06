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

	if($_SESSION['Role']  == "manager"){

	} else	{
		$_SESSION["Alert"] = "Please Login as Manager !!!";	
        session_write_close();	
		header("location:index.php");
		exit();
	}


	$sql = "SELECT * FROM employee WHERE employee_id = '".$emp_id."'";

	#echo $sql."<br>";

    $result = mysqli_query($conn, $sql);
    $result = mysqli_fetch_array($result);
?>

<html>
<head>
	<title>Edit Employee Data</title>
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
	<h2 class = "page_tag">Edit Employee Data</h2>
	<h4 class="line_cut">----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</h4>

	<div class="inline_menu">
		<ul>
			<li><a href="employee.php">Employee Data</a></li>
		</ul>
	</div>
	<h4 class="line_cut">----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</h4>
	

	<form class = "input_form" name="form1" method="post" action="save_edit_employee.php">
	<table class="table_form" width="400" border="1" style="width: 400px">
	<tbody>
			<tr>
				<td width="125"> &nbsp;Employee ID</td>
				<td width="180"><input name="emp_id" type="text" id="emp_id" value="<?php echo $result["employee_id"];?>" readonly></td>
			</tr>
			<tr>
				<td> &nbsp;Name</td>
				<td><input name="emp_name" type="text" id="emp_name" value="<?php echo $result["emp_name"];?>" readonly></td>
			</tr>
			<tr>
				<td> &nbsp;Role</td>
				<td><input name="txtRole" type="text" id="txtRole" value="<?php echo $result["role"];?>" readonly></td>
			<tr>
				<td> &nbsp;Branch</td>
				<td><input name="branch" type="number" id="branch" value="<?php echo $result["branch"];?>" readonly></td>
			</tr>				
			<tr>
				<td> &nbsp;Salary</td>
				<td><input name="salary" type="number" id="salary" value="<?php echo $result["salary"];?>"></td>
			</tr>		
					
		</tbody>
	</table>	
	<br>
	<input type="submit" name="Submit" value="Save">
	</form>
	
</body>
</html>