<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<title>Strona logowania</title>
	<meta name="description" content="Zarządzanie budżetem" />
	<meta name="keywords" content="budżet, przychód, wydatki" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		
	<link rel="stylesheet" href="style.css" type="text/css" />
	
</head>

<body>

	<div id="container">
		<form action="logowanie.php" method="post">
		
			<div style="color: #008000; font-size: 24; font-weight: bold; margin-bottom: 20px; text-align: center;"> Podaj dane do logowania: </div>
			
			<input type="text" placeholder="login" onfocus="this.placeholder=' ' " onblur="this.placeholder='login" required>
			
			<input type="password" placeholder="hasło" onfocus="this.placeholder=' ' " onblur="this.placeholder='hasło'" required>
			
			<input type="submit" value="Zaloguj się">
			
			<div id="brak" style="margin-left: 15px; margin-top: 15px; font-size: 16px;">Nie posiadasz jeszcze konta? <br /><a href="rejestracja.php" class="link"> Załóż konto </a></div>
			
		</form>
		
		<?php

	if(isset($_SESSION['blad']))
	echo $_SESSION['blad'];

		?>

	</div>
	
</body>
</html>