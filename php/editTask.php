<?php

require 'functions.php';

if ($_POST['action'] && $_POST['id']) {
	// Editing a task!
	$taskName = $_POST['id'];
	$link = connectToServer();
  if ($_POST['action'] == 'Edit') {    
    echo "<h3>You're currently editing " . $taskName . "</h3>";
    
    $qry = "SELECT * FROM Tasks WHERE tas_ID=\"" . $taskName . "\"";
    $result = mysqli_query($link, $qry);
    $row = mysqli_fetch_assoc($result);
	// Deleting a task!
  } else if($_POST['action'] == 'Delete') {
    $taskName = $_POST['id'];
    
    // @TODO: Stored Procedure
		// Transaction: Delete from 4 tables.
    $qry = "DELETE FROM Tasks WHERE tas_ID='$taskName'";
		$link->query($qry);
    
		$qry = "DELETE FROM Task_Groups WHERE tgr_tas_ID='$taskName'";
		$link->query($qry);
		
		$qry = "DELETE FROM Task_Owners WHERE tow_tas_ID='$taskName'";
		$link->query($qry);
		
		$qry = "DELETE FROM Progress_Task WHERE prg_tas_ID='$taskName'";
		$link->query($qry);
		
    redirectHome();
  }
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Create Task</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
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
    <input type="hidden" name="old_taskname" value="<?php echo $taskName ?>">
	  <input type="Submit" name="Submit" value="Submit Changes">
	  <input type="Submit" name="Submit" value="Remove Groups">
	  <input type="Submit" name="Submit" value="Add New Groups">
	</form>

</body>
</html>