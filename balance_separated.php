<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.html');
		exit();
	}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title>Bilans</title>
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
			
				<a class="navbar-brand" href="index.php"><img src="img/money.png" width="40" height="35" class="d-inline-block mr-1 align-center mx-2" alt=""> Budżet-Manager </a>
			
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
					<span class="navbar-toggler-icon"></span>
				</button>
			
				<div class="collapse navbar-collapse align-items-start" id="mainmenu">
			
				<ul class="navbar-nav mr-auto menu">
					<li class="nav-item">
						<a class="nav-link" href="incomes.php">Dodaj przychód</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="expenses.php">Dodaj wydatek</a>
					</li>
					<li class="nav-item">
						<div class="nav-link active">Przeglądaj bilans</a>
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
	
			<h1 class="logo1 text-center myclass m-auto"><a href="index.php" class="link" title="Strona główna"><img src="img/wallet.png" width="60" height="40" alt="portfel"/>Zarządzaj swoim budżetem<img src="img/wallet.png" width="60" height="40" alt="portfel"/></a></h1>
					
	</div>
		
		</header>
		
			<main>
	
				<article>
		
					<section>
		
						<div class="categories">
				
							<header>
		
								<h1 class="mt-3">Bilans z wybranego okresu:</h1>
			
									<form action="balance.php" method="post">

										<div id="formId" class="justify-content-center row">
								
										<label class="col-form-label">Okres zdefiniowany:</label>
										<select id="płatność" name="date_of_income" class="col-lg-12">
												<option value="current_date" selected>Bieżący miesiąc</option>
												<option value="pm">Poprzedni miesiąc</option>
												<option value="br">Bieżący rok</option>
												<option value="n">Niestandardowy</option>
										</select>
							
										<label class="col-form-label" style="text-decoration: underline; color: green;">Zakres dat:</label>
										<label class="col-form-label">Od:</label><input type="date" name="starting_date" class="mx-2 col-lg-6">
										<label class="col-form-label">Do:</label><input type="date" name="ending_date" class="mx-2 mb-5 col-lg-6">
						
										</div>
										
											<div class="justify-content-center">
													<input type="submit" value="Filtruj" class="col-form-label" style="margin-top: -20px; margin-bottom: 20px;">
											</div>
										
									</form>
	
									<table width="60%" align="center">
										<tr>
											<td colspan="3" align="center" bgcolor="black">
												</td>
										</tr>
										<tr>
											<td width="60%" align="top">
											
										<h3>Przychody</h3> 
							
										<div class="category">Wynagrodzenie:</div>
											<div class="kategoriap">
												<div class="columnp1">
													<h4>Wysokość przychodu: </h4>
															<?php
															   echo $_SESSION['incomes_details_amount'];
															?>
												</div>
												<div class="columnp2"> 
													<h4>Data:</h4>
															<?php
															   echo $_SESSION['incomes_details_date'];
															?>
												</div>
													<div class="columnp3"> 
														<h4>Komentarz: </h4>
															<?php
															   echo $_SESSION['incomes_details_comment'];
															?>
													</div>
											</div>
											<div style="clear:both;">
											</div>
										
										<div class="category">Odsetki bankowe:</div>
											<div class="kategoriap">
												<div class="columnp1">
													<h4>Wysokość przychodu: </h4>
												</div>
												<div class="columnp2"> 
													<h4>Data:</h4>
												</div>
												<div class="columnp3"> 
													<h4>Komentarz: </h4>
												</div>
											</div>
											<div style="clear:both;">
											</div>
						
						<div class="category">Sprzedaż na allegro:</div><div class="kategoriap"><div class="columnp1"><h4>Wysokość przychodu: </h4></div><div class="columnp2"> <h4>Data:</h4></div><div class="columnp3"> <h4>Komentarz: </h4></div></div><div style="clear:both;"></div>
						
						<div class="category">Inne:</div><div class="kategoriap"><div class="columnp1"><h4>Wysokość przychodu: </h4></div><div class="columnp2"> <h4>Data:</h4></div><div class="columnp3"> <h4>Komentarz: </h4></div></div><div style="clear:both;"></div>
						</td> 
				</tr>
				<tr>
						<td colspan="3" align="center" bgcolor="black">
						</td>
				</tr>
						<td width="640" valign="top">
						<h3>Wydatki</h3> 
			
						<div class="category">Jedzenie:<div class="kategoriaw"><br /></div></div>
						<div class="category">Mieszkanie:<div class="kategoriaw"><br /></div></div>
						<div class="category">Transport:<div class="kategoriaw"><br /></div></div>
						<div class="category">Telekomunikacja:<div class="kategoriaw"><br /></div></div>
						<div class="category">Opieka zdrowotna:<div class="kategoriaw"><br /></div></div>
						<div class="category">Ubranie:<div class="kategoriaw"><br /></div></div>
						<div class="category">Higiena:<div class="kategoriaw"><br /></div></div>
						<div class="category">Dzieci:<div class="kategoriaw"><br /></div></div>
						<div class="category">Rozrywka:<div class="kategoriaw"><br /></div></div>
						<div class="category">Wycieczka:<div class="kategoriaw"><br /></div></div>
						<div class="category">Szkolenia:<div class="kategoriaw"><br /></div></div>
						<div class="category">Książki:<div class="kategoriaw"><br /></div></div>
						<div class="category">Oszczędności:<div class="kategoriaw"><br /></div></div>
						<div class="category">Emerytura:<div class="kategoriaw"><br /></div></div>
						<div class="category">Spłata długów:<div class="kategoriaw"><br /></div></div>
						<div class="category">Darowizna:<div class="kategoriaw"><br /></div></div>
						<div class="category">Inne wydatki:<div class="kategoriaw"><br /></div></div>
						
						</td> 
		</tr>
	</table>
	
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

</body>
</html>