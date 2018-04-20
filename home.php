<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>User Home</title>
	<link rel="stylesheet" type="text/css" href="./css/tablestyles.css">
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
</head>
<body>
	
	<h2>Welcome to the home screen, <?php echo ucwords($_COOKIE['current_user']) ?>!</h2>

	<p>Choose what you would like to do:</p>

	<form action="./php/home_action.php" method="POST">
		Add Group: <input type="radio" name="homeAction" value="addGroup"><br>
		Add Task:  <input type="radio" name="homeAction" value="addTask"><br>
		<input type="submit">

		<h4>Current Groups You Manage:</h4>
		
		<?php
		require './php/functions.php';
	
		$link = connectToServer();

		$qry = "SELECT gro_ID GroupID, gro_ownerID OwnerID, gro_Status Status 
						FROM Groups WHERE gro_ownerID = '" . $_COOKIE['current_user'] . "'";
		$result = mysqli_query($link, $qry);

		if(mysqli_num_rows($result) > 0) {
			echo "<table> <tr> 
			<th>GroupID</th> 
			<th>OwnerID</th> 
			<th>Status</th>       
			<th>Edit Group</th> 
			<th>Delete Group</th> 
			</tr>";

			// Output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				echo "<tr><td>" . $row["GroupID"] .
				"</td><td>" . $row["OwnerID"] .
				"</td><td>" . $row["Status"] .
				"</td><td> <input type=\"Submit\" name=\"".$row["GroupID"] . "\" value=\"Edit\">" .
				"</td><td> <input type=\"Submit\" name=\"Submit\" value=\"Delete\">"  .
				"</td></tr>";
			}
			echo "</table>";
			} else {
			echo "<table> <tr><td>None!</td></tr> </table>";
		}

		mysqli_free_result($result);
		mysqli_close($link);
		?>
		
		<h4>Current Groups You're A Part Of:</h4>

		<?php
		$link = connectToServer();

		$qry = "SELECT gro_ID GroupID, gro_ownerID OwnerID, gro_Status Status 
						FROM Groups INNER JOIN Group_Members ON gro_ID = grm_gro_ID 
						WHERE Group_Members.grm_usr_ID ='" . $_COOKIE['current_user'] . "'";
		$result = mysqli_query($link, $qry);

		if(mysqli_num_rows($result) > 0) {
			echo "<table> <tr>
			<th>GroupID</th>
			<th>OwnerID</th>
			<th>Status</th>
			<th>Leave Group</th>
			</tr>";

			// Output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				echo "<tr><td>" . $row["GroupID"] .
				"</td><td>" . $row["OwnerID"] .
				"</td><td>" . $row["Status"] .
				"</td><td> <input type=\"Submit\" name=\"Submit\" value=\"Leave\">"  .
				"</td></tr>";
			}
			echo "</table>";
			} else {
			echo "0 results";
		}

		mysqli_free_result($result);
		mysqli_close($link);
		?>

		<h4>Current Tasks</h4>

		<?php
		$link = connectToServer();

		$qry = "SELECT tas_ID TaskID, tas_Category Category, tas_DueDate DueDate, tas_Priority Priority, tas_Progress Progress
						FROM Tasks WHERE tas_usr_ID='" . $_COOKIE['current_user'] . "'";
		$result = mysqli_query($link, $qry);

		if(mysqli_num_rows($result) > 0) {
			echo "<table> <tr> 
			<th>TaskID</th> 
			<th>Category</th> 
			<th>DueDate</th> 
			<th>Priority</th>
			<th>Progress</th>
			<th>Edit Task</th>
			<th>Delete Task</th>
			</tr>";

			// Output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				echo "<tr><td>" . $row["TaskID"] .
				"</td><td>" . $row["Category"] .
				"</td><td>" . $row["DueDate"] .
				"</td><td>" . $row["Priority"] .
				"</td><td>" . $row["Progress"] .
				
        // This chunk of HTML allows us to edit or delete selected entries from the database
        "<form action=\"./php/editTask.php\" method=\"POST\">" .
          "</td><td>" .
          "<input type=\"submit\" name=\"action\" value=\"Edit\"/>" .
          "</td><td>" .
          "<input type=\"submit\" name=\"action\" value=\"Delete\"/>" .
          "<input type=\"hidden\" name=\"id\" value=\"" . $row['TaskID'] . "\"/>" .
        "</form>" .
          
				"</td></tr>";
			}
			echo "</table>";
			} else {
			echo "0 results";
		}

		mysqli_free_result($result);
		mysqli_close($link);
		?>

	</form>

</body>
</html>