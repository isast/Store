<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>

	<h2>Add an Account</h2>
<form action="authenticate.php" method="post">
	<input type="text" name="f_name" placeholder="First Name"><br/>
	<input type="text" name="l_name" placeholder="Last Name"><br/>
	<input type="text" name="e_mail" placeholder="Email"><br/>
	<input type="radio" name="acc_type_id" value="1">1<br/>
	<input type="radio" name="acc_type_id" value="2">2<br/>
	<input type="radio" name="acc_type_id" value="3">3<br/>
	<button type="submit" name="submit">Submit</button>
</form>
	<h2><a href="manage.php">Manage Accounts</a></h2>
	
</body>
</html>