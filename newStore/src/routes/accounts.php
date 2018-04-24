<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$app = new \Slim\App;

//get all accounts
$app->get('/api/accounts', function(Request $request, Response $response){
	$sql = "select * from store.accounts";
	
	try{
		
		// get db obj
		$db = new db();
		
		//connect
		$db = $db->connect();
		
		$stmt=$db->query($sql);
		
		echo "<form action='' method='post'><table>
			<tr>
				<th>Account ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>EMAIL</th>
				<th>Account Type</th>
				<th>Active?</th>
				<th>Place</th>
				<th>Last moved on</th>
			</tr>";
			while($row = $stmt->fetch(PDO::FETCH_OBJ)){
				echo '<tr>
						<td> ' . $row->id.'</td>
						<td>'. $row->first_name.'</td>
						<td>'. $row->last_name.'</td>
						<td>'. $row->email.'</td>
						<td>'; if($row->account_type_id == 1){$account = "basic";}
									elseif($row->account_type_id == 2){$account = "super";}
									elseif($row->account_type_id == 3){$account = "premium";}echo $account.'</td>
						<td>'; if($row->active == 0){ echo "INACTIVE";}
									else{echo "ACTIVE";}echo'</td>
						<td>'; if($row->place_id == 1){$place = "Confirmation";}
									elseif($row->place_id == 2){$place = "Setup";}
									elseif($row->place_id == 3){$place = "Activated";}
									elseif($row->place_id == 4){$place = "Deactivated";}echo $place.'</td>
						<td>'. $row->moved_on.'</td>
						<td>';
								if ($row->place_id == 1){ 
									echo '
									<a href="accounts/to_setup/'.$row->id.'">Transition to Setup</a>';
									
							}elseif ($row->place_id == 2){ 
									echo '
									<a href="accounts/activate/'.$row->id.'"> Transition to active</a>
									<a href="accounts/deactivate/'.$row->id.'">Transition cancel</a>';
									
							}elseif ($row->place_id == 3){ 
									echo '<a href="accounts/deactivate/'.$row->id.'">Transition to deactivate</a>';
							}
							
					echo '</tr>';
		
		}echo "</table></form>";
		
		$db = null;
	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'}';
	}
});

//Transition to setup
$app->put('/api/accounts/to_setup/{id}', function(Request $request, Response $response){
	$id = $request->getAttribute('id');
	$date = date('Y/m/d h:i:s a');
	$sql = "UPDATE store.accounts SET place_id= 2, moved_on='$date' WHERE id='$id'";
	try{
		// get db obj
		$db = new db();
		
		//connect
		$db = $db->connect();
		
		$stmt=$db->prepare($sql);
		$stmt->execute();
		echo '{"notice": {"text": "Account transitoned to setup"}';
		
	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'}';
	}
});


//Transition to active
$app->put('/api/accounts/activate/{id}', function(Request $request, Response $response){
	$id = $request->getAttribute('id');
	$date = date('Y/m/d h:i:s a');
	$sql = "UPDATE store.accounts SET place_id= 3, active= '1', moved_on='$date' WHERE id='$id'";
	try{
		// get db obj
		$db = new db();
		
		//connect
		$db = $db->connect();
		
		$stmt=$db->prepare($sql);
		$stmt->execute();
		echo '{"notice": {"text": "Account transitoned to active"}';
		
	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'}';
	}
});

//Transition to deactivate
$app->put('/api/accounts/deactivate/{id}', function(Request $request, Response $response){
	$id = $request->getAttribute('id');
	$date = date('Y/m/d h:i:s a');
	$sql = "UPDATE store.accounts SET place_id= 4,active='0', moved_on='$date' WHERE id='$id'";
	try{
		// get db obj
		$db = new db();
		
		//connect
		$db = $db->connect();
		
		$stmt=$db->prepare($sql);
		$stmt->execute();
		echo '{"notice": {"text": "Account transitoned to deactivate"}';
		
	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'}';
	}
});

