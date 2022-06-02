<?php

	$dbhost = "localhost";
	$dbname = "global_chat";
	$dbuser = "root";
	$dbpass = '';


	try{
		$db = new PDO("mysql:dbhost=$dbhost;dbname=$dbname", "$dbuser", "$dbpass");
	}catch(PDOException $e){
		echo $e->getMessage();
	}
	switch( $_REQUEST['action'] ){

	case "sendMessage":
		session_start();
		$query = $db->prepare("INSERT INTO messages SET user=?, message=?");
		$run = $query->execute([$_SESSION['user'], $_REQUEST['message']]);

		if( $run ){
			echo 1;
			exit;
		}

	break;

	case "getMessages":
		session_start();

		$query = $db->prepare("SELECT * FROM messages");
		$run = $query->execute();
		$response = $query->fetchAll(PDO::FETCH_OBJ);

		$chat = '';
		foreach( $response as $message ) {
			$chat .= '<div class="single-message '.(($_SESSION['user']==$message->user)?'right':'left').'">
						<strong>'.$message->user.': </strong><br /> <p>'.$message->message.'</p>
						<span>'.date('H:i', strtotime($message->date)).'</span>
						</div>
						<div class="clear"></div>
						';
		}
		echo $chat;
	break;
	}

?> 
