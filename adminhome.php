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

  
	<h2>Welcome to the admin panel, <?php echo ucwords($_COOKIE['current_user']) ?>!</h2>
  
  <button id="logout_button" style="position: absolute;top: 10px;right: 10px;">Logout</button>
  <script>
    var btn = document.getElementById('logout_button');
    btn.addEventListener('click', function() {
      document.location.href = 'login.html';
    });
  </script>

	<p>Choose what you would like to do:</p>

	<form action="./php/home_action.php" method="POST">
		Add Group: <input type="radio" name="homeAction" value="addGroup"><br>
		Add Task:  <input type="radio" name="homeAction" value="addTask"><br>
		<input type="submit">
	</form>
	

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

	<h4>Current Groups You're A Part Of (But Do Not Manage):</h4>

	<?php
	$link = connectToServer();

	$qry = "SELECT gro_ID GroupID, gro_ownerID OwnerID, gro_Status Status 
					FROM Groups INNER JOIN Group_Members ON gro_ID = grm_gro_ID 
					WHERE Group_Members.grm_usr_ID ='" . $_COOKIE['current_user'] . "' AND gro_ID NOT IN (
					SELECT gro_ID FROM Groups WHERE gro_ownerID = '" . $_COOKIE['current_user'] . "')";
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

      // This chunk of HTML allows us to edit or delete selected entries from the database
      "<form action=\"./php/leaveGroup.php\" method=\"POST\">" .
        "</td><td>" .
        "<input type=\"submit\" name=\"action\" value=\"Leave\"/></td>" .
        "<input type=\"hidden\" name=\"id\" value=\"" . $row['GroupID'] . "\"/>" .
      "</form></tr>";
		}
		echo "</table>";
		} else {
		echo "<table> <tr><td>None!</td></tr> </table>";
	}

	mysqli_free_result($result);
	mysqli_close($link);
	?>
	
  	<h4>Your Current Tasks:</h4>

		<?php
		$link = connectToServer();

		$qry = "SELECT tas_ID TaskID, tas_Category Category, tas_DueDate DueDate, tas_Priority Priority, tas_Progress Progress
						FROM Tasks WHERE tas_usr_ID='" . $_COOKIE['current_user'] . "'";
		$result = mysqli_query($link, $qry);

		if(mysqli_num_rows($result) > 0) {
			echo "<table id=\"taskTable\"> <tr> 
			<th>TaskID</th> 
			<th style=\"white-space:nowrap;\" onclick=\"sortTable(1)\">Category <img src=\"./res/sort-by-attributes.svg\" alt=\"SortColumn\"> </th> 
			<th style=\"white-space:nowrap;\" onclick=\"sortTable(2)\">DueDate <img src=\"./res/sort-by-attributes.svg\" alt=\"SortColumn\"> </th> 
			<th style=\"white-space:nowrap;\" onclick=\"sortTable(3)\">Priority <img src=\"./res/sort-by-attributes.svg\" alt=\"SortColumn\"> </th>
			<th style=\"white-space:nowrap;\" onclick=\"sortTable(4)\">Progress <img src=\"./res/sort-by-attributes.svg\" alt=\"SortColumn\"> </th>
			<th>Edit Task</th>
			<th>Delete Task</th>
			</tr>";

			// Output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				echo "<tr id=\"prio-" . $row["Priority"] . "\"><td>" . $row["TaskID"] .
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
			echo "<table> <tr><td>None!</td></tr> </table>";
		}

		mysqli_free_result($result);
		mysqli_close($link);
		?>
  
    <script>
    function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("taskTable");
    switching = true;
    // Set the sorting direction to ascending:
    dir = "asc"; 
    /* Make a loop that will continue until
    no switching has been done: */
    while (switching) {
      // Start by saying: no switching is done:
      switching = false;
      rows = table.getElementsByTagName("TR");
      /* Loop through all table rows (except the
      first, which contains table headers): */
      for (i = 1; i < (rows.length - 1); i++) {
        // Start by saying there should be no switching:
        shouldSwitch = false;
        /* Get the two elements you want to compare,
        one from current row and one from the next: */
        x = rows[i].getElementsByTagName("TD")[n];
        y = rows[i + 1].getElementsByTagName("TD")[n];
        /* Check if the two rows should switch place,
        based on the direction, asc or desc: */
        if (dir == "asc") {
          if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
            // If so, mark as a switch and break the loop:
            shouldSwitch= true;
            break;
          }
        } else if (dir == "desc") {
          if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
            // If so, mark as a switch and break the loop:
            shouldSwitch= true;
            break;
          }
        }
      }
      if (shouldSwitch) {
        /* If a switch has been marked, make the switch
        and mark that a switch has been done: */
        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        switching = true;
        // Each time a switch is done, increase this count by 1:
        switchcount ++; 
      } else {
        /* If no switching has been done AND the direction is "asc",
        set the direction to "desc" and run the while loop again. */
        if (switchcount === 0 && dir == "asc") {
          dir = "desc";
          switching = true;
        }
      }
    }
  }
  </script>

  <h4>All Current Users:</h4>

	<?php
	
		$link = connectToServer();

		$qry = "SELECT usr_ID UserID, usr_Email Email, usr_Password Password, pri_type Privileges
						FROM Users INNER JOIN Privileges ON usr_ID = pri_usr_ID";
		$result = mysqli_query($link, $qry);

		if(mysqli_num_rows($result) > 0) {
			echo "<table> <tr> 
			<th>UserID</th> 
			<th>Email</th> 
			<th>Password</th>
			<th>Privileges</th>
			<th>Edit User</th>
			<th>Delete User</th>
			</tr>";

			// Output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				echo "<tr><td>" . $row["UserID"] .
				"</td><td>" . $row["Email"] .
				"</td><td>" . $row["Password"] .
				"</td><td>" . $row["Privileges"] .
				
        /* This chunk of HTML allows us to edit or delete selected entries from the database */
        "<form action=\"./php/editUser.php\" method=\"POST\">" .
          "</td><td>" .
          "<input type=\"submit\" name=\"action\" value=\"Edit\"/>" .
          "</td><td>" .
          "<input type=\"submit\" name=\"action\" value=\"Delete\"/>" .
          "<input type=\"hidden\" name=\"id\" value=\"" . $row['UserID'] . "\"/>" .
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

	<h4>All Current Tasks</h4>

	<?php

		$link = connectToServer();

		$qry = "SELECT * FROM Tasks";
		$result = mysqli_query($link, $qry);

		if(mysqli_num_rows($result) > 0) {
			echo "<table> <tr> 
			<th>TaskID</th> 
			<th>Category</th> 
			<th>DueDate</th> 
			<th>Priority</th>
			<th>Progress</th>
			<th>OwnerID</th>
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
			echo "<table> <tr><td>None!</td></tr> </table>";
		}

		mysqli_free_result($result);
		mysqli_close($link);
	?>


</body>
</html>