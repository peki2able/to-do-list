<?php
	
	// Retriving data from DB
		// Connecting to DB
			function dbConnect($usertype){
					$host = 'localhost';
					$db = 'to_do_list';
				if($usertype == 'read'){
					$user = 'ur_username';
					$pass = 'ur_pass';
				}else if($usertype == 'write'){
					$user = 'ur_username';
					$pass = 'ur_pass';
				}else{
					exit('Unrecognized connection type');
				}
			try{
				return new PDO("mysql:host=$host;dbname=$db", $user, $pass);
			}catch (PDOException $e){
				echo $e->getMessage();
			}	
		}
