<?php
	// Include the Dwolla REST Client
	require 'lib/dwolla.php';

	// Include any required keys
	require '_keys.php';

	// Instantiate a new Dwolla REST Client
	$Dwolla = new DwollaRestClient($apiKey, $apiSecret);

	//Testing
	/*
	$Dwolla->setDebug(true);
	echo "<p>User ID=".$_POST["userID"]."</p>";//testing
	echo "<p>Amount=".$_POST["amount"]."</p>";//testing
	*/

	$user = $Dwolla->getUser($_POST["userID"]);	
	
	$amount = $_POST["amount"];
	if($amount < 0 || $amount > 1){
		echo "Error: Invalid dollar amount!";
	}
	elseif(!$user) { 
		echo "Error: {$Dwolla->getError()} \n"; 
		} 
	else { 
		
		//Hard coded in _keys.php $token="2Dn+YkMrJNG43UR7VMQXyir6ocDAtB6vBasBUtcKM7A3iV/Bga";	
		$Dwolla->setToken($token);

		//Make the transaction
		$transactionId = $Dwolla->send($pin, $user['Id'], $amount);

		if(!$transactionId) { //Check for errors
			echo "Error: {$Dwolla->getError()} \n"; 
		}
		else { // Print Transaction ID 
			echo "Transaction successful (Transaction ID: {$transactionId}) \n"; 
		} 		
		
	} // Valid user and amount
	
	

?>