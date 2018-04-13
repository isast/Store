<?php
if(isset($_POST['submit']))
{
	try
	{
		include('db_config.php');
		$date = date('m/d/Y h:i:s a');
		$stmt = $db->prepare("INSERT INTO accounts(first_name,last_name,email,account_type_id,active,place_id,moved_on)VALUES(:Fname,:Lname,:Email,:Account_type_id,:Active,:Place_id,:Moved_on)");
		
		$stmt->execute(array("Fname" => $_POST['f_name'],"Lname" =>$_POST['l_name'], "Email" => $_POST['e_mail'], "Account_type_id" => $_POST['acc_type_id'],"Active" => 'false', "Place_id" => 1, "Moved_on" => $date));
		
		header('Location: index.php');
	}
	catch(PDOException $e)
	{
		echo 'ERROR: ' . $e->getMessage();
	}
}
	?>


