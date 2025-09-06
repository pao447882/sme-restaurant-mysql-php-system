<?php
	session_start();
	
	include 'php/connect_db.php';

    $emp_id = trim($_POST['emp_id']);

    function phpAlert($msg) {
        //echo '<script type="text/javascript">alert("' . $msg . '")</script>';
    }

    if(trim($_POST["salary"]) == "") {
        $_SESSION["Alert"] = "Please input Employee Firstname !!!";	
        $_SESSION["return_emp_id"] = $emp_id;
        session_write_close();		
        header("location:edit_employee.php");
        exit();	
    }       
                
	echo "Employee ID : ".trim($_POST['emp_id']);
	echo "<br>Employee Name : ".trim($_POST['emp_name']);
	echo "<br>Role : ".trim($_POST['txtRole']);
    echo "<br>Branch : ".trim($_POST['branch']);
    echo "<br>Salary : ".trim($_POST['salary']);
	echo "<br>";
	
	$sql = "UPDATE employee SET salary = ".trim($_POST['salary'])." WHERE employee_id = ".$_POST['emp_id'];
    //echo "<br>".$sql;

    if ($conn->query($sql) === TRUE) {
        echo "<br>Update Account : ".$_POST['username']." successfully";
    } else {
        echo "<br>Error Updating Record: " . $conn->error;
    }

    
    mysqli_close($conn);
    echo "<br> Go To ";

    if($_SESSION['Role'] == "manager") {               
        echo '<a href="employee.php">Employee Page</a>';
    }
	else
	{
		session_start();
	    session_destroy();
	    header("location:index.php");
	}

?>