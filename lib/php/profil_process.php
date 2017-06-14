<?php
	session_start();
	require_once 'dbconfig.php';

	if(isset($_POST['btn-speichern'])){
		$user_name = trim($_POST['user_name']);
		$user_email = trim($_POST['user_email']);
		$user_id = $_SESSION['user_session'];
		
		#$password = md5($user_password);
		
		try{	
			$sql = "UPDATE tbl_users SET user_name = :user_name, user_email = :user_email WHERE user_id = :user_id";
			$stmt = $db_con->prepare($sql);
			$stmt->bindParam(':user_name', $user_name);
			$stmt->bindParam(':user_email', $user_email);
			$stmt->bindParam(':user_id', $user_id);
			$stmt->execute();
				
		}
		catch(PDOException $e){
			echo $e->getMessage();
		}
	}

?>