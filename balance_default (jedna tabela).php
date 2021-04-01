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
			
									<form action="balance_default.php" method="post">

										<div id="formId" class="justify-content-center row">
								
										<label class="col-form-label">Okres zdefiniowany:</label>
										<select id="płatność" name="date_of_transaction" class="col-lg-12">
												<option value="current_month" selected>Bieżący miesiąc</option>
												<?php
													$date_of_transaction = $_POST['date_of_transaction'];	
													
													if ($date_of_transaction == 'current_month')
													{
													header('Location: balance_default.php');
													exit();
													}
												?>
												<option value="previous_month">Poprzedni miesiąc</option>
												<?php
													if ($date_of_transaction == 'previous_month')
													{
													header('Location: balance_last_month.php');
													exit();
													}
												?>
												<option value="current_year">Bieżący rok</option>
												<?php
													if ($date_of_transaction == 'current_year')
													{
													header('Location: balance_this_year.php');
													exit();
													}
												?>
												<option value="custom_date">Niestandardowy</option>
												<?php
													if ($date_of_transaction == 'custom_date')
													{
														if ((isset($_POST['starting_date'])) && (isset($_POST['ending_date'])))
														{
															$starting_date = $_POST['starting_date'];;
															$ending_date = $_POST['ending_date'];;

															$_SESSION['starting_date'] = $starting_date;
															$_SESSION['ending_date'] = $ending_date;
															
															header('Location: balance_custom_date.php');
															exit();
														}
													}
												?>
										</select>
										
										<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
										  <div class="modal-dialog" role="document">
											<div class="modal-content">
											  <div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											  </div>
											  <div class="modal-body">
													<div id="formId" class="justify-content-center row">
														<label class="col-form-label" style="text-decoration: underline; color: green;">Zakres dat:</label>
														<label class="col-form-label">Od:</label><input type="date" name="starting_date">
														<label class="col-form-label">Do:</label><input type="date" name="ending_date">
													</div>
											  </div>
											  <div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
												<button type="submit" class="btn btn-success">Wybierz zakres</button>
											  </div>
											</div><!-- /.modal-content -->
										  </div><!-- /.modal-dialog -->
										</div><!-- /.modal -->
						
										</div>
										
											<div class="justify-content-center">
													<input type="submit" value="Filtruj" class="col-form-label" style="margin-top: 20px; margin-bottom: 20px;">
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
											<div class="category">
													<div class="category_transaction_category">
															<h4>Kategoria: </h4>
													</div>
													<div class="category_amount">
															<h4>Wysokość przychodu: </h4>
													</div>
													<div class="category_date">
															<h4>Data:</h4>
													</div>
													<div class="category_comment">
															<h4>Komentarz: </h4>
													</div>
											</div>
											<div class="kategoriap">
												<?php
													  require_once 'database.php';
													  $id_user = $_SESSION['id'];   
													  $current_date = date('Y-m-d');
													  $month = date("m", strtotime($current_date));
													               
                                
                                $sql_balance_incomes = "SELECT category_incomes.name as Category, SUM(incomes.amount) as Amount FROM incomes INNER JOIN incomes_category_assigned_to_users as category_incomes WHERE incomes.income_category_assigned_to_user_id = category_incomes.id AND incomes.user_id= :id_user AND Month(date_of_income) = :month GROUP BY Category ORDER BY Amount DESC";
                                $query_select_incomes_sum = $db->prepare($sql_balance_incomes);
                                $query_select_incomes_sum->bindValue(':id_user', $id_user, PDO::PARAM_INT);
                                $query_select_incomes_sum->bindValue(':month', $month, PDO::PARAM_INT);                                
                                $query_select_incomes_sum->execute();
                            
                                $result_sum_of_incomes = $query_select_incomes_sum->fetchAll();
                            
                                foreach($result_sum_of_incomes as $month_incomes)
                                {
                                    $sql_incomes_details = "SELECT incomes.date_of_income as Date, incomes.income_comment as Comment, incomes.amount as Amount FROM incomes INNER JOIN incomes_category_assigned_to_users as category_incomes WHERE incomes.income_category_assigned_to_user_id = category_incomes.id AND incomes.user_id= :id_user AND Month(date_of_income) = :month AND category_incomes.name = :category_name ORDER BY Date";
                                    $query_select_incomes_details = $db->prepare($sql_incomes_details);
                                    $query_select_incomes_details->bindValue(':id_user', $id_user, PDO::PARAM_INT);
                                    $query_select_incomes_details->bindValue(':month', $month, PDO::PARAM_INT);   
                                    $query_select_incomes_details->bindValue(':category_name', $month_incomes[0], PDO::PARAM_INT);   $query_select_incomes_details->execute();

                                    $result_details_of_incomes = $query_select_incomes_details->fetchAll();

                                     echo '<div class="card-header">'.$month_incomes[0].': '.$month_incomes[1].'zł'.'</div>';
                                     foreach($result_details_of_incomes as $incomes_details)
                                    {
                                          echo '<ul class="list-group list-group-flush"><li class="list-group-item"><i class="fas fa-long-arrow-alt-right"></i>'.' '.$incomes_details[0].' - '.$incomes_details[1].': '.$incomes_details[2].'zł '.'<i class="fas fa-edit"></i><i class="fas fa-trash-alt ml-1"></i> </li></ul>';   
                                    }         
                                }                      
                                                                               
                            ?>    
											</div>
											<div style="clear:both;">
											</div>
											<h6 style="float: left;">Suma:
											<?php 
											echo $_SESSION['month_incomes2']; 
											?>
											</h6>
											<div style="clear:both;">
											</div>
										
											</td> 
				</tr>
				<tr>
						<td colspan="3" align="center" bgcolor="black">
						</td>
				</tr>
						<td width="60%" align="top">
			
						<h3>Wydatki</h3>
											<div class="category">
													<div class="category_transaction_category">
															<h4>Kategoria: </h4>
													</div>
													<div class="category_amount">
															<h4>Wysokość przychodu: </h4>
													</div>
													<div class="category_date">
															<h4>Data:</h4>
													</div>
													<div class="category_comment">
															<h4>Komentarz: </h4>
													</div>
											</div>
											<div class="kategoriaw">
												<div class="column_incomes_category">
												<?php
													  require_once 'database.php';
													  $id_user = $_SESSION['id'];   
													  $current_date = date('Y-m-d');
													  $month = date("m", strtotime($current_date));
													  
													  $sql_balance_expenses = "SELECT category_expenses.name as Category, SUM(expenses.amount) as Amount FROM expenses INNER JOIN expenses_category_assigned_to_users as category_expenses WHERE expenses.expense_category_assigned_to_user_id = category_expenses.id AND expenses.user_id= :id_user AND Month(date_of_expense) = :month GROUP BY Category ORDER BY Amount DESC";
													  $query_select_expenses_sum = $db->prepare($sql_balance_expenses);
													  $query_select_expenses_sum->bindValue(':id_user', $id_user, PDO::PARAM_INT);
													  $query_select_expenses_sum->bindValue(':month', $month, PDO::PARAM_INT);                                
													  $query_select_expenses_sum->execute();
																	
													  $result_sum_of_expenses = $query_select_expenses_sum->fetchAll();
																	
														foreach($result_sum_of_expenses as $month_expenses)
														{
															$sql_expenses_details = "SELECT expenses.date_of_expense as Date, expenses.expense_comment as Comment, expenses.amount as Amount FROM expenses INNER JOIN expenses_category_assigned_to_users as category_expenses WHERE expenses.expense_category_assigned_to_user_id = category_expenses.id AND expenses.user_id= :id_user AND Month(date_of_expense) = :month AND category_expenses.name = :category_name ORDER BY Date";
															$query_select_expenses_details = $db->prepare($sql_expenses_details);
															$query_select_expenses_details->bindValue(':id_user', $id_user, PDO::PARAM_INT);
															$query_select_expenses_details->bindValue(':month', $month, PDO::PARAM_INT);   
															$query_select_expenses_details->bindValue(':category_name', $month_expenses[0], PDO::PARAM_INT);   
															$query_select_expenses_details->execute();

															$result_details_of_expenses = $query_select_expenses_details->fetchAll();

															 echo '<div class="card-header">'.$month_incomes[0].': '.$month_incomes[1].'zł'.'</div>';
														}  
												?>
												</div>
												<div class="column_incomes_amount">
												<?php
												  require_once 'database.php';
												  $id_user = $_SESSION['id'];   
												  $current_date = date('Y-m-d');
												  $month = date("m", strtotime($current_date));
												  
												  $sql_balance_expenses = "SELECT category_expenses.name as Category, SUM(expenses.amount) as Amount FROM expenses INNER JOIN expenses_category_assigned_to_users as category_expenses WHERE expenses.expense_category_assigned_to_user_id = category_expenses.id AND expenses.user_id= :id_user AND Month(date_of_expense) = :month GROUP BY Category ORDER BY Amount DESC";
												  $query_select_expenses_sum = $db->prepare($sql_balance_expenses);
												  $query_select_expenses_sum->bindValue(':id_user', $id_user, PDO::PARAM_INT);
												  $query_select_expenses_sum->bindValue(':month', $month, PDO::PARAM_INT);                                
												  $query_select_expenses_sum->execute();
																
												  $result_sum_of_expenses = $query_select_expenses_sum->fetchAll();
																
													foreach($result_sum_of_expenses as $month_expenses)
													{
														$sql_expenses_details = "SELECT expenses.date_of_expense as Date, expenses.expense_comment as Comment, expenses.amount as Amount FROM expenses INNER JOIN expenses_category_assigned_to_users as category_expenses WHERE expenses.expense_category_assigned_to_user_id = category_expenses.id AND expenses.user_id= :id_user AND Month(date_of_expense) = :month AND category_expenses.name = :category_name ORDER BY Date";
														$query_select_expenses_details = $db->prepare($sql_expenses_details);
														$query_select_expenses_details->bindValue(':id_user', $id_user, PDO::PARAM_INT);
														$query_select_expenses_details->bindValue(':month', $month, PDO::PARAM_INT);   
														$query_select_expenses_details->bindValue(':category_name', $month_expenses[0], PDO::PARAM_INT);   
														$query_select_expenses_details->execute();

														$result_details_of_expenses = $query_select_expenses_details->fetchAll();
														 
														 foreach($result_details_of_expenses as $expenses_details)
														{
															  echo $expenses_details[1]; 
														}      
													}
												?>
												</div>
												<div class="column_incomes_date"> 
												<?php
													  require_once 'database.php';
													  $id_user = $_SESSION['id'];   
													  $current_date = date('Y-m-d');
													  $month = date("m", strtotime($current_date));
													  
													  $sql_balance_expenses = "SELECT category_expenses.name as Category, SUM(expenses.amount) as Amount FROM expenses INNER JOIN expenses_category_assigned_to_users as category_expenses WHERE expenses.expense_category_assigned_to_user_id = category_expenses.id AND expenses.user_id= :id_user AND Month(date_of_expense) = :month GROUP BY Category ORDER BY Amount DESC";
													  $query_select_expenses_sum = $db->prepare($sql_balance_expenses);
													  $query_select_expenses_sum->bindValue(':id_user', $id_user, PDO::PARAM_INT);
													  $query_select_expenses_sum->bindValue(':month', $month, PDO::PARAM_INT);                                
													  $query_select_expenses_sum->execute();
																	
													  $result_sum_of_expenses = $query_select_expenses_sum->fetchAll();
																	
														foreach($result_sum_of_expenses as $month_expenses)
														{
															$sql_expenses_details = "SELECT expenses.date_of_expense as Date, expenses.expense_comment as Comment, expenses.amount as Amount FROM expenses INNER JOIN expenses_category_assigned_to_users as category_expenses WHERE expenses.expense_category_assigned_to_user_id = category_expenses.id AND expenses.user_id= :id_user AND Month(date_of_expense) = :month AND category_expenses.name = :category_name ORDER BY Date";
															$query_select_expenses_details = $db->prepare($sql_expenses_details);
															$query_select_expenses_details->bindValue(':id_user', $id_user, PDO::PARAM_INT);
															$query_select_expenses_details->bindValue(':month', $month, PDO::PARAM_INT);   
															$query_select_expenses_details->bindValue(':category_name', $month_expenses[0], PDO::PARAM_INT);   
															$query_select_expenses_details->execute();

															$result_details_of_expenses = $query_select_expenses_details->fetchAll();
															
															 foreach($result_details_of_expenses as $expenses_details)
															{
																  echo $expenses_details[0]; 
															}      
														}
												?>
												</div>
												<div class="column_incomes_comment"> 
												<?php
													  require_once 'database.php';
													  $id_user = $_SESSION['id'];   
													  $current_date = date('Y-m-d');
													  $month = date("m", strtotime($current_date));
													  
													  $sql_balance_expenses = "SELECT category_expenses.name as Category, SUM(expenses.amount) as Amount FROM expenses INNER JOIN expenses_category_assigned_to_users as category_expenses WHERE expenses.expense_category_assigned_to_user_id = category_expenses.id AND expenses.user_id= :id_user AND Month(date_of_expense) = :month GROUP BY Category ORDER BY Amount DESC";
													  $query_select_expenses_sum = $db->prepare($sql_balance_expenses);
													  $query_select_expenses_sum->bindValue(':id_user', $id_user, PDO::PARAM_INT);
													  $query_select_expenses_sum->bindValue(':month', $month, PDO::PARAM_INT);                                
													  $query_select_expenses_sum->execute();
																	
													  $result_sum_of_expenses = $query_select_expenses_sum->fetchAll();
																	
														foreach($result_sum_of_expenses as $month_expenses)
														{
															$sql_expenses_details = "SELECT expenses.date_of_expense as Date, expenses.expense_comment as Comment, expenses.amount as Amount FROM expenses INNER JOIN expenses_category_assigned_to_users as category_expenses WHERE expenses.expense_category_assigned_to_user_id = category_expenses.id AND expenses.user_id= :id_user AND Month(date_of_expense) = :month AND category_expenses.name = :category_name ORDER BY Date";
															$query_select_expenses_details = $db->prepare($sql_expenses_details);
															$query_select_expenses_details->bindValue(':id_user', $id_user, PDO::PARAM_INT);
															$query_select_expenses_details->bindValue(':month', $month, PDO::PARAM_INT);   
															$query_select_expenses_details->bindValue(':category_name', $month_expenses[0], PDO::PARAM_INT);   
															$query_select_expenses_details->execute();

															$result_details_of_expenses = $query_select_expenses_details->fetchAll();
															
															 foreach($result_details_of_expenses as $expenses_details)
															{
																  echo $expenses_details[1]; 
															} 
														}															
												?>
												</div>
											</div>
							<div style="clear:both;">
							</div>
							<h6 style="float: left;">Suma:
									<?php 
										echo $_SESSION['month_expenses2']; 
									?>
							</h6>
							<div style="clear:both;">
							</div>
										
						</td> 
						
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
		
		<script src="modal.js"></script>

</body>
</html>