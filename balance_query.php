<?php

	$user_id = $_SESSION['id'];
	
	require_once "database.php";
	
	//Odsetki bankowe
	$income_category = "Odsetki bankowe";
	$sql_check_category_id = 'SELECT id FROM incomes_category_assigned_to_users WHERE user_id = :user_id AND name = :income_category';
	$query_category_id = $db->prepare($sql_check_category_id);
	$query_category_id->bindValue(':user_id', $user_id, PDO::PARAM_STR);
	$query_category_id->bindValue(':income_category', $income_category, PDO::PARAM_STR);
	$query_category_id->execute();
	
	$result = $query_category_id->fetch();
	//var_dump($income_id);
	$income_id = $result[0];
	
	$sql_check_income_amount = 'SELECT amount FROM incomes WHERE user_id = :user_id AND income_category_assigned_to_user_id = :income_id';
	$query_check_income_amount = $db->prepare($sql_check_income_amount);
	$query_check_income_amount->bindValue(':user_id', $user_id, PDO::PARAM_STR);
	$query_check_income_amount->bindValue(':income_id', $income_id, PDO::PARAM_STR);
	$query_check_income_amount->execute();
	
	$result1 = $query_check_income_amount->fetch();
	//var_dump($income_id);
	$income_amount = $result1[0];
	$_SESSION['income_amount'] = $income_amount;
						
?>