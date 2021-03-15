<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title>Strona główna</title>
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
			
				<a class="navbar-brand" href="index.html"><img src="img/money.png" width="40" height="35" class="d-inline-block mr-1 align-center mx-2" alt=""> Budżet-Manager </a>
			
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
					<span class="navbar-toggler-icon"></span>
				</button>
			
				<div class="collapse navbar-collapse align-items-start" id="mainmenu">
			
				<ul class="navbar-nav mr-auto menu">
					<li class="nav-item">
						<a class="nav-link" href="przychody.php">Dodaj przychód</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" href="wydatki.php">Dodaj wydatek</a>
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
	
			<h1 class="logo1 text-center myclass m-auto"><a href="index.html" class="link" title="Strona główna"><img src="img/wallet.png" width="60" height="40" alt="portfel"/>Zarządzaj swoim budżetem<img src="img/wallet.png" width="60" height="40" alt="portfel"/></a></h1>
					
	</div>
		
		</header>
		
			<main>
	
				<article>
		
					<section>
		
						<div class="categories">
				
							<header>
			
								<form action="index.html" method="post">
								
									<h1 class="mt-3">Dodaj wydatek:</h1>
						
									<div id="formId" class="justify-content-center row">
									
										<label class="col-form-label" >Kwota: </label><input id="kategoria" type="number" placeholder="21.37" onfocus="this.placeholder=' ' " onblur="this.placeholder='21.37' " name="kwota" step="0.01"	style="margin-right: 0px;">
								
										<label class="col-form-label"> Data wydatku:</label><input type="date" name="data" value="<?php echo date('Y-m-d'); ?>" class="col-form-label" style="margin-top: 5px; margin-right: 0px;">
									
										<label for="płatność" class="col-form-label"> Sposób płatności: </label>
										<select id="płatność" name="płatność" style="margin-top: 5px; margin-right: 0px;">
											<option value="g" selected>Gotówka</option>
											<option value="d">Karta debetowa</option>
											<option value="k">Karta kredytowa</option>
										</select>
								
										<label for="kategoria" class="col-form-label"> Kategoria: </label>
										<select id="kategoria" name="kategoria" style="margin-top: 5px; margin-right: 0px;">
												<option value="j" selected>Jedzenie</option>
												<option value="m">Mieszkanie</option>
												<option value="t">Transport</option>
												<option value="tk">Telekomunikacja</option>
												<option value="oz">Opieka zdrowotna</option>
												<option value="u">Ubranie</option>
												<option value="h">Higiena</option>
												<option value="dz">Dzieci</option>
												<option value="r">Rozrywka</option>
												<option value="w">Wycieczka</option>
												<option value="s">Szkolenia</option>
												<option value="k">Książki</option>
												<option value="o">Oszczędności</option>
												<option value="e">Emerytura</option>
												<option value="sd">Spłata długów</option>
												<option value="d">Darowizna</option>
												<option value="iw">Inne wydatki</option>
										</select>
									
										<label for="komentarz" class="col-form-label">Komentarz (opcjonalnie):</label><input id="komentarz" type="text" placeholder="inne" onfocus="this.placeholder=' ' " onblur="this.placeholder='inne'" class="col-form" style="margin-top: 5px; margin-right: 0px;">
									
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
