<?php
require_once('./db_retriving.inc.php');

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

// If update form has been submitted, update record
if(isset($_POST['update-button']) && !empty($_POST['task'])){
	
	$conn = dbConnect('write');
// prepare update query
	$sql = 'UPDATE tasks SET task = ? WHERE task_id = ?';
	$stmt = $conn->prepare($sql);
// execute query by passing array of variables
	$stmt->execute(array($_POST['task'], $_POST['task_id']));
	$done = $stmt->rowCount();

// redirect page on success or $_GET['task_id'] is not defined
	if($done || !isset($_GET['task_id'])){
		header('Location: https://localhost/MyMentor/to-dolist.php');
	}
}

// if cancel button has been pressed
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
		  <form method="post" action="" id="edit">
			<label for="update-task">Update task:</label>
			<input name="task" type="text" id="update" value="<?php if(!empty($task)) echo htmlentities($task, ENT_COMPAT, 'utf-8'); ?>" />
			<input name="task_id" type="hidden" value="<?php echo $task_id ?>" />
			<input type="submit" value="update" name="update-button" class="edit" />
			<input type="submit" value="cancel" name="cancel-button" class="edit cancel" />
		  </form>
	</body>
</html>