//add account
$app->post('/api/add_account', function(Request $request, Response $response){
	$first_name = $request->getParam('first_name');
	$last_name = $request->getParam('last_name');
	$email = $request->getParam('email');
	$account_type_id = $request->getParam('account_type_id');
	$active = $request->getParam('active');
	$place_id = $request->getParam('place_id');
	$moved_on = $request->getPartam('moved_on');
	
	$sql = "INSERT INTO store.accounts(first_name,last_name,email,account_type_id,active,place_id,moved_on) VALUES(:first_name,:last_name,:email,:account_type_id,:active,:place_id,:moved_on)";
	
	try{
		// get db obj
		$db = new db();
		
		//connect
		$db = $db->connect();
		
		$stmt=$db->prepare($sql);
		
		$stmt->bindParam(':first_name', 	$first_name);
		$stmt->bindParam(':last_name', 		$last_name);
		$stmt->bindParam(':email', 			$email);
		$stmt->bindParam(':account_type_id',$account_type_id);
		$stmt->bindParam(':active', 		$active);
		$stmt->bindParam(':place_id', 		$place_id);
		$stmt->bindParam(':moved_on', 		$moved_on);
		
		$stmt->execute();
		
		echo '{"notice": {"text": "Account created"}';
		
	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'}';
	}
});


