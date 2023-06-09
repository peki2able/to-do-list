<?php		

// Initialising an Array for error msg's 
		$errors = array();
	// Setting Flag
		$Ok = false;
// Checking is textual field empty
		if(empty(trim($_POST['text']))){
			$errors[]= "*Task's title required";
		}else{
			$text = $_POST['text'];
			// Regex NOT to forget
			$Ok = true;
		}
		
		// Connection to DB
		function dbConn($usertype){
			
					$host = 'localhost';
					$db = 'to_do_list';
				if($usertype == 'read'){
					$user = 'listread';
					$pass = 'plexBrachi';
				}else if($usertype == 'write'){
					$user = 'listwrite';
					$pass = 'plexFoxer';
				}else{
					exit('Unrecognized connection type');
				}
			try{
				return new PDO("mysql:host=$host;dbname=$db", $user, $pass);
			}catch (PDOException $e){
				echo $e->getMessage();
			}
				
		
	}
?>