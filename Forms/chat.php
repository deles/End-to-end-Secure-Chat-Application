<?php 


require_once ('unsecure_fns.php');

error_reporting(0);

session_start();

ob_start();

header("Content-type:application/json");

date_default_timezone_set('UTC');

$obj = new DBChatConn();
$connection = $obj->getConn();

try {
	
	$currentTime = time();
	$session_id = $_SESSION['valid_user'];
	
	$lastPoll = isset($_SESSION['last_poll']) ? $_SESSION['last_poll'] : $currentTime;
	$_SESSION['last_poll'] = $lastPoll;
	
	$action = isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] == 'POST') ? 'send' : 'poll';
	
	switch($action) {
		
		case  'poll': 
						$query = "SELECT * FROM chatlog WHERE date_created >= :last_poll";
						
						$stmt = $connection->prepare($query);
					
						$stmt->bindValue(':last_poll', $lastPoll);
						
						$stmt->execute();
				
						$result = $stmt->fetchAll();
						
						//var_dump($result);
						for($index = 0; $index < sizeof($result); $index++) {
							
							if($session_id == $result[$index]['sent_by']) {
								
								$result[$index]['sent_by'] = 'self';
								
							} else {
								
								$result[$index]['sent_by'] = 'other';
							}
							
							$session_id == $result[$index]['user'] = $session_id;
						}
						
						$_SESSION['last_poll'] = $currentTime;
						
						print json_encode([
							'success'=> true,
							'messages'=>$result
						]);
						exit;
		case 'send':	$message = isset($_POST['message']) ? $_POST['message'] : '';
						$message = strip_tags($message);
						
						
						$query = "INSERT INTO chatlog (message, sent_by, date_created)
								  VALUES(:message, :sent_by, :date_created)";
						
						$stmt = $connection->prepare($query);
						
						$stmt->bindValue(":message", $message, PDO::PARAM_STR);
						$stmt->bindValue(":sent_by", $_SESSION['valid_user'], PDO::PARAM_STR);
						$stmt->bindValue(":date_created", $currentTime, PDO::PARAM_INT);
					
						
						$stmt->execute();
						
						print json_encode(['success' => true]);
						exit;

	}
} catch (\Exception $e) {
	
	print json_encode(['success'=> false, 'error'=> $e->getMessage()]);
}

?>