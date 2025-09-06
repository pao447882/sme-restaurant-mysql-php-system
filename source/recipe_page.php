<?php
	session_start();

	$user_role = $_SESSION['Role'];
    $emp_id = $_SESSION['Employee_id'];

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
	
    if($_SESSION['Role'] == "owner"){

	} else	{
		$_SESSION["Alert"] = "This Page For Owner Only !!!";	
        session_write_close();	
		header("location:index.php");
		exit();
	}	

?>

<html>
<head>
	<title>Recipe Page</title>
	<meta http-equiv="Content-Type" Content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="css/main.css">   
    <link rel="stylesheet" href="js/jquery-ui-1.12.1/jquery-ui.css" />
    <script type="text/javascript" src="js/jquery-3.5.1.js"></script>       
    <script type="text/javascript" src="js/jquery-ui-1.12.1/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/script_new_order.js"></script>
    <style>
		/* Add your styles here */
		body {
			font-family: 'Arial', sans-serif;
			margin: 0;
			padding: 0;
			/*display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
			background-color: #f4f4f4;*/
		}

        #search_result{
            text-align: center;
        }

		.dropdown {
    		position: relative;
		}

		select {
			appearance: none;
			-webkit-appearance: none;
			-moz-appearance: none;
			width: 200px;
			padding: 10px;
			font-size: 16px;
			border: 1px solid #ccc;
			border-radius: 5px;
			outline: none;
			cursor: pointer;
			background-color: #fff;
		}

		select:hover {
			border-color: #aaa;
		}

		select:focus {
			border-color: #4CAF50;
			box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
		}

		/* Style the arrow */
		select::after {
			content: '\25BC'; /* Unicode character for down arrow ▼ */
			position: absolute;
			top: 50%;
			right: 10px;
			transform: translateY(-50%);
			color: #555;
		}

		/* Style the options */
		option {
			background-color: #fff;
			color: #555;
		}

		option:hover {
			background-color: #eee;
		}			
		
		.menu-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .menu-table th, .menu-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .menu-table th {
            background-color: #4CAF50;
            color: white;
			text-align: center;
        }

        .menu-table input {
            width: 40px;
            text-align: center;
        }

        button {
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .order-summary {
            display: none;
            margin-top: 20px;
			/*display: flex;*/
			flex-direction: column; 
			align-items: center;
        }

        ul {
			font-size : 22px;
            list-style: none;
            padding: 0;
			display: flex;
            flex-direction: column;
            align-items: center;
        }

        li {
			font-size : 18px;
            margin-bottom: 5px;
        }

		

    </style>
</head>
<body>
	<div class="container" >
		<h3 style="margin-bottom : 12px;">This is Recipe Page !!! </h3>
		Username : <?php echo $emp_name?>	
		<div class="button-container">
			<button class="btn-head" id="btnBack" onclick="location.href='menu_list_edit.php';"><< Menu List Page</button>
			<button class="btn-head" id="btnLogout" onclick="location.href='php/logout.php';">Logout</button>			
		</div>
	</div>
	<h4 class="line_cut">----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</h4>
    <div id="menu_container" class="container">
        <?php            
            $sql = "SELECT * FROM menu WHERE menu_id = ".$_GET["menu_id"];
            $sqlQuery = mysqli_query($conn, $sql);
            $objResult = mysqli_fetch_array($sqlQuery);

            $menu_id = $objResult["menu_id"];
            $menu_name = $objResult["menu_name"];
            $price = $objResult["price"];
            $branch = $objResult["branch_available"];

            echo "Menu # ".$menu_id;
            echo "  ".$menu_name;
            echo "<br>Price (Bath) : ".$price;
            echo "<br>Branch Available : ".$branch;
            echo "<br><br>";	

            $sql = "SELECT * FROM menu LEFT JOIN recipe USING (menu_id) LEFT JOIN ingredient USING (ingredient_id) WHERE menu_id = ".$menu_id;
            //echo $sql;
            $result = mysqli_query($conn, $sql);    
            $cnt = 0;

            /*while ($row = mysqli_fetch_assoc($result)) {
                echo "<br>Ingd ID : ".$row['ingredient_id'];
                echo "<br>Ingd Name : ".$row['ingredient_name'];
                echo "<br>Unit : ".$row['unit'];
                echo "<br>Cost/Unit : ".$row['cost_per_unit'];
                echo "<br>Amount : ".$row['amount'];
                echo "<br>----------------------";
            }*/
        ?>	

        <div class="menu_list">
		<table class="menu-table">
			<thead>
				<tr>
					<th style="width:20px">#</th>	
					<th style="width:60px">Ingd ID</th>					
					<th style="width:180px">Ingredient Name</th>
					<th style="width:75px">Unit</th>
                    <th style="width:50px">Cost/Unit</th>
					<th style="width:80px">Amount</th>
				</tr>
			</thead>
			<tbody id="menu-body">
           
				<?php while ($row = mysqli_fetch_assoc($result)) { $cnt += 1; ?>				
					<tr>
						<td><?php echo $cnt; ?></td>
						<td><?php echo $row['ingredient_id']; ?></td>
                        <td><?php echo $row['ingredient_name']; ?></td>
                        <td><?php echo $row['unit']; ?></td>
                        <td><?php echo $row['cost_per_unit']; ?></td>
                        <td><?php echo $row['amount']; ?></td>

				<?php } ?>
            </tbody>
		</table>
	    </div>	
    </div>
	
</body>
</html>
