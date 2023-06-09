<?php
	ini_set('display_errors', 1);
	   error_reporting(E_ALL);
	
// initialize flag
$OK = false;
$done = false;

	
	if(isset($_POST['button']) && !empty($_POST['text'])){
	// include file
		require_once('./form.inc.php');
	
	// Connect with DB
		$conn = dbConn('write');
	// Prepare the query if no errors
	if(!$errors){
		$sql = 'INSERT INTO tasks (task, due_date) VALUES (:text, :due_date)';
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':text', $_POST['text'], PDO::PARAM_STR);
		$stmt->bindParam(':due_date', $_POST['due_date'], PDO::PARAM_STR);
		$stmt->execute();
		$OK = $stmt->rowCount();
		$error = $conn->errorInfo();
	if(isset($error[2])) die($error[2]);
	
// display message on error
	if(!$OK){
		echo "Did not success";
		$error = $stmt->errorInfo();
		if(isset($error[2])) $error = $error[2];
			echo "<p class='error_msg'>Error: \$error</p>";
		}else{
		    // if success resend page
			header('Location: https://localhost/MyMentor/to-dolist.php');
		}
// Check for errors	and display them
	}else{
		   foreach($errors as $key){
			  echo "<p class='error_msg'>".$key."</p>";
		   }
		}
	
}	

?>
<!DOCTYPE html>
<html lang="EN">
	<head>
			<meta charset="utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1.0" />
			
				<title>To-Do List (PHP)</title>
			<link rel="stylesheet" href="style.css">
	</head>
	<body>
		
		<h1>To-Do List</h1>
		<form action="" method="post">
			<label for="text">Add task:</label>
			<input type="text" id="text" name="text" />
			<label for="text">Due date:</label>
			<input id="due_date" type="date" name="due_date" />
			<input class="button" type="submit" value="+" alt="addtask" name="button" />
		</form>
		
		<article class="all-browsers">
			<article class="daily-task">
				<h3>Daily task's</h3>
				<?php 
					include_once('./db_retriving.inc.php');
					// Retriving results from DB
						// Connect to db
							$connect = dbConnect('write');
						// prepare the query
							$sql = 'SELECT task_id, task, DATE_FORMAT(created, "%a, %b %D, %y") AS date_created, DATE_FORMAT(due_date, "%d, %b, %y") AS due FROM tasks';							
							$error = $connect->errorInfo();
						if(isset($error[2])) die($error[2]);
						//////////////////////////
						
						///////////////////////////
						// setting counter
							$numRow = 0;
						// show the result
						if(isset($connect)){foreach($connect->query($sql) as $row){ $numRow++; ?>
							<table id="table_content">
								<tr>
									<th><?php if($row){ echo $numRow.". ".$row['task']; }?></th>
									<td class="date"><em class="minor">created</em> <?php echo $row['date_created']; ?><em><?php if(!empty($row['due'])) echo " due ".$row['due']; ?></em></td>
									<td class="links-upper"><a href="edit.php?task_id=<?php echo $row['task_id']; ?>">edit </a><em>|</em></td>
									<td class="links-lower"><a style="color:darkred;" href="delete.php?task_id=<?php echo $row['task_id']; ?>">delete</a></td>
								</tr>
							</table>
				<?php } } ?>
					<!--ol/ul's & paragraph's-->
			</article>		
		</article>
	</body>
</html>