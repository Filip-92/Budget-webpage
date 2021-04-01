<?php 

		  session_start();
			
          require_once 'database.php';
          $id_user = $_SESSION['id'];   
		  $current_date = date('Y-m-d');
          $month = date("m", strtotime($current_date));
		  $previous_month = $month - 1;	
		  $current_year = date("Y", strtotime($current_date));
		  //$starting_date = $_POST['starting_date'];
		  //$ending_date = $_POST['ending_date'];
		  
		  $date_of_transaction = $_POST['date_of_transaction'];		  
		  
			if ($date_of_transaction == 'previous_month')
			{
				header('Location: balance_last_month.php');
				exit();
			}
			
			if ($date_of_transaction == 'current_year')
			}   											
				header('Location: balance_this_year.php');
				exit();
			}
			
		  //Poprzedni miesiąc	
		  if ($date_of_transaction == 'previous_month')
		  {
		  $sql_balance_incomes = "SELECT category_incomes.name as Category, SUM(incomes.amount) as Amount FROM incomes INNER JOIN incomes_category_assigned_to_users as category_incomes WHERE incomes.income_category_assigned_to_user_id = category_incomes.id AND incomes.user_id= :id_user AND Month(date_of_income) = :previous_month GROUP BY Category ORDER BY Amount DESC";
		  $query_select_incomes_sum = $db->prepare($sql_balance_incomes);
		  $query_select_incomes_sum->bindValue(':id_user', $id_user, PDO::PARAM_INT);
		  $query_select_incomes_sum->bindValue(':previous_month', $previous_month, PDO::PARAM_INT);                                
		  $query_select_incomes_sum->execute();
						
		  $result_sum_of_incomes = $query_select_incomes_sum->fetchAll();
						
				foreach($result_sum_of_incomes as $previous_month_incomes)
				{
					$sql_incomes_details = "SELECT incomes.date_of_income as Date, incomes.income_comment as Comment, incomes.amount as Amount FROM incomes INNER JOIN incomes_category_assigned_to_users as category_incomes WHERE incomes.income_category_assigned_to_user_id = category_incomes.id AND incomes.user_id= :id_user AND Month(date_of_income) = :previous_month AND category_incomes.name = :category_name ORDER BY Date";
					$query_select_incomes_details = $db->prepare($sql_incomes_details);
					$query_select_incomes_details->bindValue(':id_user', $id_user, PDO::PARAM_INT);
					$query_select_incomes_details->bindValue(':previous_month', $previous_month, PDO::PARAM_INT);   
					$query_select_incomes_details->bindValue(':category_name', $previous_month_incomes[0], PDO::PARAM_INT);   
					$query_select_incomes_details->execute();

					$result_details_of_incomes = $query_select_incomes_details->fetchAll();
					
					$_SESSION['result_details_of_incomes'] = $result_details_of_incomes;

					 echo '<div class="card-header">'.$previous_month_incomes[0].': '.$previous_month_incomes[1].'zł'.'</div>';
					 
					 $_SESSION['previous_month_incomes1'] = $previous_month_incomes[0];
					 $_SESSION['previous_month_incomes2'] = $previous_month_incomes[1];
					 
					 foreach($result_details_of_incomes as $previous_month_incomes_details)
					{
						  echo '<ul class="list-group list-group-flush"><li class="list-group-item"><i class="fas fa-long-arrow-alt-right"></i>'.' '.$previous_month_incomes_details[0].' - '.$previous_month_incomes_details[1].': '.$previous_month_incomes_details[2].'zł '.'<i class="fas fa-edit"></i><i class="fas fa-trash-alt ml-1"></i> </li></ul>'; 

							$_SESSION['previous_month_income_details'] = $previous_month_incomes_details;
							$_SESSION['previous_month_incomes_details_date'] = $previous_month_incomes_details[0];
							$_SESSION['previous_month_incomes_details_comment'] = $previous_month_incomes_details[1];
							$_SESSION['previous_month_incomes_details_amount'] = $previous_month_incomes_details[2];
					}      
				}  

		$sql_balance_expenses = "SELECT category_expenses.name as Category, SUM(expenses.amount) as Amount FROM expenses INNER JOIN expenses_category_assigned_to_users as category_expenses WHERE expenses.expense_category_assigned_to_user_id = category_expenses.id AND expenses.user_id= :id_user AND Month(date_of_expense) = :previous_month GROUP BY Category ORDER BY Amount DESC";
		  $query_select_expenses_sum = $db->prepare($sql_balance_expenses);
		  $query_select_expenses_sum->bindValue(':id_user', $id_user, PDO::PARAM_INT);
		  $query_select_expenses_sum->bindValue(':previous_month', $previous_month, PDO::PARAM_INT);                                
		  $query_select_expenses_sum->execute();
						
		  $result_sum_of_expenses = $query_select_expenses_sum->fetchAll();
	
		foreach($result_sum_of_expenses as $previous_month_expenses)
		{
			$sql_expenses_details = "SELECT expenses.date_of_expense as Date, expenses.expense_comment as Comment, expenses.amount as Amount FROM expenses INNER JOIN expenses_category_assigned_to_users as category_expenses WHERE expenses.expense_category_assigned_to_user_id = category_expenses.id AND expenses.user_id= :id_user AND Month(date_of_expense) = :previous_month AND category_expenses.name = :category_name ORDER BY Date";
			$query_select_expenses_details = $db->prepare($sql_expenses_details);
			$query_select_expenses_details->bindValue(':id_user', $id_user, PDO::PARAM_INT);
			$query_select_expenses_details->bindValue(':previous_month', $previous_month, PDO::PARAM_INT);   
			$query_select_expenses_details->bindValue(':category_name', $previous_month_expenses[0], PDO::PARAM_INT);   
			$query_select_expenses_details->execute();

			$result_details_of_expenses = $query_select_expenses_details->fetchAll();

			echo '<div class="card-header">'.$previous_month_expenses[0].': '.$previous_month_expenses[1].'zł'.'</div>';
			
			 $_SESSION['previous_month_expenses1'] = $previous_month_expenses[0];
			 $_SESSION['previous_month_expenses2'] = $previous_month_expenses[1];
			 
			 foreach($result_details_of_expenses as $previous_month_expenses_details)
			{
				  echo '<ul class="list-group list-group-flush"><li class="list-group-item"><i class="fas fa-long-arrow-alt-right"></i>'.' '.$previous_month_expenses_details[0].' - '.$previous_month_expenses_details[1].': '.$expenses_details[2].'zł '.'<i class="fas fa-edit"></i><i class="fas fa-trash-alt ml-1"></i> </li></ul>'; 
									
				$_SESSION['previous_month_expenses_details_date'] = $previous_month_expenses_details[0];
				$_SESSION['previous_month_expenses_details_comment'] = $previous_month_expenses_details[1];
				$_SESSION['previous_month_expenses_details_amount'] = $previous_month_expenses_details[2];										
			}      
		}   											
			header('Location: balance_last_month.php');
			exit();
			}
			
			//Bieżący rok
			if ($date_of_transaction == 'current_year')
			{
		  $sql_balance_incomes = "SELECT category_incomes.name as Category, SUM(incomes.amount) as Amount FROM incomes INNER JOIN incomes_category_assigned_to_users as category_incomes WHERE incomes.income_category_assigned_to_user_id = category_incomes.id AND incomes.user_id= :id_user AND Month(date_of_income) = :current_year GROUP BY Category ORDER BY Amount DESC";
		  $query_select_incomes_sum = $db->prepare($sql_balance_incomes);
		  $query_select_incomes_sum->bindValue(':id_user', $id_user, PDO::PARAM_INT);
		  $query_select_incomes_sum->bindValue(':current_year', $current_year, PDO::PARAM_INT);                                
		  $query_select_incomes_sum->execute();
						
		  $result_sum_of_incomes = $query_select_incomes_sum->fetchAll();
						
				foreach($result_sum_of_incomes as $month_incomes)
				{
					$sql_incomes_details = "SELECT incomes.date_of_income as Date, incomes.income_comment as Comment, incomes.amount as Amount FROM incomes INNER JOIN incomes_category_assigned_to_users as category_incomes WHERE incomes.income_category_assigned_to_user_id = category_incomes.id AND incomes.user_id= :id_user AND Month(date_of_income) = :current_year AND category_incomes.name = :category_name ORDER BY Date";
					$query_select_incomes_details = $db->prepare($sql_incomes_details);
					$query_select_incomes_details->bindValue(':id_user', $id_user, PDO::PARAM_INT);
					$query_select_incomes_details->bindValue(':current_year', $current_year, PDO::PARAM_INT);   
					$query_select_incomes_details->bindValue(':category_name', $current_year_incomes[0], PDO::PARAM_INT);   
					$query_select_incomes_details->execute();

					$result_details_of_incomes = $query_select_incomes_details->fetchAll();
					
					$_SESSION['result_details_of_incomes'] = $result_details_of_incomes;

					 echo '<div class="card-header">'.$current_year_incomes[0].': '.$current_year_incomes[1].'zł'.'</div>';
					 
					 $_SESSION['current_year_incomes1'] = $current_year_incomes[0];
					 $_SESSION['current_year_incomes2'] = $current_year_incomes[1];
					 
					 foreach($result_details_of_incomes as $current_year_incomes_details)
					{
						  echo '<ul class="list-group list-group-flush"><li class="list-group-item"><i class="fas fa-long-arrow-alt-right"></i>'.' '.$current_year_incomes_details[0].' - '.$current_year_incomes_details[1].': '.$current_year_incomes_details[2].'zł '.'<i class="fas fa-edit"></i><i class="fas fa-trash-alt ml-1"></i> </li></ul>'; 

							$_SESSION['current_year_income_details'] = $current_year_incomes_details;
							$_SESSION['current_year_incomes_details_date'] = $current_year_incomes_details[0];
							$_SESSION['current_year_incomes_details_comment'] = $current_year_incomes_details[1];
							$_SESSION['current_year_incomes_details_amount'] = $current_year_incomes_details[2];
					}      
				}  

		$sql_balance_expenses = "SELECT category_expenses.name as Category, SUM(expenses.amount) as Amount FROM expenses INNER JOIN expenses_category_assigned_to_users as category_expenses WHERE expenses.expense_category_assigned_to_user_id = category_expenses.id AND expenses.user_id= :id_user AND Month(date_of_expense) = :current_year GROUP BY Category ORDER BY Amount DESC";
		  $query_select_expenses_sum = $db->prepare($sql_balance_expenses);
		  $query_select_expenses_sum->bindValue(':id_user', $id_user, PDO::PARAM_INT);
		  $query_select_expenses_sum->bindValue(':current_year', $current_year, PDO::PARAM_INT);                                
		  $query_select_expenses_sum->execute();
						
		  $result_sum_of_expenses = $query_select_expenses_sum->fetchAll();
	
		foreach($result_sum_of_expenses as $current_year_expenses)
		{
			$sql_expenses_details = "SELECT expenses.date_of_expense as Date, expenses.expense_comment as Comment, expenses.amount as Amount FROM expenses INNER JOIN expenses_category_assigned_to_users as category_expenses WHERE expenses.expense_category_assigned_to_user_id = category_expenses.id AND expenses.user_id= :id_user AND Month(date_of_expense) = :current_year AND category_expenses.name = :category_name ORDER BY Date";
			$query_select_expenses_details = $db->prepare($sql_expenses_details);
			$query_select_expenses_details->bindValue(':id_user', $id_user, PDO::PARAM_INT);
			$query_select_expenses_details->bindValue(':current_year', $current_year, PDO::PARAM_INT);   
			$query_select_expenses_details->bindValue(':category_name', $current_year_expenses[0], PDO::PARAM_INT);   
			$query_select_expenses_details->execute();

			$result_details_of_expenses = $query_select_expenses_details->fetchAll();

			echo '<div class="card-header">'.$current_year_expenses[0].': '.$current_year_expenses[1].'zł'.'</div>';
			
			 $_SESSION['current_year_expenses1'] = $current_year_expenses[0];
			 $_SESSION['current_year_expenses2'] = $current_year_expenses[1];
			 
				 foreach($result_details_of_expenses as $current_year_expenses_details)
				{
					  echo '<ul class="list-group list-group-flush"><li class="list-group-item"><i class="fas fa-long-arrow-alt-right"></i>'.' '.$current_year_expenses_details[0].' - '.$current_year_expenses_details[1].': '.$expenses_details[2].'zł '.'<i class="fas fa-edit"></i><i class="fas fa-trash-alt ml-1"></i> </li></ul>'; 
										
					$_SESSION['current_year_expenses_details_date'] = $current_year_expenses_details[0];
					$_SESSION['current_year_expenses_details_comment'] = $current_year_expenses_details[1];
					$_SESSION['current_year_expenses_details_amount'] = $current_year_expenses_details[2];										
				}      
			}   											
			header('Location: balance_this_year.php');
			exit();
			}
			
			if ($date_of_transaction == 'custom_date')
			{
			header('Location: balance_custom_date.php');
			exit();
			}
                    
		   //Bieżący miesiąc
			if ($date_of_transaction == 'current_month')
			{
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
				$query_select_incomes_details->bindValue(':category_name', $month_incomes[0], PDO::PARAM_INT);   
				$query_select_incomes_details->execute();

				$result_details_of_incomes = $query_select_incomes_details->fetchAll();
				
				$_SESSION['result_details_of_incomes'] = $result_details_of_incomes;

				 echo '<div class="card-header">'.$month_incomes[0].': '.$month_incomes[1].'zł'.'</div>';
				 $_SESSION['month_incomes1'] = $month_incomes[0];
				 $_SESSION['month_incomes2'] = $month_incomes[1];
				 
				 foreach($result_details_of_incomes as $incomes_details)
				{
					  echo '<ul class="list-group list-group-flush"><li class="list-group-item"><i class="fas fa-long-arrow-alt-right"></i>'.' '.$incomes_details[0].' - '.$incomes_details[1].': '.$incomes_details[2].'zł '.'<i class="fas fa-edit"></i><i class="fas fa-trash-alt ml-1"></i> </li></ul>'; 

						$_SESSION['income_details'] = $incomes_details;
						$_SESSION['incomes_details_date'] = $incomes_details[0];
						$_SESSION['incomes_details_comment'] = $incomes_details[1];
						$_SESSION['incomes_details_amount'] = $incomes_details[2];
				}      
			}  

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

					echo '<div class="card-header">'.$month_expenses[0].': '.$month_expenses[1].'zł'.'</div>';
					 $_SESSION['month_expenses1'] = $month_expenses[0];
					 $_SESSION['month_expenses2'] = $month_expenses[1];
					 
					 foreach($result_details_of_expenses as $expenses_details)
					{
						  echo '<ul class="list-group list-group-flush"><li class="list-group-item"><i class="fas fa-long-arrow-alt-right"></i>'.' '.$expenses_details[0].' - '.$expenses_details[1].': '.$expenses_details[2].'zł '.'<i class="fas fa-edit"></i><i class="fas fa-trash-alt ml-1"></i> </li></ul>'; 

							$_SESSION['expenses_details_date'] = $expenses_details[0];
							$_SESSION['expenses_details_comment'] = $expenses_details[1];
							$_SESSION['expenses_details_amount'] = $expenses_details[2];
					}      
				}  
				
			header('Location: balance_default.php');
			exit();
			}							

		  
                                                                               
 ?>   