<?php

	session_start();
	
	//$_SESSION['id'] =$logged_user_id;

	if ((isset($_POST['kategoria']))AND(isset($_POST['data'])))
	{
		$amount = $_POST['kwota'];
		$date = $_POST['data'];
		$income_category = $_POST['kategoria'];
		$comment = $_POST['komentarz'];
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try
		{
			$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
					if (@$polaczenie->query("INSERT INTO przychody (logged_user_id, income_id, amount, date, income_category, comment) VALUES ('$logged_user_id', NULL, '$amount', '$date', '$income_category', '$comment')"))
					{
						$_SESSION['dodanoprzychod']=true;
						echo "Nowy przychód dodany";
						header('Location: index.html');
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
				
				$polaczenie->close();
			}
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o dodanie przychodu w innym terminie!</span>';
			//echo '<br />Informacja developerska: '.$e;
		}
		
	}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title>Przychody</title>
	<meta name="description" content="Zarządzanie budżetem" />
	<meta name="keywords" content="budżet, przychód, wydatki" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="main.css" type="text/css" />
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
	
	<!--[if lt IE 9]>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->
	
</head>

<body onload="data();">

	<header>
	
		<nav class="navbar navbar-dark bg-navbar navbar-expand-lg">
			
				<a class="navbar-brand" href="index.php"><img src="img/money.png" width="40" height="35" class="d-inline-block mr-1 align-center mx-2" alt=""> Budżet-Manager</a>
			
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
					<span class="navbar-toggler-icon"></span>
				</button>
			
				<div class="collapse navbar-collapse align-items-start" id="mainmenu">
			
				<ul class="navbar-nav mr-auto menu">
					<li class="nav-item">
						<a class="nav-link active" href="przychody.php">Dodaj przychód</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="wydatki.php">Dodaj wydatek</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="bilans.html">Przeglądaj bilans</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Ustawienia</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="logout.php">Wyloguj się</a>
					</li>
				</ul>
				
				</div>
				
			</nav>
	
	<div id="container">
		
			<div id="logowanie"><a href="logout.php" class="link">Wyloguj</a></div>
			
			<h1 class="logo text-center myclass m-auto"><a href="index.php" class="link" title="Strona główna"><img src="img/wallet.png" width="60" height="40" alt="portfel"/>Zarządzaj swoim budżetem<img src="img/wallet.png" width="60" height="40" alt="portfel"/></a></h1>
	
	</div>
		
		</header>
	
			<main>
	
				<article>
		
					<section>
		
						<div class="categories">
				
							<header>
			
								<form action="index.php" method="post">
					
									<div id="formId" class="justify-content-center row">	
									
										<label class="col-form-label" >Kwota: </label><input id="kategoria" type="number" placeholder="21.37" onfocus="this.placeholder=' ' " onblur="this.placeholder='21.37' " name="kwota" step='0.01' style="margin-right: 0px;">
										
										<label class="col-form-label"> Data przychodu:</label><input type="date" name="data" value="<?php echo date('Y-m-d'); ?>" style="margin-top: 5px; margin-right: 0px;">
										
										<label for="kategoria" class="col-form-label"> Kategoria: </label>
										<select id="kategoria" name="kategoria" style="margin-right: 0px;">
											<option value="w" selected>Wynagrodzenie</option>
											<option value="ob">Odsetki bankowe</option>
											<option value="s">Sprzedaż na allegro</option>
											<option value="i">Inne</option>
										</select>
									
										<label id="komentarz" class="col-form-label" >Komentarz (opcjonalnie):</label><input type="text" placeholder="inne" onfocus="this.placeholder=' ' " onblur="this.placeholder='inne' " name="komentarz" style="margin-top: 5px; margin-right: 0px;">
										
									</div>
									
									<div class="row row-expenses justify-content-center">
											<div class="col-xl-6 col-lg-12">
													<input type="submit" value="Dodaj" class="col-lg-6 col-form-label">
											</div>
											<div class="col-xl-6 col-lg-12">
												<input type="reset" value="Anuluj" class="col-lg-6 col-form-label">
											</div>
									</div>
						
								</form>
							</header>
						</div>
	
				</section>
	
			</article>
		
		</main>
		
		<footer>
				
				<div class="info" style="text-align: center;">
						Wszelkie prawa zastrzeżone &copy; 2021 Dziękuję za wizytę!
				</div>
		
		</footer>
		
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
		
		<script src="js/bootstrap.min.js"></script>

</body>
</html>
