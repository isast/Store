<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<?php
	include('db_config.php');
	$resultmonth = $db->prepare("SELECT * FROM accounts WHERE moved_on >= DATE_FORMAT (CURRENT_DATE - INTERVAL 1 MONTH, '%Y/%m/01' ) AND moved_on <= DATE_FORMAT(CURRENT_DATE , '%Y/%m/01' )");
	$resultmonth->execute();
	
	
	?>
	<h2>ACCOUNTS MOVED IN LAST MONTH</h2>
	<table>
			<tr>
				<th>Account ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>EMAIL</th>
				<th>Account Type</th>
				<th>Active?</th>
				<th>Place</th>
				<th>Last moved on</th>
			</tr>
			<?php
			for($i = 0; $row = $resultmonth->fetch(); $i++){
				
				?>
				<tr>
						<td><?php echo $row["id"]?>
						<td><?php echo $row["first_name"]?>
						<td><?php echo $row["last_name"]?>
						<td><?php echo $row["email"]?>
						<td><?php if($row["account_type_id"] == 1){$account = "basic";}
									elseif($row["account_type_id"] == 2){$account = "super";}
									elseif($row["account_type_id"] == 3){$account = "premium";}echo $account ?>
						<td><?php if($row["active"] == 0){echo 'INACTIVE';}
									else{echo 'ACTIVE';}?>
						<td><?php if($row["place_id"] == 1){$place = "Confirmation";}
									elseif($row["place_id"] == 2){$place = "Setup";}
									elseif($row["place_id"] == 3){$place = "Activated";}
									elseif($row["place_id"] == 4){$place = "Deactivated";}echo $place ?>
						<td><?php echo $row["moved_on"] ?>
						<td>
							<?php
								if ($row["place_id"] == 1){ ?>
									<a href="to_setup.php?id=<?php echo $row['id']; ?>">Transition to Setup</a>
							<?php }elseif ($row["place_id"] == 2){ ?>
									<a href="activate.php?id=<?php echo $row['id']; ?>">Transition activate</a>
									<a href="deactivate.php?id=<?php echo $row["id"]; ?>">Transition cancel</a>
							<?php }elseif ($row["place_id"] == 3){ ?>
									<a href="deactivate.php?id=<?php echo $row['id']; ?>">Transition deactivate</a>
							<?php }?>
							
							
							
					</tr>
			<?php }?>	
	</table>
	
	<?php
	$resultweek = $db->prepare("SELECT * FROM accounts WHERE moved_on >= (NOW() - INTERVAL 8 DAY)");
	$resultweek->execute();
	
	
	?>
	<h2>ACCOUNTS MOVED IN LAST WEEK</h2>
	<table>
			<tr>
				<th>Account ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>EMAIL</th>
				<th>Account Type</th>
				<th>Active?</th>
				<th>Place</th>
				<th>Last moved on</th>
			</tr>
			<?php
			for($i = 0; $row = $resultweek->fetch(); $i++){
				
				?>
				<tr>
						<td><?php echo $row["id"]?>
						<td><?php echo $row["first_name"]?>
						<td><?php echo $row["last_name"]?>
						<td><?php echo $row["email"]?>
						<td><?php if($row["account_type_id"] == 1){$account = "basic";}
									elseif($row["account_type_id"] == 2){$account = "super";}
									elseif($row["account_type_id"] == 3){$account = "premium";}echo $account ?>
						<td><?php if($row["active"] == 0){echo 'INACTIVE';}
									else{echo 'ACTIVE';}?>
						<td><?php if($row["place_id"] == 1){$place = "Confirmation";}
									elseif($row["place_id"] == 2){$place = "Setup";}
									elseif($row["place_id"] == 3){$place = "Activated";}
									elseif($row["place_id"] == 4){$place = "Deactivated";}echo $place ?>
						<td><?php echo $row["moved_on"] ?>
						<td>
							<?php
								if ($row["place_id"] == 1){ ?>
									<a href="to_setup.php?id=<?php echo $row['id']; ?>">Transition to Setup</a>
							<?php }elseif ($row["place_id"] == 2){ ?>
									<a href="activate.php?id=<?php echo $row['id']; ?>">Transition activate</a>
									<a href="deactivate.php?id=<?php echo $row["id"]; ?>">Transition cancel</a>
							<?php }elseif ($row["place_id"] == 3){ ?>
									<a href="deactivate.php?id=<?php echo $row['id']; ?>">Transition deactivate</a>
							<?php }?>
							
							
							
					</tr>
			<?php }?>	
	</table>
	<?php
	$resultday = $db->prepare("SELECT * FROM accounts WHERE moved_on >= (NOW() - INTERVAL 2 DAY)");
	$resultday->execute();
	
	
	?>
	<h2>ACCOUNTS MOVED IN LAST DAY</h2>
	<table>
			<tr>
				<th>Account ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>EMAIL</th>
				<th>Account Type</th>
				<th>Active?</th>
				<th>Place</th>
				<th>Last moved on</th>
			</tr>
			<?php
			for($i = 0; $row = $resultday->fetch(); $i++){
				
				?>
				<tr>
						<td><?php echo $row["id"]?>
						<td><?php echo $row["first_name"]?>
						<td><?php echo $row["last_name"]?>
						<td><?php echo $row["email"]?>
						<td><?php if($row["account_type_id"] == 1){$account = "basic";}
									elseif($row["account_type_id"] == 2){$account = "super";}
									elseif($row["account_type_id"] == 3){$account = "premium";}echo $account ?>
						<td><?php if($row["active"] == 0){echo 'INACTIVE';}
									else{echo 'ACTIVE';}?>
						<td><?php if($row["place_id"] == 1){$place = "Confirmation";}
									elseif($row["place_id"] == 2){$place = "Setup";}
									elseif($row["place_id"] == 3){$place = "Activated";}
									elseif($row["place_id"] == 4){$place = "Deactivated";}echo $place ?>
						<td><?php echo $row["moved_on"] ?>
						<td>
							<?php
								if ($row["place_id"] == 1){ ?>
									<a href="to_setup.php?id=<?php echo $row['id']; ?>">Transition to Setup</a>
							<?php }elseif ($row["place_id"] == 2){ ?>
									<a href="activate.php?id=<?php echo $row['id']; ?>">Transition activate</a>
									<a href="deactivate.php?id=<?php echo $row["id"]; ?>">Transition cancel</a>
							<?php }elseif ($row["place_id"] == 3){ ?>
									<a href="deactivate.php?id=<?php echo $row['id']; ?>">Transition deactivate</a>
							<?php }?>
							
							
							
					</tr>
			<?php }?>	
	</table>
	<h2><a href="manage.php">Manage Accounts</a></h2>
</body>
</html>