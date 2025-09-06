<html>
<head>
	<title>Kung Noodle</title>
	<style>
		body {
			display: flex;
			align-items: center;
			justify-content: center;
			height: 100vh;
			margin: 0;
			background-color: #f4f4f4;
		}

		.login-container {
			background-color: #D5F5E3;
			padding: 20px;
			border-radius: 8px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
		}

		form {
			display: flex;
			flex-direction: column;
			align-items: center;
		}

		h2 {
			color: #333;
			margin-bottom: 20px;
		}

		.input-group {
			margin-bottom: 15px;
			width: 100%;
		}

		label {
			display: block;
			font-size: 14px;
			color: #555;
			margin-bottom: 5px;
		}

		input {
			width: 100%;
			padding: 8px;
			font-size: 16px;
			border: 1px solid #ddd;
			border-radius: 4px;
			outline: none;
		}

		button {
			background-color: #4CAF50;
			color: #fff;
			padding: 10px 20px;
			border: none;
			border-radius: 4px;
			font-size: 16px;
			cursor: pointer;
			font-weight: bold;
		}

		button:hover {
			background-color: #45a049;
		}

	</style>
</head>
<body>

<?php
    session_start();

    function phpAlert($msg) {
        echo '<script type="text/javascript">alert("' . $msg . '")</script>';
    }

    if($_SESSION['Alert'] != "") {
        $alert_msg = $_SESSION['Alert'];
		phpAlert($alert_msg);
        $_SESSION['Alert'] = "";
    }
?>
<br>
<br>
	<div class="login-container">
	<form id="loginForm" action="php/check_login.php" method="post">
		<h2>Login</h2>
		<div class="input-group">
			<label for="username">Username</label>
			<input name="txtUsername" type="text" id="txtUsername" required>
		</div>
		<div class="input-group">
			<label for="password">Password</label>
			<input name="txtPassword" type="password" id="txtPassword" required>
		</div>
		<button type="submit">Login</button>
	</form>
	</div>
</body>
</html>

