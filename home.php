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

		<h4>Current Groups You're A Part Of:</h4>

		<?php
		$link = mysqli_connect("localhost","root", "", "Gryzl");

		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$qry = "SELECT * FROM Users INNER JOIN Group_Members ON usr_ID = grm_usr_ID WHERE usr_ID='" . $_COOKIE['current_user'] . "'";
		$result = mysqli_query($link, $qry);

		if(mysqli_num_rows($result) > 0) {
			echo "<table> <tr> 
			<th>usr_ID<\th> 
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
				"</td><td> <button type=\"button\">Edit Me!</button>" .
				"</td><td> <button type=\"button\">Delete Me!</button>" .
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

		$link = mysqli_connect("localhost","root", "", "Gryzl");

		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$qry = "SELECT * FROM Tasks WHERE tas_usr_ID='" . $_COOKIE['current_user'] . "'";
		$result = mysqli_query($link, $qry);

		if(mysqli_num_rows($result) > 0) {
			echo "<table> <tr> 
			<th>tas_ID<\th> 
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
				"</td><td> <button type=\"button\">Edit Me!</button>" .
				"</td><td> <button type=\"button\">Delete Me!</button>" .
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