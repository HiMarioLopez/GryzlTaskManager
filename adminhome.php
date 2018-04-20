<!-- What this page currently does (4.15.2018)
  Mario
     - Admins can now view all tasks and users in the db.
     - Added styling, buttons that will (eventually) link to edit webpages.
-->

<!-- What this page need (4.15.2018)
     - Add ability to edit and delete tasks from th is page.
-->
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Admin Home</title>
	<link rel="stylesheet" type="text/css" href="./css/tablestyles.css">
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
</head>
<body>

	<h2>Welcome to the admin home screen</h2>
	<h4>Current Users:</h4>

	<?php
		include_once './php/functions.php';
	
		$link = connectToServer();

		$qry = "SELECT * FROM Users INNER JOIN Privileges ON usr_ID = pri_usr_ID";
		$result = mysqli_query($link, $qry);

		if(mysqli_num_rows($result) > 0) {
			echo "<table> <tr> 
			<th>usr_ID</th> 
			<th>usr_Email</th> 
			<th>usr_Password</th>
			<th>pri_type</th>
			<th>pri_usr_ID</th>
			<th>Edit User</th>
			<th>Delete User</th>
			</tr>";

			// Output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				echo "<tr><td>" . $row["usr_ID"] .
				"</td><td>" . $row["usr_Email"] .
				"</td><td>" . $row["usr_Password"] .
				"</td><td>" . $row["pri_type"] .
				"</td><td>" . $row["pri_usr_ID"] .
				
        /* This chunk of HTML allows us to edit or delete selected entries from the database */
        "<form action=\"./php/editUser.php\" method=\"POST\">" .
          "</td><td>" .
          "<input type=\"submit\" name=\"action\" value=\"Edit\"/>" .
          "</td><td>" .
          "<input type=\"submit\" name=\"action\" value=\"Delete\"/>" .
          "<input type=\"hidden\" name=\"id\" value=\"" . $row['usr_ID'] . "\"/>" .
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

	<h4>Current Tasks</h4>

	<?php

		$link = connectToServer();

		$qry = "SELECT * FROM Tasks";
		$result = mysqli_query($link, $qry);

		if(mysqli_num_rows($result) > 0) {
			echo "<table> <tr> 
			<th>tas_ID</th> 
			<th>tas_Category</th> 
			<th>tas_DueDate</th> 
			<th>tas_Priority</th>
			<th>tas_Progress</th>
			<th>tas_usr_ID</th>
			<th>Edit Task</th>
			<th>Delete Task</th>
			</tr>";

			// Output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				echo "<tr><td>" . $row["tas_ID"] .
				"</td><td>" . $row["tas_Category"] .
				"</td><td>" . $row["tas_DueDate"] .
				"</td><td>" . $row["tas_Priority"] .
				"</td><td>" . $row["tas_Progress"] .
				"</td><td>" . $row["tas_usr_ID"] . 
          
        // This chunk of HTML allows us to edit or delete selected entries from the database
        "<form action=\"./php/editTask.php\" method=\"POST\">" .
          "</td><td>" .
          "<input type=\"submit\" name=\"action\" value=\"Edit\"/>" .
          "</td><td>" .
          "<input type=\"submit\" name=\"action\" value=\"Delete\"/>" .
          "<input type=\"hidden\" name=\"id\" value=\"" . $row['tas_ID'] . "\"/>" .
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


</body>
</html>