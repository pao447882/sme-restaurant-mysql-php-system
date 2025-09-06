<?php
	session_start();
	
	include 'php/connect_db.php';

    $user_role = $_SESSION['Role'];
    $emp_id = $_SESSION['Employee_id'];
	
	if($_SESSION['Employee_id'] == "")
	{
		echo "Please Login!";
		exit();
	}	

	if($_SESSION['Role']  == "admin" || $_SESSION['Role'] == "owner" || $_SESSION['Role'] == "manager"){

	} else	{
		$_SESSION["Alert"] = "Please Login as Admin or Owner !!!";	
        session_write_close();	
		header("location:index.php");
		exit();
	}	

	// Delete user
	if (isset($_GET['delete_id'])) {
        $delete_id = $_GET['delete_id'];
        $delete_query = "DELETE FROM menu WHERE menu_id = $delete_id";

        $delete_result = mysqli_query($conn, $delete_query);

        if ($delete_result) {
            header('Location: menu_list_edit.php'); // Redirect to admin dashboard after successful delete
            exit();
        } else {
            echo "Error deleting user data: " . mysqli_error($conn);
        }
    }


	$sql = "SELECT * FROM employee WHERE employee_id = '".$_SESSION["Employee_id"]."' ";
	$sqlQuery = mysqli_query($conn, $sql);

	$objResult = mysqli_fetch_array($sqlQuery);
	$emp_name = $objResult["emp_name"];
	$user_role = $objResult["role"];
	$branch = $objResult["branch"];

	if($user_role == 'admin'){
		$branch = 0;
	}
	if($user_role == 'owner'){
		$branch = 0;
	}
?>

<html>
<head>
	<title>Menu List Page</title>
	<meta http-equiv="Content-Type" Content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="css/main.css">   
    <link rel="stylesheet" href="js/jquery-ui-1.12.1/jquery-ui.css" />
    <script type="text/javascript" src="js/jquery-3.5.1.js"></script>       
    <script type="text/javascript" src="js/jquery-ui-1.12.1/jquery-ui.min.js"></script>
    <style>
        #search_result{
            text-align: center;
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

		#btnNewMenu{
            background-color: #ABEBC6;
            color: #7D3C98;
        }

    </style>
</head>
<body>
	<div class="container" >
		<h3 style="margin-bottom : 12px;">Menu List Page</h3>
		Username : <?php echo $emp_name?>	
		<div class="button-container">
			<?php
				if($_SESSION['Role'] == "admin") {                     
					$dest = "'admin_page.php'";
					echo '<button class="btn-head" onclick="location.href='.$dest.';"><< Admin Page</button>';	    

				}
				if($_SESSION['Role'] == "owner") {
					$dest = "'owner_page.php'";
					echo '<button class="btn-head" onclick="location.href='.$dest.';"><< Owner Page</button>';	
				}
				if($_SESSION['Role'] == "manager") {
					$dest = "'manager_page.php'";
					echo '<button class="btn-head" onclick="location.href='.$dest.';"><< Manager Page</button>';	
				}
			?>

			<button class="btn-head" id="btnLogout" onclick="location.href='php/logout.php';">Logout</button>			
		</div>
	</div>    	
		
	<h4 class="line_cut">----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</h4>
	<?php
        if($user_role== "owner") {

            $dest = "'create_menu.php'";
            echo '
            <div class="container">
            <button class="btn-head" id="btnNewMenu" onclick="location.href='.$dest.';">++ Create New Menu ++</button>
            </div>
			<h4 class="line_cut">----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</h4>

             ';  
        }
    ?>
	
	<div style = "text-align : center; margin-top: 10px;">

		<form class = "input_form" class="search_name_form" name="searchnameform" id="searchnameform">
			<div class="search_input">
				<label for="textsearch" >Insert Menu</label>
				<input type="text" name="menu_name" id="menu_name" class="text_search" placeholder="&nbsp;Menu Name">
				
				<button type="button" class="accept_btn" id="btnSrch">
					<span></span>
					ค้นหา
				</button>
			</div>

			<form>
                <div style="margin-top: 10px;">
                    <input type="checkbox" id="show_all" name="show_all" value="all">
                    <label for="show_all">&nbsp; Show All Menus</label><br>
                </div>
            </form>
        </form>	
		<div class="container" id = "search_result" style="margin-top: 10px;"></div>

		<script type="text/javascript">
                
			$(function() {
				$("#menu_name").autocomplete({
					source: "php/php_menu_search.php",
				});
			
				$("#btnSrch").click(function() {

					if($("#show_all").prop("checked")){
						//console.log("Show All");
						show_all = "all";
					} else {
						//console.log("Show Only Good Price");
						show_all = "none";
					}

					$.ajax({
						url: "php/php_menu_list_get.php",
						type: "post",
						data: {menu_name: $("#menu_name").val(), branch : <?php echo $branch; ?> , show_all : show_all},
						success: function (data) {
							$("#search_result").html(data);
						}
					});
				});

				$("#searchnameform").on("keyup keypress",function(e){
					var code = e.keycode || e.which;
					if(code == 13){
						$("#btnSrch").click();
						return false;
					}
				});
			});
		</script>
	</div>

	
</body>
</html>