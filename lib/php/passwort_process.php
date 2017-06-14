<?php
	session_start();
	require_once 'dbconfig.php';

	if(isset($_POST['btn-pwspeichern'])){
		$user_password = trim($_POST['user_password']);
		$user_id = $_SESSION['user_session'];
		
		#$password = md5($user_password);
		
		try{	
			$sql = "UPDATE tbl_users SET user_name = :user_password WHERE user_id = :user_id";
			$stmt = $db_con->prepare($sql);
			$stmt->bindParam(':user_password', $user_password);
			$stmt->bindParam(':user_id', $user_id);
			$stmt->execute();
				
		}
		catch(PDOException $e){
			echo $e->getMessage();
		}
	}

?>