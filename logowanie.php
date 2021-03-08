<?php

	session_start();
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == true))
	{
		header('Location: index.html');
		exit();
	}

?>

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
		<form action="zaloguj.php" method="post">
		
			<div style="color: #008000; font-size: 24; font-weight: bold; margin-bottom: 20px; text-align: center;"> Podaj dane do logowania: </div>
			
			<input type="text" name="login" placeholder="login" onfocus="this.placeholder=' ' " onblur="this.placeholder='login '" maxlength="20" required>
			
			<input type="password" name="password" placeholder="hasło" onfocus="this.placeholder=' ' " onblur="this.placeholder='hasło'" maxlength="20" required>
			
			<?php

			if(isset($_SESSION['blad']))
			{
			echo $_SESSION['blad'];
			}

			?>
			
			<input type="submit" value="Zaloguj się">
			
			<div id="brak" style="margin-left: 15px; margin-top: 15px; font-size: 16px;">Nie posiadasz jeszcze konta? <br /><a href="rejestracja.php" class="link"> Załóż konto </a></div>
			
		</form>

	</div>
	
</body>
</html>