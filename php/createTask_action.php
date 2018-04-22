<?php

  require 'functions.php';

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
       header('Location: ../addgrouptotask.php');
    }
    elseif ($_POST['Sumbit'] == "Create Task without Groups") {
      redirectHome();
    }
    exit;
  } else {
    echo "Error: " . $qry . "<br>" . $link->error;
  }
?>