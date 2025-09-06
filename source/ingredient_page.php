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

    // Delete Ingredient
	 if (isset($_GET['delete_id'])) {
        $delete_id = $_GET['delete_id'];
        $delete_query = "DELETE FROM ingredient WHERE ingredient_id = $delete_id";

        $delete_result = mysqli_query($conn, $delete_query);

        if ($delete_result) {
            header('Location: ingredient_page.php'); 
            exit();
        } else {
            echo "Error deleting ingredient data: " . mysqli_error($conn);
        }
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
    <title>Ingredient Page</title>
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

        #btnAddIngd{
            background-color: #F1948A;
            color: #2E86C1;
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
		
	<!-- Show Ingredient Section -->
    <!-- /*******************************************************************************************************/ -->
    <div style = "text-align : center;">

        <form class="" name="ingredientform" id="ingredientform">
            <div class="search_input">
                <label for="textsearch" >Input Ingredient Name</label>
                <input type="text" name="input_ingredient" id="input_ingredient" class="text_search" placeholder="&nbsp;Ingredient Name">
                
                <button type="button" class="accept_btn" id="btnIngd">
                    <span></span>
                    ค้นหา
                </button>
            </div>
            <form>
                <div style="margin-top: 10px;">
                    <input type="checkbox" id="show_all" name="show_all" value="all">
                    <label for="show_all">&nbsp; Show All Ingredients</label><br>
                </div>
            </form>
        </form>	
    </div>
    <div class="container" id = "ingredient_list" style="margin-top: 10px;"></div>
    
    <script type="text/javascript">

        $(function () {
            $("#input_ingredient").autocomplete({
					source: "php/php_ingredient_search.php",
				});



            $("#btnIngd").click(function() {
                var show_all_stock;

                if($("#show_all").prop("checked")){
                    //console.log("Show All");
                    show_all_ingredient = "all";
                } else {
                    //console.log("Show Only Good Price");
                    show_all_ingredient = "none";
                }

                $.ajax({
                    url: "php/php_ingredient_get_list.php",
                    type: "post",
                    data: {ingd_name: $("#input_ingredient").val(), emp_id : "<?php echo $emp_id; ?>", user_role : "<?php echo $user_role; ?>", show_all : show_all_ingredient},
                    success: function (data) {
                        $("#ingredient_list").html(data);
                    }
                });
            });

            $("#ingredientform").on("keyup keypress",function(e){
                var code = e.keycode || e.which;
                if(code == 13){
                    $("#btnIngd").click();
                    return false;
                }
            });
        });
    </script>

    <h4 class="line_cut">----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</h4>

    <h4 style = "text-align : center;">Add New Ingredient</h4>

    <div style = "text-align : center;">
    <form class = "input_form" name="form1" method="post" action="add_new_ingredient.php">
   	<table class="table_form" width="400" border="1" style="width: 400px">
		<tbody>
			<tr>               
				<td width="125"> &nbsp;New Ingredient</td>				
                <?php 
                    $sql = "SELECT MAX(ingredient_id) FROM ingredient";	
                    $sqlQuery = mysqli_query($conn, $sql);
                    $objResult = mysqli_fetch_array($sqlQuery);
                    
                    //echo "&nbsp;".($objResult[0] + 1);					
                ?>
                <td><input name="ingd_id" type="text" id="ingd_id" value="<?php echo "&nbsp;".($objResult[0] + 1); ?>" readonly></td>
				
			</tr>
			<tr>
				<td> &nbsp;Ingredient Name</td>		
				<td><input name="ingd_name" type="text" id="ingd_name" value="" placeholder="&nbsp;ชื่อวัตถุดิบ"></td>
			</tr>
			<tr>
				<td> &nbsp;Unit</td>
				<td>
                    <select id="ingd_unit" name="ingd_unit" value = "">                            
                            <option value="kilogram">Kilogram</option>
                            <option value="liter">Liter</option>		
							<option value="gram" selected="selected">gram</option>	
                            <option value="mililiter">mililiter</option>								
							<option value="bottle">bottle</option>
							<option value="pack">piece</option>
                            <option value="table spoon">tbspn</option>								
							<option value="dipper">dipper</option>
						</select>
                </td>
			</tr>
			<tr>
				<td> &nbsp;Cost/Unit</td>
				<td><input name="ingd_cost" type="number" step="0.01" id="ingd_cost" value="" placeholder="&nbsp;ราคาต่อหน่วย"></td>
			</tr>			
		</tbody>
	</table>
    
	<br>
	<input class="btn-head" id="btnAddIngd" type="submit" name="ingd_add_submit" value="ADD NEW">
	</form>
    </div>

    <?php
        if($user_role== "admin" || $user_role== "owner") {

            $dest = "'delete_ingredient.php'";
            echo '
            <div class="container">
            <button class="btn-head" id="btnDelIngd" onclick="location.href='.$dest.';">-- Delete Ingredient --</button>
            </div>
             ';  
        }
    ?>



</body>
</html>