<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
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
			include('db_config.php');
			$result = $db->prepare("SELECT * FROM accounts WHERE place_id = 2 OR place_id = 4 ORDER BY id DESC");
			$result->execute();
			for($i = 0; $row = $result->fetch(); $i++){
				
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
								if ($row["place_id"] == 2 || 4){ ?>
									<a href="to_reset.php?id=<?php echo $row['id']; ?>">Reset</a>
							<?php }?>
							
							
							
					</tr>
			<?php }?>	
	</table>
	<h2><a href="manage.php">Manage Accounts</a></h2>
</body>
</html>