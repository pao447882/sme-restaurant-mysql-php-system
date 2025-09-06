<?php
	session_start();
	
	include 'php/connect_db.php';

    $user_role = $_SESSION['Role'];
    $emp_id = $_SESSION['Employee_id'];

    /*echo "Session : ".$_SESSION['Role'];
    echo "<br>";
    echo "ID : ".$_SESSION['Employee_id'];*/

    function phpAlert($msg) {
        echo '<script type="text/javascript">alert("' . $msg . '")</script>';
    }

    if($_SESSION['Alert'] != "") {
        $alert_msg = $_SESSION['Alert'];
		phpAlert($alert_msg);
        $_SESSION['Alert'] = "";
    }
	
	if($_SESSION['Employee_id'] == "")
	{
		echo "Please Login!";
		exit();
	}	

    if($_SESSION['Role'] == "") {
        #$alert_msg = "Please Login !!!";
		#phpAlert($alert_msg);
		$_SESSION["Alert"] = "Please Login !!!";	
        session_write_close();	
		header("location:index.php");
		exit();
    }   

    if($_SESSION['Role'] == "owner"){

	} else	{
		$_SESSION["Alert"] = "This page for Admin and Owner only !!!";		
        session_write_close();	
		header("location:index.php");
		exit();
	}	

    $sql = "SELECT * FROM employee WHERE employee_id = '".$_SESSION["Employee_id"]."' ";
	$sqlQuery = mysqli_query($conn, $sql);

	$objResult = mysqli_fetch_array($sqlQuery);
    $emp_id = $objResult["employee_id"];
	$emp_name = $objResult["emp_name"];
	$user_role = $objResult["role"];	
	$branch = $objResult["branch"];
?>

<html>
<head>
    <title>Create Menu Page</title>
	<meta http-equiv="Content-Type" Content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="css/main.css">   
    <link rel="stylesheet" href="js/jquery-ui-1.12.1/jquery-ui.css" />
    <script type="text/javascript" src="js/jquery-3.5.1.js"></script>       
    <script type="text/javascript" src="js/jquery-ui-1.12.1/jquery-ui.min.js"></script>
    <style>
        #search_result{
            text-align: center;
        }

        .ingredient_list {
            max-height : 600px;
        }
       
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        td.editable {
            cursor: pointer;
            background-color: #e6f7ff;
        }

        .container {
            display: flex; /* Use flexbox to align items */
            flex-direction: column; /* Stack items vertically */
            align-items: center; /* Center items horizontally */
        }

        .input_element {
            margin: 5px;
        }
    </style>
   
