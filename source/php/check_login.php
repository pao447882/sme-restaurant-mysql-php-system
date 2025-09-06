<?php
	session_start();
	
	include "connect_db.php";

	//echo "User Name : ".$_POST["txtUsername"]."<br>";
    //echo "Password : ".$_POST["txtPassword"]."<br>";

	$sql = "SELECT employee_id, emp_name, role, password FROM employee WHERE emp_name = '".trim($_POST['txtUsername'])."' AND password = '".trim($_POST['txtPassword'])."'";
	
	//echo $sql;
	//echo "<br>";

    $sqlQuery = mysqli_query($conn,$sql); 
    $arr_buff = mysqli_fetch_array($sqlQuery);
	
	//echo "buff : ".count($arr_buff)."<br>";

	if (count($arr_buff) > 0) {			
		$_SESSION["Employee_id"] = $arr_buff["employee_id"];
		$_SESSION["Role"] = $arr_buff["role"];
		session_write_close();		

		if($arr_buff["role"] == "admin")
		{
			header("location:../admin_page.php");
		}
		elseif($arr_buff["role"] == "owner")
		{
			header("location:../owner_page.php");
		}
		elseif($arr_buff["role"] == "manager")
		{
			header("location:../manager_page.php");
		}
		else
		{
			header("location:../take_order_page.php");
		}

	} else {
		$_SESSION["Alert"] = "Username and Password Incorrect !!!";	
		session_write_close();		
        header("location:../index.php");
		//echo "Username and Password Incorrect !!!";
	}
	
	mysqli_close($conn);
?>
