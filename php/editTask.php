<?php

require 'functions.php';

if ($_POST['action'] && $_POST['id']) {
  if ($_POST['action'] == 'Edit') {
    
    /* Let's edit a task! */
    
    $taskName = $_POST['id'];
    echo "<h3>You're currently editing " . $taskName . "</h3>";
    
    $link = connectToServer();

    $qry = "SELECT * FROM Tasks WHERE tas_ID=\"" . $taskName . "\"";
    $result = mysqli_query($link, $qry);
    
    $row = mysqli_fetch_assoc($result);
    
  } else if($_POST['action'] == 'Delete') {
    /* Let's delete this task! */
    $taskName = $_POST['id'];
    
    /* @TODO: Delete task here */
    /* Call stored procedure */
    
    
    exit();
    
  }
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Create Task</title>
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
</head>
<body>
  
	<h4>So What Do You Want to Change? <br></h4>
	
	<form action="./submitTaskEdits.php" method="post">
	<!-- 	Not Required -->
	Task Name: <input type="text" name="taskname" maxlength="100" <?php echo "placeholder=\"" . $taskName . "\"" ?>  </input><br>
    <br>Current Priority: <?php echo $row["tas_Priority"] ?> <br>
	  <input type="radio" name="priority" value="h" checked> RIGHT NOW! <br>
	  <input type="radio" name="priority" value="m"> Sometime Soon. <br>
	  <input type="radio" name="priority" value="l"> it can wait <br>
	<br>
    Current Category: <?php echo $row["tas_Category"] ?> <br>
	  <input type="radio" name="category" value="school" checked> School <br>
	  <input type="radio" name="category" value="work"> Work <br>
	  <input type="radio" name="category" value="family"> Family <br>
	  <input type="radio" name="category" value="organization"> Organization <br>
	  <input type="radio" name="category" value="miscellaneous"> Miscellaneous <br>
	<br>
    Current Progress: <?php echo $row["tas_Progress"] ?> <br>
	  <input type="radio" name="progress" value="done" checked> D O N E <br>
	  <input type="radio" name="progress" value="close"> Literally So Close <br>
	  <input type="radio" name="progress" value="half"> Halfway. Glass Half Full? <br>
	  <input type="radio" name="progress" value="started"> Could Be Worse <br>
	  <input type="radio" name="progress" value="begin"> Lowkey Haven't Started <br>

	<div>
	    <br>
			<!--   Not Required -->
			<br>Current Due Date: <?php echo $row["tas_DueDate"] ?> <br>
	    <label for="duedate">New Due Date:</label>
	    <input id="datetime" type="datetime-local" name="duedate">
	    <span class="validity"></span> <br> <br>
	</div>
    <input type="hidden" name="old_taskname" value=" <?php echo $taskName ?> ">
	  <input type="Submit" name="submitChanges" value="Submit Changes">
	  <input type="Submit" name="removeGroups" value="Remove Groups">
	  <input type="Submit" name="addGroups" value="Add New Groups">
	</form>

</body>
</html>