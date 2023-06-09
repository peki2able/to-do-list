<?php require_once('./db_retriving.inc.php');

// Setting flags
	$OK = false;
	$done = false;
// Check if link's has been clicked
	if(isset($_GET['task_id']) && !$_POST){
	// connection to DB
	$connect = dbConnect('write');
		// prepare SQL query
			$sql = 'SELECT task_id, task FROM tasks WHERE task_id = ?';
			$stmt = $connect->prepare($sql);
		// bind the result
			$stmt->bindColumn(1, $task_id);
			$stmt->bindColumn(2, $task);
		// execute query by passing array of variables
			$OK = $stmt->execute(array($_GET['task_id']));
			$stmt->fetch();
		// store error message if query fails	
		if(isset($stmt) && !$OK){
			$error = $stmt->errorInfo();
			if(isset($error[2])){
				$error = $error[2];
			}
		}
		if(isset($error)){
			echo "<p class='error_msg'>Error: \$error</p>";
		}
		if($task_id == 0){
			echo "<p class='error_msg'>Invalid request</p>";
		}
}

// if delete button has been pressed
if(isset($_POST['delete-button'])){
	
	$conn = dbConnect('write');
// prepare delete query
	$sql = 'DELETE FROM tasks WHERE task_id = ?';
	$stmt = $conn->prepare($sql);
	$stmt->execute(array($_POST['task_id']));
	$deleted = $stmt->rowCount();
// if not deleted - give an error message
if(!$deleted){
	echo 'There was a problem deleting the task';
}else{
	header('Location: https://localhost/MyMentor/to-dolist.php');
}
	
}

// if cancel button has been pressed - return to To-Do list page
if(isset($_POST['cancel-button'])){
	header('Location: https://localhost/MyMentor/to-dolist.php');
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
			<meta charset="utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1.0" />
			
				<title>Edit List (PHP)</title>
			<link rel="stylesheet" href="edit-style.css">
	</head>
	<body>
		  <form method="post" action="">
			<label for="delete-task">Delete task:</label>
			<input name="task" type="text" id="delete" value="<?php if(!empty($task)) echo htmlentities($task, ENT_COMPAT, 'utf-8'); ?>" />
			<input name="task_id" type="hidden" value="<?php echo $task_id ?>" />
			<input type="submit" value="delete" name="delete-button" class="edit delete" />
			<input type="submit" value="cancel" name="cancel-button" class="edit cancel" />
		  </form>
	</body>
</html>