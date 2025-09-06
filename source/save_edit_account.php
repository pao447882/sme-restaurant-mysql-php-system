<?php
	session_start();
	
	include 'php/connect_db.php';

    $emp_id = trim($_POST['emp_id']);

    function phpAlert($msg) {
        //echo '<script type="text/javascript">alert("' . $msg . '")</script>';
    }

    if(trim($_POST["emp_name"]) == "") {
        //phpAlert("Please input Username!");
        $_SESSION["Alert"] = "Please input Employee Name !!!";	
        $_SESSION["return_emp_id"] = $emp_id;
        session_write_close();		
        header("location:edit_user_account.php");
        exit();	
    }
        
    if(trim($_POST["txtPassword"]) == "") {
        //phpAlert("Please input Password!");
        $_SESSION["Alert"] = "Please input Password !!!";
        $_SESSION["return_emp_id"] = $emp_id;	
        session_write_close();		
        header("location:edit_user_account.php");
        exit();	
    }	
        
    if($_POST["txtPassword"] != $_POST["txtConPassword"]) {
        //phpAlert("Password not Match!");
        $_SESSION["Alert"] = "Password not Match !!!";	
        $_SESSION["return_emp_id"] = $emp_id;
        session_write_close();		
        header("location:edit_user_account.php");
        exit();
    }
    
    if(trim($_POST["txtRole"]) == "") {
        //phpAlert("Please input Role!");
        $_SESSION["Alert"] = "Please input Role !!!";
        $_SESSION["return_emp_id"] = $emp_id;	
        session_write_close();		
        header("location:edit_user_account.php");
        exit();	
    }	

    /*** 
    $_SESSION["Alert"] = "Username and Password Incorrect !!!";	
    session_write_close();		
    header("location:../index.php");
    */

	echo "Employee ID : ".trim($_POST['emp_id']);
	echo "<br>Employee Name : ".trim($_POST['emp_name']);
	echo "<br>Password : ".trim($_POST['txtPassword']);
	echo "<br>Role : ".trim($_POST['txtRole']);
    echo "<br>Branch : ".trim($_POST['branch']);
    echo "<br>Salary : ".trim($_POST['salary']);
	echo "<br>";
	
	$sql = "SELECT * FROM employee WHERE employee_id = ".$_POST['emp_id'];

	echo $sql;

	echo "<br>";
	$sqlQuery = mysqli_query($conn,$sql);
    $arr_buff = mysqli_fetch_array($sqlQuery);
    
    if (count($arr_buff) > 0) {
        echo "Employee ID : ".$_POST['emp_id']." Already Existed.";
        $sql = "UPDATE employee SET emp_name = '".trim($_POST['emp_name'])."', password = '".trim($_POST['txtPassword'])."', role = '".trim($_POST['txtRole'])."' WHERE employee_id = ".$_POST['emp_id'];
        echo "<br>".$sql;

        if ($conn->query($sql) === TRUE) {
            echo "<br>Update Account : ".$_POST['emp_name']." successfully";
        } else {
            echo "<br>Error Updating Record: " . $conn->error;
        }
    } else {
        echo "New User Account<br>";

        $values = "(".trim($_POST['emp_id']).",'".trim($_POST['emp_name'])."','".trim($_POST['txtRole'])."',".trim($_POST['branch']).",".trim($_POST['salary']).",'".trim($_POST['txtPassword'])."')";
        //echo "<br>Values : ".$values;
        $sql = "INSERT INTO employee (employee_id, emp_name, role, branch, salary, password) VALUES ".$values;
        echo "<br>SQL : ".$sql;
        
        if ($conn->query($sql) === TRUE) {
            echo "<br>INSERT New Account : ".$_POST['emp_name']." successfully";
        } else {
            echo "<br>Error Inserting Record: " . $conn->error;
        }
    }

    mysqli_close($conn);

    if($_SESSION['Role'] == "admin")
	{
		echo "<br> Go To <a href='employee_account.php'>Employee & Account Page</a>";
	}
    if($_SESSION['Role'] == "owner")
	{
		echo "<br> Go To <a href='employee_account.php'>Employee & Account Page</a>";
	}
	else
	{
		session_start();
	    session_destroy();
	    header("location:index.php");
	}

?>