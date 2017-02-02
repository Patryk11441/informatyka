<?php
if(!isset($_POST['login']) && !isset($_POST['password']))
{
	header('Location: logowanie.php');
	exit();
}
else
{
	session_start();
	
	$login = $_POST['login'];
	$password = $_POST['password'];
	
	$login = htmlentities($login, ENT_QUOTES, 'UTF-8');
	
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
			if(!$connection->query("SET CHARSET utf8"))
			{
				throw new Exception($connection->error);
			}
			if(!$connection->query("SET NAMES utf8"))
			{
				throw new Exception($connection->error);
			}
			
			if($result = $connection->query("SELECT * FROM users WHERE user_login='".mysqli_real_escape_string($connection, $login)."'"))
			{
				if($result->num_rows > 0)
				{
					$row = $result->fetch_assoc();
					
					if(password_verify($password, $row['user_password']))
					{
						$_SESSION['isLogged'] = true;
						$_SESSION['user_id'] = $row['user_id'];
						
						header('Location: index.php');
					}
					else
					{
						$_SESSION['login_error'] = "Podano niepoprawne hasło logowania";
						header('Location: logowanie.php');
					}
				
					$result->close();
				}
				else
				{
					$_SESSION['login_error'] = "Użytkownik ".$login." nie istnieje w naszej bazie danych";
					header('Location: logowanie.php');
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
}
?>