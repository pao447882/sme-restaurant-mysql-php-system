<?php
	session_start();
	
	include 'php/connect_db.php';  

    $user_role = $_SESSION['Role'];
    $emp_id = $_SESSION['Employee_id'];

    /*echo "Session : ".$user_role;
    echo "<br>";
    echo "ID : ".$emp_id;*/

    function phpAlert($msg) {
        //echo '<script type="text/javascript">alert("' . $msg . '")</script>';
    }

    if(trim($_POST["ingd_name"]) == "") {
        //phpAlert("Please input Username!");
        $_SESSION["Alert"] = "Please input Ingredient Name !!!";	
        session_write_close();		
        header("location:ingredient_page.php");
        exit();	
    }
        
    if(trim($_POST["ingd_cost"]) == "") {
        //phpAlert("Please input Password!");
        $_SESSION["Alert"] = "Please input Cost Per Unit !!!";
        session_write_close();		
        header("location:ingredient_page.php");
        exit();	
    }	
    
    echo "Add New Ingredient Item";
	echo "<br>Add By Employee ID : ".$emp_id;
    echo "<br>New Ingredient ID : ".trim($_POST['ingd_id']);
	echo "<br>Add Ingredient : ".trim($_POST['ingd_name']);
	echo "<br>Unit : ".trim($_POST['ingd_unit']);
	echo "<br>Cost Per Unit : ".trim($__POST['ingd_cost']);
	echo "<br>";
	
	$sql = "SELECT * FROM ingredient WHERE ingredient_id = ".trim($_POST['ingd_id']);

	//echo $sql;

	echo "<br>";
	$sqlQuery = mysqli_query($conn,$sql);
    $arr_buff = mysqli_fetch_array($sqlQuery);
    
    if (count($arr_buff) > 0) {
        echo "Ingredient ID : ".$_POST['ingd_id']." Already Existed !!!!";         

    } else {
        echo "New User Account<br>";

        $values = "('".trim($_POST['ingd_name'])."','".trim($_POST['ingd_unit'])."','".trim($_POST['ingd_cost'])."',".$emp_id.", now())";
        //echo "<br>Values : ".$values;
        $sql = "INSERT INTO ingredient (ingredient_name, unit, cost_per_unit, employee_id, update_time) VALUES ".$values;
        echo "<br>SQL : ".$sql;
        
        if ($conn->query($sql) === TRUE) {
            echo "<br>INSERT New Ingredient : ".$_POST['ingd_name']." successfully";
        } else {
            echo "<br>Error Inserting Record: " . $conn->error;
        }
    }

    mysqli_close($conn);

    if($user_role == "admin" || $user_role == "owner" || $user_role == "manager")
	{
		echo "<br><br> Go To <a href='ingredient_page.php'>Ingredient Page</a>";
	}   
	else
	{  
		session_start();
	    session_destroy();
	    header("location:index.php");
	}


  
	

?>