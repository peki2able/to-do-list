<?php
	
	// Retriving data from DB
		// Connecting to DB
			function dbConnect($usertype){
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