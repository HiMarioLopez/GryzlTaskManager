<!-- What this page currently does: (4.12.2018)
     - creates the task in Tasks
     - assigns the ownerID in the Task Owners table
     - send the user to add groups if they click either of the buttons
-->

<!-- What this page need to do: (4.12.2018)
     - send the user to the appropriate page based on what they click
-->
<?php

  require 'functions.php';

  // todo: Don't use root
  $link = connectToServer();

  $tas_ID = $_POST["taskname"];
  $tas_Priority = $_POST["priority"];
  $tas_Category = $_POST["category"];
  $tas_Progress = $_POST["progress"];
  $tas_DueDate = $_POST["duedate"];

  $tas_ID = sanatize($link, $tas_ID);
  $tas_DueDate = strtotime($tas_DueDate);
  $tas_DueDate = date('Y-m-d H:i:s', $tas_DueDate);
  
  // @todo: STORED PROCEDURE
  $taskqry = "INSERT INTO Tasks VALUES ( '". $tas_ID . "', '". $tas_Category . "', '" . $tas_DueDate . "', '" . $tas_Priority . "', ' ". $tas_Progress . "', '" . $_COOKIE['current_user'] . "');";
  $ownerqry = "INSERT INTO Task_Owners VALUES ( '" . $tas_ID . "', " . $_COOKIE["current_user"] . "');";

  if (mysqli_query($link, $taskqry) === TRUE) {
    mysqli_query($link, $ownerqry);
    
    setGryzlCookie("current_task", $tas_ID);
    
    if ($_POST['Submit'] == "Assign Groups?") {
      if
       header('Location: ../addgrouptotask.html');
    }
    elseif ($_POST['Sumbit'] == "Create Task without Groups") {
      //add group  
      header('Location: ../home.php');
    }
    exit;
  } else {
    echo "Error: " . $qry . "<br>" . $link->error;
  }
?>