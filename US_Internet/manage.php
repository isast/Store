<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>


<?php
	include('db_config.php');
	$result = $db->prepare("SELECT * FROM accounts ORDER BY id DESC");
	$result->execute();
	
	
	?>
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
	<h2><a href="index.php">Add Accounts</a></h2>
	<h2><a href="by_place.php">View Accounts by place</a></h2>
	
	<h2><a href="reset.php">SEE DEATIVATED ACCOUNTS</a></h2>
	<h2><a href="recent.php">SEE recent moved accounts</a></h2>
</body>
</html>