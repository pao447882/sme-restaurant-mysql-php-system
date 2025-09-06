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
	<title>Sale Summary Page</title>
	<meta http-equiv="Content-Type" Content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="css/main.css">   
    <link rel="stylesheet" href="js/jquery-ui-1.12.1/jquery-ui.css" />
    <script type="text/javascript" src="js/jquery-3.5.1.js"></script>       
    <script type="text/javascript" src="js/jquery-ui-1.12.1/jquery-ui.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
		.content-container {
			display: flex;
			flex-direction: column; 
			align-items: center;
		}

		.chart-container {
			display : block;
            text-align: center;
			width: 85%;
			height : 75%;
			max-height: 550px;
			margin-top : 20px;
			margin-bottom : 20px;
		}

		.disp-chart {
			display : block;
			text-align: center;
			max-height: 500px;
		}

		.chart-title {
			font-family: 'Arial', sans-serif; 
			color: #3498DB; 
			text-transform: uppercase; 
			letter-spacing: 4px;
		}

		.bar-chart{
			display : block;
			text-align: center;
			max-height: 450px;
		}

    </style>
</head>
<body>
	<div class="container" >
		<h3 style="margin-bottom : 12px;">Sale Summary Page</h3>
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
	
	
	<div class="content-container" >

	<!-- ยอดขายรายวัน -->
	<div class="chart-container" >
		<h1 class="chart-title">
           	ยอดขายรายวัน (15 วัน)
        </h1>
		<!--<div class="chart-slicer">
				<input type="number" class="slicer-num-input" id="daily_chart_day" name="daily_chart_day" value="15" min="5">
		</div>-->
		<canvas class="bar-chart" id="daySaleChart" width="400" height="200"></canvas>
		<script>
			// Get the context of the canvas element
			var daily_ctx = document.getElementById('daySaleChart').getContext('2d');

			// Fetch data from the server (replace "fetch_data.php" with your server-side script)
			fetch('php/php_chart_day_sale.php')
				.then(response => response.json())
				.then(data => {
					//console.log(data);
					// Use the retrieved data to create the chart
					var myChart = new Chart(daily_ctx, {
						type: 'bar',
						data: {
							labels: data.date,
							datasets: [{
								label: 'Daily Sales',
								data: data.sales,
								backgroundColor: 'rgba(75, 192, 192, 0.2)',
								borderColor: 'rgba(75, 192, 192, 1)',
								borderWidth: 1
							}]
						},
						options: {
							scales: {
								y: {
									beginAtZero: true
								}
							}
						}
					});
				})
				.catch(error => console.error('Error fetching data:', error));
		</script>
	</div>	

	<!-- ยอดขายตามเมนู -->
	<div class="chart-container" >
		<h1 class="chart-title">
           	ยอดขายตามเมนู
        </h1>
		<!--<div class="chart-slicer">
				<input type="number" class="slicer-num-input" id="daily_chart_day" name="daily_chart_day" value="15" min="5">
		</div>-->
		<canvas class="bar-chart" id="MenuSaleChart" width="400" height="200"></canvas>
		<script>
			// Get the context of the canvas element
			var sale_by_menu_ctx = document.getElementById('MenuSaleChart').getContext('2d');

			// Fetch data from the server (replace "fetch_data.php" with your server-side script)
			fetch('php/php_chart_menu_sale.php')
				.then(response => response.json())
				.then(data => {
					console.log(data);
					// Use the retrieved data to create the chart
					var myChart = new Chart(sale_by_menu_ctx, {
						type: 'bar',
						data: {
							labels: data.menu_name,
							datasets: [{
								label: 'Menu Sales',
								data: data.sales,
								backgroundColor: [
									'rgba(255, 99, 132, 0.7)', // Red
									'rgba(54, 162, 235, 0.7)', // Blue
									'rgba(255, 206, 86, 0.7)', // Yellow
									'rgba(75, 192, 192, 0.7)', // Green
									'rgba(153, 102, 255, 0.7)' // Purple
								],
								borderWidth: 1
							}]
						},
						options: {
							scales: {
								y: {
									beginAtZero: true
								}
							}
						}
					});
				})
				.catch(error => console.error('Error fetching data:', error));
		</script>
	</div>	
	
	<!-- ยอดขายตามสถานที่ -->
	<div class="chart-container" >
		<h1 class="chart-title">
           	ยอดตามสถานที่ขาย
        </h1>
		<!--<div class="chart-slicer">
				<input type="number" class="slicer-num-input" id="daily_chart_day" name="daily_chart_day" value="15" min="5">
		</div>-->
		<canvas class="disp-chart" id="PlaceSaleChart" width="400" height="200"></canvas>
		<script>
			// Get the context of the canvas element
			var place_ctx = document.getElementById('PlaceSaleChart').getContext('2d');

			fetch('php/php_chart_place_sale.php')
            .then(response => response.json())
            .then(data => {
				//console.log(data);
                // Create a Chart.js pie chart with the retrieved data
                var myPieChart = new Chart(place_ctx, {
                    type: 'pie',
                    data: {
                        labels: data.map(item => item.place),
                        datasets: [{
                            data: data.map(item => item.sales),
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.7)',
                                'rgba(54, 162, 235, 0.7)',
                                'rgba(255, 206, 86, 0.7)',
                                'rgba(75, 192, 192, 0.7)',
                                'rgba(153, 102, 255, 0.7)',
                                'rgba(255, 159, 64, 0.7)'
                                // Add more colors if needed
                            ]
                        }]
                    }
                });
            })
            .catch(error => console.error('Error fetching pie chart data:', error));
		</script>
	</div>

	</div>

</body>
</html>