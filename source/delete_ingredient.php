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
    <title>Delete Ingredient Page</title>
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
    </style>
</head>
<body>
    <div class="container" >
		<h3 style="margin-bottom : 12px;">Delete Ingredient</h3>
		Username : <?php echo $emp_name?>	
		<div class="button-container">
            <button class="btn-head" id="btnBack" onclick="location.href='ingredient_page.php';"><< Ingredient Page</button>
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
    <div id = "ingredient_list" style="margin-top: 10px;"></div>
    
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
                    url: "php/php_ingredient_get_del_list.php",
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
</body>
</html>