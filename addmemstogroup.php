<!DOCTYPE html>
<html>

<head>
  <title>Add Members</title>
  <link rel="stylesheet" type="text/css" href="./css/style.css">
  <link rel="stylesheet" type="text/css" href="./css/tablestyles.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
</head>

<body>

  <h2>Add Group members</h2>

  <form action="./php/addmemstogroup_action.php" method="post">
    <p>User to add: <input type="text" name="newuser" maxlength="20" required><br></p>
    <p>Would you like to add more group members? <br></p>
    <input type="radio" name="addmems" value="add"> Yes!<br>
    <input type="radio" name="addmems" value="done"> No!<br>
    <input type="submit">
  </form>
  
  <h3>Users Already In Group:</h3>
  
  <!-- Display a table of all users in the database that are not  -->
  <!-- currently already in the group -->
  <?php
		include_once './php/functions.php';
	
		$link = connectToServer();

		$qry = "SELECT grm_usr_ID Name FROM Group_Members 
            WHERE grm_gro_ID = '".$_COOKIE["currGroupName"]."'
            AND grm_usr_ID != '".$_COOKIE["current_user"]."'";
    $result = mysqli_query($link, $qry);

		if(mysqli_num_rows($result) > 0) {
			echo "<table> <tr> 
			<th>Name</th>
			</tr>";

			// Output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				echo "</td><td>" . ucwords($row["Name"]) .
				"</td></tr>";
			}
			echo "</table>";
			} else {
			echo "<table> <tr><td>None!</td></tr> </table>";
		}

  mysqli_close($link);
	?>

  <h3>Available Users:</h3>
  
  <!-- Display a table of all users in the database that are not  -->
  <!-- currently already in the group -->
  <?php
		include_once './php/functions.php';
	
		$link = connectToServer();

		$qry = "SELECT usr_ID Name FROM Users WHERE usr_ID NOT IN 
            (SELECT grm_usr_ID FROM Group_Members 
            WHERE grm_gro_ID='".$_COOKIE["currGroupName"]."')";

    $result = mysqli_query($link, $qry);

		if(mysqli_num_rows($result) > 0) {
			echo "<table> <tr> 
			<th>Name</th>
			</tr>";

			// Output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				echo "</td><td>" . ucwords($row["Name"]) .
				"</td></tr>";
			}
			echo "</table>";
			} else {
			echo "<table> <tr><td>None!</td></tr> </table>";
		}

  mysqli_close($link);
	?>
    
</body>

</html>