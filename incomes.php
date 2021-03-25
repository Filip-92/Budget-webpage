<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.html');
		exit();
	}
	
	$user_id = $_SESSION['id'];

	if (isset($_POST['kwota']))
	{
		$wszystko_OK=true;
		
		$amount = $_POST['kwota'];
		if($amount<0)
		{
		$amount = $amount*(-1);
		}
		if(!is_numeric($amount))
		{
			$wszystko_OK=false;
			$_SESSION['e_amount']="Musisz podać wartość będącą liczbą arabską";
			echo "Muka";
		}
		$amount = str_replace(',','.',$amount);
		
		$date = $_POST['data'];
		$today_date = date('Y-m-d');
		if($date > $today_date)
		{
			$wszystko_OK=false;
			$_SESSION['e_date']="Podaj datę nie wykraczającą w przyszłość poza dzień dzisiejszy";
			echo "Muka";
		}
		$income_category = $_POST['kategoria'];
		$comment = $_POST['komentarz'];
		
		require_once "database.php";
		
		try
		{
			//$_SESSION['kwota'] = $wiersz['kwota'];
			//$_SESSION['data'] = $wiersz['data'];
			//$_SESSION['kategoria'] = $wiersz['kategoria'];
			//$_SESSION['komentarz'] = $wiersz['komentarz'];
			if($wszystko_OK==true)
			{
				$sql_check_category_id = 'SELECT id FROM incomes_category_assigned_to_users WHERE user_id = :user_id AND name = :kategoria';
				$query_category_id = $db->prepare($sql_check_category_id);
				$query_category_id->bindValue(':user_id', $user_id, PDO::PARAM_STR);
				$query_category_id->bindValue(':kategoria', $income_category, PDO::PARAM_STR);
				$query_category_id->execute();
				
				$income_id = $query_category_id->fetch();
						
				$sql_income = "INSERT INTO incomes (id, user_id, income_category_assigned_to_user_id, amount, date_of_income, income_comment) VALUES (NULL, ':user_id', ':income_id', ':kwota', ':data', ':komentarz')";
			
				$query_incomes2 = $db->prepare($sql_income);
				$query_incomes2->bindValue(':user_id', $user_id, PDO::PARAM_STR);
				$query_incomes2->bindValue(':income_id', $income_id, PDO::PARAM_STR);
				$query_incomes2->bindValue(':kwota', $kwota, PDO::PARAM_STR);
				$query_incomes2->bindValue(':data', $date, PDO::PARAM_STR);
				$query_incomes2->bindValue(':komentarz', $comment, PDO::PARAM_STR);
				$query_incomes2->execute();
				
				var_dump($query_incomes2->fetchAll());
					
				$_SESSION['dodanoprzychod']=true;
				echo "Nowy przychód dodany";
				header('Location: index.php');
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

<body>

	<header>
	
		<nav class="navbar navbar-dark bg-navbar navbar-expand-lg">
			
				<a class="navbar-brand" href="index.php"><img src="img/money.png" width="40" height="35" class="d-inline-block mr-1 align-center mx-2" alt=""> Budżet-Manager</a>
			
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
					<span class="navbar-toggler-icon"></span>
				</button>
			
				<div class="collapse navbar-collapse align-items-start" id="mainmenu">
			
				<ul class="navbar-nav mr-auto menu">
					<li class="nav-item">
						<div class="nav-link active">Dodaj przychód</div>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="expenses.php">Dodaj wydatek</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="balance.html">Przeglądaj bilans</a>
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
			
								<form action="index.php" method="post">
								
									<h1 class="mt-3">Dodaj przychód:</h1>
														
									<div id="formId" class="justify-content-center row">	
									
										<label class="col-form-label" >Kwota: </label><input id="kategoria" type="number" placeholder="21.37" onfocus="this.placeholder=' ' " onblur="this.placeholder='21.37' " name="kwota" step='0.01' style="margin-right: 0px;">
										
										<?php
			
										if (isset($_SESSION['e_amount']))
										{
											echo '<div class="error">'.$_SESSION['e_amount'].'</div>';
											unset($_SESSION['e_amount']);
										}
			
										?>
										
										<label class="col-form-label"> Data przychodu:</label><input type="date" name="data" value="<?php echo date('Y-m-d'); ?>" style="margin-top: 5px; margin-right: 0px;">
										
										<?php
			
										if (isset($_SESSION['e_date']))
										{
											echo '<div class="error">'.$_SESSION['e_date'].'</div>';
											unset($_SESSION['e_date']);
										}
			
										?>
										
										<label for="kategoria" class="col-form-label" style="margin-top: 5px;"> Kategoria: </label>
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
