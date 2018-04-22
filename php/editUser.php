<?php

require 'functions.php';

if ($_POST['action'] && $_POST['id']) {
	// Editing a user!  
	if ($_POST['action'] == 'Edit') {
    $userName = $_POST['id'];
    echo "<h3>You're currently editing user " . ucwords($userName) . "</h3>";
    
    $link = connectToServer();

    $qry = "SELECT * FROM Users INNER JOIN Privileges ON usr_ID = pri_usr_ID WHERE usr_ID='" . $userName . "'";
    $result = mysqli_query($link, $qry);
    
    $row = mysqli_fetch_assoc($result);
    
	// Deleting a user!
  } else if($_POST['action'] == 'Delete') {
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
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
</head>
<body>
  
	<h4>So What Do You Want to Change? <br></h4>
  Leave field blank if you wish to leave an attribute unchanged. <br><br>
	
	<form action="./submitUserEdits.php" method="POST">
	User Name: <input type="text" name="usr_ID" maxlength="20" <?php echo "placeholder=\"" . $userName . "\"" ?> </input><br>
  <br>
  User Email: <input type="email" name="usr_Email" maxlength="50" <?php echo "placeholder=\"" . $row["usr_Email"] . "\"" ?> </input><br>
	<br>
  User Password: <input type="text" name="usr_Password" maxlength="255" <?php echo "placeholder=\"" . $row["usr_Password"] . "\"" ?> </input><br>
	<br>
  User Privilege Level: <input type="text" name="pri_type" maxlength="2" <?php echo "placeholder=\"" . $row["pri_type"] . "\"" ?> </input><br>
  <br>
    <input type="hidden" name="old_username" value="<?php echo $userName ?>">
	  <input type="Submit" name="Submit1" value="Confirm Changes">
	  <input type="Submit" name="Submit2" value="Remove Groups?">
	</form>

</body>
</html>