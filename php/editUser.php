<?php

require 'functions.php';

if ($_POST['action'] && $_POST['id']) {
  if ($_POST['action'] == 'Edit') {
    
    /* Let's edit a task! */
    
    $userName = $_POST['id'];
    echo "<h3>You're currently editing user " . ucwords($userName) . "</h3>";
    
    $link = connectToServer();

    $qry = "SELECT * FROM Users INNER JOIN Privileges ON usr_ID = pri_usr_ID WHERE usr_ID='" . $userName . "'";
    $result = mysqli_query($link, $qry);
    
    $row = mysqli_fetch_assoc($result);
    
  } else if($_POST['action'] == 'Delete') {
    /* Let's delete this task! */
    $userName = $_POST['id'];
    
    /* @TODO: Delete task here */
    /* Call stored procedure */
    
    
    exit();
    
  }
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit User</title>
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
</head>
<body>
  
	<h4>So What Do You Want to Change? <br></h4>
  Leave blank if you wish to leave an attribute unchanged. <br><br>
	
	<form action="./submitTasskEdits.php" method="post">
	User Name: <input type="text" name="taskname" maxlength="20" <?php echo "placeholder=\"" . $userName . "\"" ?> </input><br>
  <br>
  User Email: <input type="email" name="email" maxlength="50" <?php echo "placeholder=\"" . $row["usr_Email"] . "\"" ?> </input><br>
	<br>
  User Password: <input type="text" name="password" maxlength="255" <?php echo "placeholder=\"" . $row["usr_Password"] . "\"" ?> </input><br>
	<br>
  User Privilege Level: <input type="text" name="privilege" maxlength="2" <?php echo "placeholder=\"" . $row["pri_type"] . "\"" ?> </input><br>
  <br>
    <input type="hidden" name="old_taskname" value=" <?php echo $taskName ?> ">
	  <input type="Submit" name="Submit1" value="Confirm Changes">
	  <input type="Submit" name="Submit2" value="Remove Groups?">
	</form>

</body>
</html>