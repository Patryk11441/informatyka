<?php
	session_start();

	if(!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] == false || !isset($_SESSION['user_id']))
	{
		header('Location: logowanie.php');
		exit();
	}
	
	$uid = $_SESSION['user_id'];
	
	require_once('config.php');
	mysqli_report(MYSQLI_REPORT_STRICT);
	
	try
	{
		$connection = new mysqli($db_host, $db_user, $db_password, $db_name);
		
		if($connection->connect_errno != 0)
		{
			throw new Exception($connection->connect_errno);
		}
		else
		{	
			if($result = $connection->query("SELECT * FROM USERS WHERE user_id = '$uid'"))
			{
				if($result->num_rows == 0)
				{
					throw new Exception('Wystąpił błąd z numerem id użytkownika');
				}
				else
				{
					$row = $result->fetch_assoc();
	
					$login = $row['user_login'];
					$email = $row['user_email'];
				
					$result->close();
				
				}
			} 
			else
			{
				throw new Exception($connection->error);
			}
		}
		
		$connection->close();
	}
	catch(Exception $error)
	{
		echo 'Wystąpił błąd serwera <br>';
		echo 'Numer błędu: '.$error->getCode().'<br>';
		echo 'Opis błędu: '.$error;
	}
?>

<!DOCYTYPE>
<html lang="pl">
<head>
	<title>Logowanie do strony</title>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<link href="https://fonts.googleapis.com/css?family=Anton|Oswald" rel="stylesheet">
	<link href="css/fontello.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
</head>
<body>
	<div class="global-box" style="height: 262px;">
		<form method="post" action="logout.php">
			<div class="title-login" style="text-align:left; margin-left: 10px;">
				UID: <?php echo $uid; ?><br>
				Login: <?php echo $login; ?><br>
				Email: <?php echo $email; ?>
			</div>
			<div class="box-submit">
				<input type="submit" value="Wyloguj" class="submit"></input>
			</div>
		</form>
	</div>
</body>
</html>