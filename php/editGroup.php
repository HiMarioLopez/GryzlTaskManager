<?php

require 'functions.php';

if ($_POST['action'] && $_POST['id']) {
	// Editing a group!  
	if ($_POST['action'] == 'Edit') {
    $groupName = $_POST['id'];
    echo "<h3>You're currently editing " . ucwords($groupName) . "</h3>";
    
    $link = connectToServer();

    $qry = "SELECT * FROM Groups WHERE gro_ID='" . $groupName . "'";
    $result = mysqli_query($link, $qry);
    
    $row = mysqli_fetch_assoc($result);
    
	// Deleting a group!
  } else if($_POST['action'] == 'Delete') {
    $userName = $_POST['id'];
    
    /* @TODO: Delete group here */
    /* Call stored procedure */
    
    exit();
  }
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit Group</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
</head>
<body>
  
	<h4>So What Do You Want to Change? <br></h4>
  Leave field blank if you wish to leave an attribute unchanged. <br><br>
	
	<form action="./submitGroupEdits.php" method="POST">
	Group Name: <input type="text" name="usr_ID" maxlength="20" <?php echo "placeholder=\"" . $groupName . "\"" ?> </input><br>
  <br>
  Group Owner: <input type="email" name="usr_Email" maxlength="50" <?php echo "placeholder=\"" . $row["gro_ownerID"] . "\"" ?> </input><br>
	<br>
  Group Status: <input type="text" name="usr_Password" maxlength="255" <?php echo "placeholder=\"" . $row["gro_Status"] . "\"" ?> </input><br>
	<br>
    <input type="hidden" name="old_username" value="<?php echo $userName ?>">
	  <input type="Submit" name="Submit1" value="Confirm Changes">
	</form>

  <?php
	require './php/functions.php';

	$link = connectToServer();

	$qry = "SELECT grm_usr_ID UserName FROM Groups WHERE grm_gro_ID='$groupName'";
	$result = mysqli_query($link, $qry);

	if(mysqli_num_rows($result) > 0) {
		echo "<table> <tr> 
		<th>User Name</th> 
		<th>Remove</th> 
		<th>Transfer Ownership</th>
		</tr>";

		// Output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			echo "<tr><td>" . $row["UserName"] .
      
      // This chunk of HTML allows us to edit or delete selected entries from the database
      "<form action=\"./php/editGroupUsers.php\" method=\"POST\">" .
        "</td><td>" .
        "<input type=\"submit\" name=\"action\" value=\"Remove\"/>" .
        "</td><td>" .
        "<input type=\"submit\" name=\"action\" value=\"Transwer Ownership\"/>" .
        "<input type=\"hidden\" name=\"id\" value=\"" . $row['GroupID'] . "\"/>" .
      "</form>" .
        
      "</td></tr>";
		}
		echo "</table>";
		} else {
		echo "<table> <tr><td>None!</td></tr> </table>";
	}

	mysqli_free_result($result);
	mysqli_close($link);
	?>

  
</body>
</html>