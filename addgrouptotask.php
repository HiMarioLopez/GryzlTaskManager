<!DOCTYPE html>
<html>

<head>
  <title>Add Group</title>
  <link rel="stylesheet" type="text/css" href="./css/style.css">
  <link rel="stylesheet" type="text/css" href="./css/tablestyles.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
</head>

<body>
  <h3>Assign groups to this task</h3>
  <form action="./php/addgrouptotask_action.php" method="post">
    <p>Group Name: <input type="text" name="newGroup" maxlength="50" required><br></p>
    <input type="submit" name="tonext" value="Add another group">
    <input type="submit" name="tonext" value="Add this group only">
  </form>
  
  <h3>Available Groups:</h3>
  
  <?php
		include_once './php/functions.php';
	
		$link = connectToServer();

		$qry = "SELECT gro_ID GroupName, gro_ownerID Owner 
						FROM Groups WHERE gro_Status='a'";
		$result = mysqli_query($link, $qry);

		if(mysqli_num_rows($result) > 0) {
			echo "<table> <tr> 
			<th>GroupName</th> 
			<th>Owner</th> 
			</tr>";

			// Output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				echo "<tr><td>" . $row["GroupName"] .
				"</td><td>" . ucwords($row["Owner"]) .
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