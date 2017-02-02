<?php session_start(); ?>

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
	<div class="global-box">
		<form method="post" action="login.php">
			<div class="title-login">Logowanie</div>
			<div class="login">
				<input type="text" name="login" class="input" placeholder="Nazwa Użytkownika"> <br><div class="box" style="margin-top: -18px;"><i class="icon-user"></i></div>
				<input type="password" name="password" class="input" style="margin-top: 15px;"placeholder="Hasło"> <br><div class="box" style="margin-top: -3px;"><i class="icon-lock"></i></div>
			</div>
			<div class="box-submit">
				<input type="submit" value="Zaloguj" class="submit"></input>
			</div>
		</form>
		<?php if(isset($_SESSION['login_error'])) echo '<div class="box-error">'.$_SESSION['login_error'].'</div>'; unset($_SESSION['login_error']);?>
	</div>
</body>
</html>