<?php
	session_start();
	
	include 'connect_db.php';

    $user_role = $_SESSION['Role'];
    $emp_id = $_SESSION['Employee_id'];

    /*echo "Session : ".$_SESSION['Role'];
    echo "<br>";
    echo "ID : ".$_SESSION['Employee_id'];*/

    // Variable to store the alert message
    $alertMessage = '';

    function phpAlert($msg) {
        //echo '<script type="text/javascript">alert("' . $msg . '")</script>';
    }

    /*echo "Menu Data : ".($_POST['menu_data']);
    echo "<br>";
    echo "Ingd Data : ".($_POST['ingd_data']);*/

    $menu_data_arr = $_POST['menu_data'];
    //$ingd_data_arr = $_POST['ingd_data'];

    $ingd_data_arr = json_decode($_POST['ingd_data'], true);

    /*echo "Menu ID : ".$menu_data_arr[0];
    echo "Menu Name : ".$menu_data_arr[1];
    echo "Menu Price : ".$menu_data_arr[2];
    echo "Branch Avai : ".$menu_data_arr[3];*/

    $values = "('".$menu_data_arr[1]."',".$menu_data_arr[2].",".$menu_data_arr[3].",".$emp_id.", now())";

    $sql = "INSERT INTO menu (menu_name, price, branch_available, employee_id, update_time) VALUES".$values;
    //echo "  ".$sql;
    
    if ($conn->query($sql) === TRUE) {
        //echo "<br>INSERT New Menu : ".$menu_data_arr[1]." successfully";
    } else {
        $alertMessage = "<br>Error Inserting Record: " . $conn->error;
        exit();
    }

    foreach($ingd_data_arr as $ingd){
        $ingd_id = $conn->real_escape_string($ingd['ingd_id']);
        $ingd_unit = $conn->real_escape_string($ingd['ingd_unit']);
        $ingd_amount = $conn->real_escape_string($ingd['ingd_amount']);        
        
        /*echo "Ingd ID : ".$ingd_id;
        echo "Ingd Unit : ".$ingd_unit;
        echo "Ingd Amount : ".$ingd_amount;   */
        
        $values = "(".$menu_data_arr[0].",".$ingd_id.",".$ingd_amount.",'".$ingd_unit."')";

        $sql = "INSERT INTO recipe (menu_id, ingredient_id, amount, unit) VALUES".$values;
        //echo "  ".$sql;
        
        if ($conn->query($sql) === TRUE) {
            //echo "<br>INSERT New Recipe Row : ".$menu_data_arr[0]."  ".$ingd_id." successfully";
        } else {
            $alertMessage = "<br>Error Inserting Record: " . $conn->error;
            exit();
        }

    }

   // Set the success message
    //$alertMessage = "<br>Recipe saved successfully!";

    echo "Recipe saved successfully !!!";

?>