//list accounts by place
//place: confirmation
$app->get('/api/accounts_confirmation', function(Request $request, Response $response){
	$sql = "SELECT * FROM store.accounts WHERE place_id = 1 ORDER BY id DESC";
	
	try{
		
		// get db obj
		$db = new db();
		
		//connect
		$db = $db->connect();
		
		$stmt=$db->query($sql);
		
		echo "<form action='' method='post'><table>
			<tr>
				<th>Account ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>EMAIL</th>
				<th>Account Type</th>
				<th>Active?</th>
				<th>Place</th>
				<th>Last moved on</th>
			</tr>";
			while($row = $stmt->fetch(PDO::FETCH_OBJ)){
				echo '<tr>
						<td> ' . $row->id.'</td>
						<td>'. $row->first_name.'</td>
						<td>'. $row->last_name.'</td>
						<td>'. $row->email.'</td>
						<td>'; if($row->account_type_id == 1){$account = "basic";}
									elseif($row->account_type_id == 2){$account = "super";}
									elseif($row->account_type_id == 3){$account = "premium";}echo $account.'</td>
						<td>'; if($row->active == 0){ echo "INACTIVE";}
									else{echo "ACTIVE";}echo'</td>
						<td>'; if($row->place_id == 1){$place = "Confirmation";}
									elseif($row->place_id == 2){$place = "Setup";}
									elseif($row->place_id == 3){$place = "Activated";}
									elseif($row->place_id == 4){$place = "Deactivated";}echo $place.'</td>
						<td>'. $row->moved_on.'</td>
						<td>';
								if ($row->place_id == 1){ 
									echo '
									<a href="accounts/to_setup/'.$row->id.'">Transition to Setup</a>';
									
							}elseif ($row->place_id == 2){ 
									echo '
									<a href="accounts/activate/'.$row->id.'"> Transition to active</a>
									<a href="accounts/deactivate/'.$row->id.'">Transition cancel</a>';
									
							}elseif ($row->place_id == 3){ 
									echo '<a href="accounts/deactivate/'.$row->id.'">Transition to deactivate</a>';
							}
							
					echo '</tr>';
		
		}echo "</table></form>";
		
		$db = null;
	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'}';
	}
});
//place: setup
$app->get('/api/accounts_setup', function(Request $request, Response $response){
	$sql = "SELECT * FROM store.accounts WHERE place_id = 2 ORDER BY id DESC";
	
	try{
		
		// get db obj
		$db = new db();
		
		//connect
		$db = $db->connect();
		
		$stmt=$db->query($sql);
		
		echo "<form action='' method='post'><table>
			<tr>
				<th>Account ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>EMAIL</th>
				<th>Account Type</th>
				<th>Active?</th>
				<th>Place</th>
				<th>Last moved on</th>
			</tr>";
			while($row = $stmt->fetch(PDO::FETCH_OBJ)){
				echo '<tr>
						<td> ' . $row->id.'</td>
						<td>'. $row->first_name.'</td>
						<td>'. $row->last_name.'</td>
						<td>'. $row->email.'</td>
						<td>'; if($row->account_type_id == 1){$account = "basic";}
									elseif($row->account_type_id == 2){$account = "super";}
									elseif($row->account_type_id == 3){$account = "premium";}echo $account.'</td>
						<td>'; if($row->active == 0){ echo "INACTIVE";}
									else{echo "ACTIVE";}echo'</td>
						<td>'; if($row->place_id == 1){$place = "Confirmation";}
									elseif($row->place_id == 2){$place = "Setup";}
									elseif($row->place_id == 3){$place = "Activated";}
									elseif($row->place_id == 4){$place = "Deactivated";}echo $place.'</td>
						<td>'. $row->moved_on.'</td>
						<td>';
								if ($row->place_id == 1){ 
									echo '
									<a href="accounts/to_setup/'.$row->id.'">Transition to Setup</a>';
									
							}elseif ($row->place_id == 2){ 
									echo '
									<a href="accounts/activate/'.$row->id.'"> Transition to active</a>
									<a href="accounts/deactivate/'.$row->id.'">Transition cancel</a>';
									
							}elseif ($row->place_id == 3){ 
									echo '<a href="accounts/deactivate/'.$row->id.'">Transition to deactivate</a>';
							}
							
					echo '</tr>';
		
		}echo "</table></form>";
		
		$db = null;
	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'}';
	}
});
//place: activated
$app->get('/api/accounts_activated', function(Request $request, Response $response){
	$sql = "SELECT * FROM store.accounts WHERE place_id = 3 ORDER BY id DESC";
	
	try{
		
		// get db obj
		$db = new db();
		
		//connect
		$db = $db->connect();
		
		$stmt=$db->query($sql);
		
		echo "<form action='' method='post'><table>
			<tr>
				<th>Account ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>EMAIL</th>
				<th>Account Type</th>
				<th>Active?</th>
				<th>Place</th>
				<th>Last moved on</th>
			</tr>";
			while($row = $stmt->fetch(PDO::FETCH_OBJ)){
				echo '<tr>
						<td> ' . $row->id.'</td>
						<td>'. $row->first_name.'</td>
						<td>'. $row->last_name.'</td>
						<td>'. $row->email.'</td>
						<td>'; if($row->account_type_id == 1){$account = "basic";}
									elseif($row->account_type_id == 2){$account = "super";}
									elseif($row->account_type_id == 3){$account = "premium";}echo $account.'</td>
						<td>'; if($row->active == 0){ echo "INACTIVE";}
									else{echo "ACTIVE";}echo'</td>
						<td>'; if($row->place_id == 1){$place = "Confirmation";}
									elseif($row->place_id == 2){$place = "Setup";}
									elseif($row->place_id == 3){$place = "Activated";}
									elseif($row->place_id == 4){$place = "Deactivated";}echo $place.'</td>
						<td>'. $row->moved_on.'</td>
						<td>';
								if ($row->place_id == 1){ 
									echo '
									<a href="accounts/to_setup/'.$row->id.'">Transition to Setup</a>';
									
							}elseif ($row->place_id == 2){ 
									echo '
									<a href="accounts/activate/'.$row->id.'"> Transition to active</a>
									<a href="accounts/deactivate/'.$row->id.'">Transition cancel</a>';
									
							}elseif ($row->place_id == 3){ 
									echo '<a href="accounts/deactivate/'.$row->id.'">Transition to deactivate</a>';
							}
							
					echo '</tr>';
		
		}echo "</table></form>";
		
		$db = null;
	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'}';
	}
});
//place: deactivated
$app->get('/api/accounts_deactivated', function(Request $request, Response $response){
	$sql = "SELECT * FROM store.accounts WHERE place_id = 4 ORDER BY id DESC";
	
	try{
		
		// get db obj
		$db = new db();
		
		//connect
		$db = $db->connect();
		
		$stmt=$db->query($sql);
		
		echo "<form action='' method='post'><table>
			<tr>
				<th>Account ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>EMAIL</th>
				<th>Account Type</th>
				<th>Active?</th>
				<th>Place</th>
				<th>Last moved on</th>
			</tr>";
			while($row = $stmt->fetch(PDO::FETCH_OBJ)){
				echo '<tr>
						<td> ' . $row->id.'</td>
						<td>'. $row->first_name.'</td>
						<td>'. $row->last_name.'</td>
						<td>'. $row->email.'</td>
						<td>'; if($row->account_type_id == 1){$account = "basic";}
									elseif($row->account_type_id == 2){$account = "super";}
									elseif($row->account_type_id == 3){$account = "premium";}echo $account.'</td>
						<td>'; if($row->active == 0){ echo "INACTIVE";}
									else{echo "ACTIVE";}echo'</td>
						<td>'; if($row->place_id == 1){$place = "Confirmation";}
									elseif($row->place_id == 2){$place = "Setup";}
									elseif($row->place_id == 3){$place = "Activated";}
									elseif($row->place_id == 4){$place = "Deactivated";}echo $place.'</td>
						<td>'. $row->moved_on.'</td>
						<td>';
								if ($row->place_id == 1){ 
									echo '
									<a href="accounts/to_setup/'.$row->id.'">Transition to Setup</a>';
									
							}elseif ($row->place_id == 2){ 
									echo '
									<a href="accounts/activate/'.$row->id.'"> Transition to active</a>
									<a href="accounts/deactivate/'.$row->id.'">Transition cancel</a>';
									
							}elseif ($row->place_id == 3){ 
									echo '<a href="accounts/deactivate/'.$row->id.'">Transition to deactivate</a>';
							}
							
					echo '</tr>';
		
		}echo "</table></form>";
		
		$db = null;
	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'}';
	}
});
//list accounts in an inactive place
$app->get('/api/accounts_inactive', function(Request $request, Response $response){
	$sql = "SELECT * FROM store.accounts WHERE place_id = 2 OR place_id = 4 ORDER BY id DESC";
	
	try{
		
		// get db obj
		$db = new db();
		
		//connect
		$db = $db->connect();
		
		$stmt=$db->query($sql);
		
		echo "<form action='' method='post'><table>
			<tr>
				<th>Account ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>EMAIL</th>
				<th>Account Type</th>
				<th>Active?</th>
				<th>Place</th>
				<th>Last moved on</th>
			</tr>";
			while($row = $stmt->fetch(PDO::FETCH_OBJ)){
				echo '<tr>
						<td> ' . $row->id.'</td>
						<td>'. $row->first_name.'</td>
						<td>'. $row->last_name.'</td>
						<td>'. $row->email.'</td>
						<td>'; if($row->account_type_id == 1){$account = "basic";}
									elseif($row->account_type_id == 2){$account = "super";}
									elseif($row->account_type_id == 3){$account = "premium";}echo $account.'</td>
						<td>'; if($row->active == 0){ echo "INACTIVE";}
									else{echo "ACTIVE";}echo'</td>
						<td>'; if($row->place_id == 1){$place = "Confirmation";}
									elseif($row->place_id == 2){$place = "Setup";}
									elseif($row->place_id == 3){$place = "Activated";}
									elseif($row->place_id == 4){$place = "Deactivated";}echo $place.'</td>
						<td>'. $row->moved_on.'</td>
						<td>'; if($row["place_id"] == 2 || 4){ 
									echo '<a href="accounts/reset/'.$row->id.'">Reset</a>';
							}
							
					echo '</tr>';
		
		}echo "</table></form>";
		
		$db = null;
	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'}';
	}
});

