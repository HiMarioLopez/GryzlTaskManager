<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Admin Home</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="./css/tablestyles.css">
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
</head>
<body>

  <!-- Navbar with Logout button -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Dropdown
            </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#">Disabled</a>
        </li>
      </ul>
      <button class="btn btn-outline-success my-2 my-sm-0" id="logout_button" type="submit">Logout</button>
      <script>
        var btn = document.getElementById('logout_button');
        btn.addEventListener('click', function() {
          document.location.href = 'login.html';
        });
        // This function deletes all cookies so we don't run into any issues
        btn.addEventListener('click', function() {
          var cookies = document.cookie.split(";");

          for (var i = 0; i < cookies.length; i++) {
              var cookie = cookies[i];
              var eqPos = cookie.indexOf("=");
              var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
              document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
          }
        });
      </script>
    </div>
  </nav>
  
  <div class="jumbotron">
    <h1 class="display-4">Welcome to the admin panel, <?php echo ucwords($_COOKIE['current_user']) ?>!</h1>
    <p class="lead">Easily access all the information you'll ever need.</p>
    <hr class="my-4">
    <p>What would you like to do?</p>
    <p class="lead">
      <form action="./php/home_action.php" method="POST">
        Add Group: <input type="radio" name="homeAction" value="addGroup"><br>
        Add Task:  <input type="radio" name="homeAction" value="addTask"><br>
        <input type="submit">
      </form>
    </p>

	
	<br>Current Groups You Manage:

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
      
      // This chunk of HTML allows us to edit or delete selected entries from the database
      "<form action=\"./php/editGroup.php\" method=\"POST\">" .
        "</td><td>" .
        "<input type=\"submit\" name=\"action\" value=\"Edit\"/>" .
        "</td><td>" .
        "<input type=\"submit\" name=\"action\" value=\"Delete\"/>" .
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

	<br>Current Groups You're A Part Of (But Do Not Manage):

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
	
  	<br>Your Current Tasks:

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
          "<input type=\"hidden\" name=\"cat\" value=\"" . $row['Category'] . "\"/>" .
          "<input type=\"hidden\" name=\"uname\" value=\"" . $_COOKIE["current_user"] . "\"/>" .
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
  
  	<br>Your Group Tasks:

		<?php
		$link = connectToServer();

    // Select statement for presenting relevant user data
		$qry = "select tas_ID, tas_Category, tas_DueDate, tas_Priority, tas_Progress, gro_ID from Users
    INNER JOIN Tasks ON usr_ID=tas_usr_ID INNER JOIN Task_Groups ON tas_ID=tgr_tas_ID INNER JOIN Groups ON gro_ID=tgr_gro_ID 
    WHERE usr_ID='" . $_COOKIE['current_user'] . "'";
  
		$result = mysqli_query($link, $qry);

		if(mysqli_num_rows($result) > 0) {
      // Embed image to signify which tables you can sort (right now it's just alpha)
      echo "<table id=\"taskTable\"> <tr> 
			<th>TaskID</th> 
			<th style=\"white-space:nowrap;\" onclick=\"sortTable(1)\">Category <img src=\"./res/sort-by-attributes.svg\" alt=\"SortColumn\"> </th> 
			<th style=\"white-space:nowrap;\" onclick=\"sortTable(2)\">DueDate <img src=\"./res/sort-by-attributes.svg\" alt=\"SortColumn\"> </th> 
			<th style=\"white-space:nowrap;\" onclick=\"sortTable(3)\">Priority <img src=\"./res/sort-by-attributes.svg\" alt=\"SortColumn\"> </th>
			<th style=\"white-space:nowrap;\" onclick=\"sortTable(4)\">Progress <img src=\"./res/sort-by-attributes.svg\" alt=\"SortColumn\"> </th>
			<th style=\"white-space:nowrap;\" onclick=\"sortTable(4)\">Group <img src=\"./res/sort-by-attributes.svg\" alt=\"SortColumn\"> </th>
			<th>Edit Task</th>
			<th>Delete Task</th>
			</tr>";

			// Output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				echo "<tr id=\"prio-" . $row["tas_Priority"] . "\"><td>" . $row["tas_ID"] .
				"</td><td>" . $row["tas_Category"] .
				"</td><td>" . $row["tas_DueDate"] .
				"</td><td>" . $row["tas_Priority"] .
				"</td><td>" . $row["tas_Progress"] .
				"</td><td>" . $row["gro_ID"] .

        // This chunk of HTML allows us to edit or delete selected entries from the database
        "<form action=\"./php/editTask.php\" method=\"POST\">" .
          "</td><td>" .
          "<input type=\"submit\" name=\"action\" value=\"Edit\"/>" .
          "</td><td>" .
          "<input type=\"submit\" name=\"action\" value=\"Delete\"/>" .
          "<input type=\"hidden\" name=\"id\" value=\"" . $row['tas_ID'] . "\"/>" .
          "<input type=\"hidden\" name=\"cat\" value=\"" . $row['tas_Category'] . "\"/>" .
        "</form>" .
          
				"</td></tr>";
			}
			echo "</table>";
			} else {
      // No tuples returned - show empty table
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

  <br>All Current Users:

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

	<br>All Current Tasks

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
          "<input type=\"hidden\" name=\"cat\" value=\"" . $row['tas_Category'] . "\"/>" .
          "<input type=\"hidden\" name=\"uname\" value=\"" . $row['tas_usr_ID'] . "\"/>" .
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
  </div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 
</body>
</html>