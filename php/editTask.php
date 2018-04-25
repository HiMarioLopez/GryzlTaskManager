<?php

require 'functions.php';

if ($_POST['action'] && $_POST['id']) {
	// Editing a task!
	$taskName = $_POST['id'];
  $category = $_POST['cat'];
  $username = $_POST['uname'];
  
  setGryzlCookie("current_task", $taskName);
  
	$link = connectToServer();
  if ($_POST['action'] == 'Edit') {    
    
    $qry = "CALL taskExist( \"". $taskName ."\",'" . $username ."', '" . $category . "' )";
    $result = mysqli_query($link, $qry);
    $row = mysqli_fetch_assoc($result);
	// Deleting a task!
  } else if($_POST['action'] == 'Delete') {
    $taskName = $_POST['id'];
    
    // @TODO: Stored Procedure
		// Transaction: Delete from 3 tables.
    $qry = "CALL deleteTaskFromTasks ( '" . $taskName . "', '" . $username ."', '" . $category . "')";
		$link->query($qry);
    
		$qry = "CALL deleteTaskFromTaskGroup ( ' " . $taskName . " ' , '" . $username ."', '" . $category . "')";
		$link->query($qry);
		
		$qry = "CALL deleteTaskfromProgressTask ( ' " . $taskName . " ' , '" . $username ."', '" . $category . "')";
		$link->query($qry);
		
    redirectHome();
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Create Task</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
</head>
<body>
  
  <div class="container-fluid bg">
    <div class="d-flex p-4">
      <div class="card mx-auto my-auto bg-dark text-light">
        <div class="card-body">
          <h4 class="card-title">You're currently editing <?php echo $taskName; ?></h4>
          <h5 class="card-title">So What Do You Want to Change?</h5>
          <div class="form-group">
            <form action="./submitTaskEdits.php" method="post">
              <!-- 	Not Required -->
              <label for="tname">Task Name:</label> 
                <input id="tname" class="form-control" type="text" name="taskname" maxlength="100" <?php echo "placeholder=\"" . $taskName . "\"" ?>  </input>
                <br>Current Priority: <?php echo strtoupper($row["tas_Priority"]); ?><br>
                <input type="radio" name="priority" value="h" checked> RIGHT NOW!<br>
                <input type="radio" name="priority" value="m"> Sometime Soon.<br>
                <input type="radio" name="priority" value="l"> it can wait<br>
              <br>
                Current Category: <?php echo ucwords($row["tas_Category"]); ?> <br>
                <input type="radio" name="category" value="school" checked> School <br>
                <input type="radio" name="category" value="work"> Work <br>
                <input type="radio" name="category" value="family"> Family <br>
                <input type="radio" name="category" value="organization"> Organization <br>
                <input type="radio" name="category" value="miscellaneous"> Miscellaneous <br>
              <br>
                Current Progress: <?php echo ucwords($row["tas_Progress"]); ?> <br>
                <input type="radio" name="progress" value="done" checked> D O N E <br>
                <input type="radio" name="progress" value="close"> Literally So Close <br>
                <input type="radio" name="progress" value="half"> Halfway. Glass Half Full? <br>
                <input type="radio" name="progress" value="started"> Could Be Worse <br>
                <input type="radio" name="progress" value="begin"> Lowkey Haven't Started <br>
                <div>
                    <br>
                    <!--   Not Required -->
                    <br>Current Due Date: <?php echo $row["tas_DueDate"] ?> <br>
                    <label for="duedate">New Due Date:</label>
                          <input class="form-control" id="datetime" type="datetime-local" name="duedate" 
                           min="2018-04-22T10:00" 
                           max="<2018-10-25T10:00" 
                           step="3600">
                          <span class="validity"></span><br>
                </div>
                <input type="hidden" name="old_taskname" value="<?php echo $taskName ?>">
                <input class="btn" type="Submit" name="Submit" value="Submit Changes">
                <input class="btn" type="Submit" name="Submit" value="Remove Groups">
                <input class="btn" type="Submit" name="Submit" value="Add New Groups">
            </form>
            <br><button class="btn btn-outline-success my-2 my-sm-0" id="home_button" type="submit">Go Back Home</button>
            <script>
              var btn = document.getElementById('home_button');
              btn.addEventListener('click', function() {
                var value = Cookies.get('current_user_permissions');
                console.log(value);
                if(value === "ad") document.location.href = '../adminhome.php';
                else document.location.href = '../home.php';
              });
            </script>
          </div>
          <!-- Form Group -->
        </div>
        <!-- Card Body -->
      </div>
      <!-- Card -->
    </div>
    <!-- Flex Box -->
  </div>
  <!-- Container -->  
	


</body>

<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>  
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
</html>