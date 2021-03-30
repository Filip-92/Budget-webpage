<?php 

		  session_start();
			
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

											$_SESSION['incomes_details_date'] = $incomes_details[0];
											$_SESSION['incomes_details_comment'] = $incomes_details[1];
											$_SESSION['incomes_details_amount'] = $incomes_details[2];
                                    }      
                                }      
                                                                               
                            ?>   