//reset inactive accounts
$app->put('/api/accounts/reset/{id}', function(Request $request, Response $response){
	$id = $request->getAttribute('id');
	$date = date('Y/m/d h:i:s a');
	$sql = "UPDATE store.accounts SET place_id= 1,active='0', moved_on='$date' WHERE id='$id'";
	try{
		// get db obj
		$db = new db();
		
		//connect
		$db = $db->connect();
		
		$stmt=$db->prepare($sql);
		$stmt->execute();
		echo '{"notice": {"text": "Account reset"}';
		
	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'}';
	}
});


//list all accounts that moved in the last month
$app->get('/api/accounts_month', function(Request $request, Response $response){
	$sql = "SELECT * FROM store.accounts WHERE moved_on >= DATE_FORMAT (CURRENT_DATE - INTERVAL 1 MONTH, '%Y/%m/01' ) AND moved_on <= DATE_FORMAT(CURRENT_DATE , '%Y/%m/01' )";
	
	try{
		
		// get db obj
		$db = new db();
		
		//connect
		$db = $db->connect();
		
		$stmt=$db->query($sql);
		
		echo "<form action='' method='post'><table>
			<tr>
				<th>Account ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>EMAIL</th>
				<th>Account Type</th>
				<th>Active?</th>
				<th>Place</th>
				<th>Last moved on</th>
			</tr>";
			while($row = $stmt->fetch(PDO::FETCH_OBJ)){
				echo '<tr>
						<td> ' . $row->id.'</td>
						<td>'. $row->first_name.'</td>
						<td>'. $row->last_name.'</td>
						<td>'. $row->email.'</td>
						<td>'; if($row->account_type_id == 1){$account = "basic";}
									elseif($row->account_type_id == 2){$account = "super";}
									elseif($row->account_type_id == 3){$account = "premium";}echo $account.'</td>
						<td>'; if($row->active == 0){ echo "INACTIVE";}
									else{echo "ACTIVE";}echo'</td>
						<td>'; if($row->place_id == 1){$place = "Confirmation";}
									elseif($row->place_id == 2){$place = "Setup";}
									elseif($row->place_id == 3){$place = "Activated";}
									elseif($row->place_id == 4){$place = "Deactivated";}echo $place.'</td>
						<td>'. $row->moved_on.'</td>
						<td>';
								if ($row->place_id == 1){ 
									echo '
									<a href="accounts/to_setup/'.$row->id.'">Transition to Setup</a>';
									
							}elseif ($row->place_id == 2){ 
									echo '
									<a href="accounts/activate/'.$row->id.'"> Transition to active</a>
									<a href="accounts/deactivate/'.$row->id.'">Transition cancel</a>';
									
							}elseif ($row->place_id == 3){ 
									echo '<a href="accounts/deactivate/'.$row->id.'">Transition to deactivate</a>';
							}
							
					echo '</tr>';
		
		}echo "</table></form>";
		
		$db = null;
	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'}';
	}
});
//list all accounts that moved in the last week
$app->get('/api/accounts_week', function(Request $request, Response $response){
	$sql = "SELECT * FROM store.accounts WHERE moved_on >= (NOW() - INTERVAL 8 DAY)";
	
	try{
		
		// get db obj
		$db = new db();
		
		//connect
		$db = $db->connect();
		
		$stmt=$db->query($sql);
		
		echo "<form action='' method='post'><table>
			<tr>
				<th>Account ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>EMAIL</th>
				<th>Account Type</th>
				<th>Active?</th>
				<th>Place</th>
				<th>Last moved on</th>
			</tr>";
			while($row = $stmt->fetch(PDO::FETCH_OBJ)){
				echo '<tr>
						<td> ' . $row->id.'</td>
						<td>'. $row->first_name.'</td>
						<td>'. $row->last_name.'</td>
						<td>'. $row->email.'</td>
						<td>'; if($row->account_type_id == 1){$account = "basic";}
									elseif($row->account_type_id == 2){$account = "super";}
									elseif($row->account_type_id == 3){$account = "premium";}echo $account.'</td>
						<td>'; if($row->active == 0){ echo "INACTIVE";}
									else{echo "ACTIVE";}echo'</td>
						<td>'; if($row->place_id == 1){$place = "Confirmation";}
									elseif($row->place_id == 2){$place = "Setup";}
									elseif($row->place_id == 3){$place = "Activated";}
									elseif($row->place_id == 4){$place = "Deactivated";}echo $place.'</td>
						<td>'. $row->moved_on.'</td>
						<td>';
								if ($row->place_id == 1){ 
									echo '
									<a href="accounts/to_setup/'.$row->id.'">Transition to Setup</a>';
									
							}elseif ($row->place_id == 2){ 
									echo '
									<a href="accounts/activate/'.$row->id.'"> Transition to active</a>
									<a href="accounts/deactivate/'.$row->id.'">Transition cancel</a>';
									
							}elseif ($row->place_id == 3){ 
									echo '<a href="accounts/deactivate/'.$row->id.'">Transition to deactivate</a>';
							}
							
					echo '</tr>';
		
		}echo "</table></form>";
		
		$db = null;
	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'}';
	}
});