</head>
<body>
    <div class="container" >
		<h3 style="margin-bottom : 12px;">Create Menu Page</h3>
		Username : <?php echo $emp_name?>	
		<div class="button-container">          
            <button class="btn-head" onclick="location.href='owner_page.php';"><< Owner Page</button>          
            <button class="btn-head" id="btnLogout" onclick="location.href='php/logout.php';">Logout</button>			
		</div>
	</div>    

    <h4 class="line_cut">----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</h4>
    
    <?php
        $sql = "SELECT MAX(menu_id) FROM menu";	
        $sqlQuery = mysqli_query($conn, $sql);
        $objResult = mysqli_fetch_array($sqlQuery);

        if (count($objResult) > 0) {
            $new_menu_id = $objResult[0] + 1;
        } else {
            $new_menu_id = 1;
        }
        
        
    ?>
    <div class = "container">
        <div class = "input_element"><input name="menu_id" type="text" id="menu_id" value="<?php echo $new_menu_id;?>" readonly></div>
        <div class = "input_element"><input name="menu_name" type="text" id="menu_name" value="" placeholder="&nbsp;Menu Name"></div>
        <div class = "input_element"><input name="menu_price" type="number" step="0.01" id="menu_price" value="" placeholder="&nbsp;Sale Price"></div>
        <div class = "input_element"><input name="menu_available" type="number" id="menu_available" value="" placeholder="&nbsp;Branch Available 1 or 2"></div>
        
    </div>

    <h4 class="line_cut">----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</h4>
        
    <table id="myTable" class="center" style="width:900px">
        <thead>
            <tr>                
                <th class = "th_text" style="width:300px">Ingredient Name</th>
                <th class = "th_text" style="width:180px">Ingredient ID</th>
                <th class = "th_text" style="width:180px">Unit</th>
                <th class = "th_text" style="width:120px">amount</th>
                <th class = "th_text" style="width:200px">Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Existing rows go here -->
        </tbody>
    </table>
    <br>
    <div class = "container">
    <button id="addRow">Add Row</button>
    </div>


    <h4 class="line_cut">----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</h4>
        
    <div class = "container">
        <div class = "input_element"><button id="addNewMenu">Create Menu</button></div>
    </div>

    <script>
        $(document).ready(function() {       
            // Add new row on button click
            $("#addRow").on("click", function() {
                addRow();
            });

            // Save data on button click
            $("#addNewMenu").on("click", function() {
                addData();
            });

            function addRow() {
                // Create a new row with input fields
                var newRow = $("<tr>");
                var cols = "";               
                         
                cols += '<td><input type="text" name="ingredient_name[]" class="ingd_name_input" placeholder="&nbsp;Ingredient Name"/></td>';
                cols += '<td><input type="text" name="ingredient_id[]" class="ingd_id" placeholder="&nbsp;Ingredient ID" readonly/></td>';
                cols += '<td><input type="text" name="ingredient_unit[]" class="ingd_unit" placeholder="&nbsp;Ingredient Unit" readonly/></td>';
                cols += '<td><input type="text" name="ingredient_amount[]" class="ingd_amount" placeholder="&nbsp;Ingredient Amount"/></td>';
                cols += '<td><button class="remove">Remove</button></td>';

                newRow.append(cols);

                // Append the new row to the table
                $("#myTable").append(newRow);

                $(".ingd_name_input").autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: 'php/php_ingd_menu_search.php', // Replace with the actual path to your server-side script
                            method: 'POST',
                            dataType: 'json',
                            data: {
                                term: request.term
                            },
                            success: function(data) {
                                response(data);
                            }
                        });
                    },
                    minLength: 2, // Minimum characters before triggering autocomplete
                    select: function(event, ui) {
                        // Auto-fill the corresponding id & unit field
                        $(this).closest('tr').find('.ingd_id').val(ui.item.id);
                        $(this).closest('tr').find('.ingd_unit').val(ui.item.unit);
                        
                    }
                });
                
            }

            // Remove row on button click
            $("#myTable").on("click", ".remove", function() {
                $(this).closest("tr").remove();
            }); 
            
            function addData() {
                // Collect data from the table and send it to the server for saving
                var menuData = [];
                var tableData = [];   
                
                menuData.push($("#menu_id").val());
                menuData.push($("#menu_name").val());
                menuData.push($("#menu_price").val());
                menuData.push($("#menu_available").val());

                $("#myTable tbody tr").each(function() {
                    var rowData = {
                        ingd_id: $(this).find('.ingd_id').val(),
                        ingd_unit: $(this).find('.ingd_unit').val(),
                        ingd_amount: $(this).find('.ingd_amount').val()
                    };
                    tableData.push(rowData);
                });

                console.log(tableData);
                console.log(menuData);

                // Send data to the server for saving
                $.ajax({
                    url: 'php/save_create_menu.php', // Replace with the actual path to your server-side script for saving
                    method: 'POST',
                    data: { ingd_data: JSON.stringify(tableData), menu_data : menuData },
                    success: function(response) {
                        console.log(response);
                        // You can handle the response as needed
                        alert(response);
                        location.reload();
                    }
                });
            }
            
        });

    </script>

</body>
</html>