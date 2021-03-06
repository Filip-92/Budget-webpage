<?php

	session_start();

	if (isset($_POST['email']))
	{
		//Udana walidacja? Załóżmy, że tak!
		$wszystko_OK=true;
		
		//Sprawdź poprawność loginu
		$login = $_POST['login'];
		
		//Sprawdzenie długości loginu
		if ((strlen($login)<3) || (strlen($login)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_login']="Login musi posiadać od 3 do 20 znaków!";
		}
		
		if (ctype_alnum($login)==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_login']="Login może składać się tylko z liter i cyfr (bez polskich znaków)";
		}
		
		//Sprawdź poprawność adresu email
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$wszystko_OK=false;
			$_SESSION['e_email']="Podaj poprawny adres e-mail!";
		}
		
		//Sprawdź poprawność hasła
		$password1 = $_POST['password1'];
		$password2 = $_POST['password2'];
		
		if ((strlen($password1)<8) || (strlen($password1)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_password']="Hasło powinno zawierać od 8 do 20 znaków!";
		}
		
		if ($password1!=$password2)
		{
			$wszystko_OK=false;
			$_SESSION['e_password']="Podane hasła nie są identyczne!";
		}
		
		$password_hash = password_hash($password1, PASSWORD_DEFAULT);
		
		//Bot or not? Oto jest pytanie
		$sekret = "6Lcl9GQaAAAAAA13rLSPrGkC7-sGmIwOIg9sjw14";
		
		$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
		
		$odpowiedz = json_decode($sprawdz);
		
		if ($odpowiedz->success==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_bot']="Potwierdź, że nie jesteś botem!";
		}	
		
		//Zapamiętaj wprowadzone dane
		$_SESSION['fr_login'] = $login;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_password1'] = $password1;
		$_SESSION['fr_password2'] = $password2;
		
		require_once 'database.php';
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try
		{
			$pdo = @new pdo($host, $db_user, $db_password, $db_name);
			$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  
			if ($pdo>connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				//Czy email już istnieje?
				$rezultat = $db->prepare("SELECT id FROM uzytkownicy WHERE email=':email'");
				$userQuery->bindValue(':email', $email, PDO::PARAM_STR);
				$userQuery->execute();
				
				if (!$rezultat) throw new Exception($pdo->error);
				
				$ile_takich_maili = $rezultat->num_rows;
				if ($ile_takich_maili>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
				}
				
				//Czy login jest już zarezerwowany?
				$rezultat = $db->prepare("SELECT id FROM uzytkownicy WHERE user=':login'");
				$userQuery->bindValue(':login', $login, PDO::PARAM_STR);
				$userQuery->execute();
				
				if (!$rezultat) throw new Exception($pdo->error);
				
				$ile_takich_loginow = $rezultat->num_rows;
				if ($ile_takich_loginow>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_login']="Istnieje już użytkownik o takim loginie! Wybierz inny.";
				}
				
				if ($wszystko_OK==true)
				{
					//Hurra, wszystkie testy zaliczone, dodajemy użytkownika do bazy
					
						$sql_user = "INSERT INTO uzytkownicy VALUES (NULL, '':login', ':password', ':email')";
						
						if (!$rezultat) throw new Exception($pdo->error);
						
						$rezultat = $db->prepare($sql_user);
						
						if ($rezultat)
						{
						$query_user->bindValue(':login', $login, PDO::PARAM_STR);
						$query_user->bindValue(':password', $password_hash, PDO::PARAM_STR);
						$query_user->bindValue(':email', $email, PDO::PARAM_STR);
						$query_user->execute();
						 
						$sql_incomes = "INSERT INTO incomes_category_assigned_to_users (user_id, name) SELECT uzytkownicy.id, incomes_category_default.name FROM uzytkownicy, incomes_category_default WHERE uzytkownicy.email= :email";
						
						$query_incomes = $db->prepare($sql_incomes);
						$query_incomes->bindValue(':email', $email, PDO::PARAM_STR);
						$query_incomes->execute();
						
						$_SESSION['udanarejestracja']=true;
						header('Location: logowanie.php');
						}
						else
						{
						throw new Exception($pdo->error);
						}
				}
			}
		
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
			//echo '<br />Informacja developerska: '.$e;
		}
		
	}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<title>Strona rejestracji</title>
	<meta name="description" content="Zarządzanie budżetem" />
	<meta name="keywords" content="budżet, przychód, wydatki" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		
	<link rel="stylesheet" href="style.css" type="text/css" />
	<script src='https://www.google.com/recaptcha/api.js'></script>
	
</head>

<body>

	<div id="container">
		<form method="post">
		
			<div style="color: #008000; font-size: 24; font-weight: bold; margin-bottom: 20px; text-align: center;"> Podaj dane do rejestracji: </div>
			
			<input type="text" placeholder="login" name="login" onfocus="this.placeholder=' ' " onblur="this.placeholder='login'" maxlength="20">
			
			<?php
			
				if (isset($_SESSION['e_login']))
				{
					echo '<div class="error">'.$_SESSION['e_login'].'</div>';
					unset($_SESSION['e_login']);
				}
			
			?>
			
			<input type="email" placeholder="e-mail" name="email" onfocus="this.placeholder=' ' " onblur="this.placeholder='email'">
			
			<?php
			
				if (isset($_SESSION['e_email']))
				{
					echo '<div class="error">'.$_SESSION['e_email'].'</div>';
					unset($_SESSION['e_email']);
				}
			
			?>
			
			<input type="password" placeholder="hasło" name="password1" onfocus="this.placeholder=' ' " onblur="this.placeholder='hasło'" maxlength="20">
			
			<?php
			
				if (isset($_SESSION['e_password']))
				{
					echo '<div class="error">'.$_SESSION['e_password'].'</div>';
					unset($_SESSION['e_password']);
				}
			
			?>
			
			<input type="password" placeholder="Powtórz hasło" name="password2" onfocus="this.placeholder=' ' " onblur="this.placeholder='Powtórz hasło'" style="margin-bottom:10px;">
			
			<div class="g-recaptcha" data-sitekey="6Lcl9GQaAAAAALjibic7LQytPzxnaAlD4UyggyUz"></div>
			
			<?php
			
				if (isset($_SESSION['e_bot']))
				{
					echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
					unset($_SESSION['e_bot']);
				}
			
			?>
			
			<input type="submit" value="Zarejestruj się">
			
		</form>
	</div>
	
</body>
</html>