////list all accounts that moved in the last day
$app->get('/api/accounts_day', function(Request $request, Response $response){
	$sql = "SELECT * FROM store.accounts WHERE moved_on >= (NOW() - INTERVAL 2 DAY)";
	
	try{
		
		// get db obj
		$db = new db();
		
		//connect
		$db = $db->connect();
		
		$stmt=$db->query($sql);
		
		echo "<form action='' method='post'><table>
			<tr>
				<th>Account ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>EMAIL</th>
				<th>Account Type</th>
				<th>Active?</th>
				<th>Place</th>
				<th>Last moved on</th>
			</tr>";
			while($row = $stmt->fetch(PDO::FETCH_OBJ)){
				echo '<tr>
						<td> ' . $row->id.'</td>
						<td>'. $row->first_name.'</td>
						<td>'. $row->last_name.'</td>
						<td>'. $row->email.'</td>
						<td>'; if($row->account_type_id == 1){$account = "basic";}
									elseif($row->account_type_id == 2){$account = "super";}
									elseif($row->account_type_id == 3){$account = "premium";}echo $account.'</td>
						<td>'; if($row->active == 0){ echo "INACTIVE";}
									else{echo "ACTIVE";}echo'</td>
						<td>'; if($row->place_id == 1){$place = "Confirmation";}
									elseif($row->place_id == 2){$place = "Setup";}
									elseif($row->place_id == 3){$place = "Activated";}
									elseif($row->place_id == 4){$place = "Deactivated";}echo $place.'</td>
						<td>'. $row->moved_on.'</td>
						<td>';
								if ($row->place_id == 1){ 
									echo '
									<a href="accounts/to_setup/'.$row->id.'">Transition to Setup</a>';
									
							}elseif ($row->place_id == 2){ 
									echo '
									<a href="accounts/activate/'.$row->id.'"> Transition to active</a>
									<a href="accounts/deactivate/'.$row->id.'">Transition cancel</a>';
									
							}elseif ($row->place_id == 3){ 
									echo '<a href="accounts/deactivate/'.$row->id.'">Transition to deactivate</a>';
							}
							
					echo '</tr>';
		
		}echo "</table></form>";
		
		$db = null;
	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'}';
	}
});