<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<?php 
include('db_config.php');
		$id=$_GET['id'];
		$date = date('Y/m/d h:i:s a');
		$stmt = $db->prepare("UPDATE accounts SET place_id= 3, active= '1', moved_on='$date' WHERE id='$id'");
		
		$stmt->execute();
		
		header('Location: manage.php');	
?>
</body>
</html>