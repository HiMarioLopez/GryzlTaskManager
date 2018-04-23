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
  $date = date('m/d/Y h:i:s a', time());  

  // @todo: STORED PROCEDURE
  $taskqry = "CALL createTask( '$tas_ID', '$tas_Category', '$tas_DueDate', '$tas_Priority', '$tas_Progress', '" . $_COOKIE['current_user'] . "')";
  $progqry = "CALL createProgTask ('$tas_ID', '$date')";

  if (mysqli_query($link, $taskqry) === TRUE) {
    $link->query($ownerqry);
    $link->query($progqry);
    
    setGryzlCookie("current_task", $tas_ID);
    
    if ($_POST['Submit'] == "Assign Groups?") {
       header('Location: ../addgrouptotask.php');
    }
    elseif ($_POST['Submit'] == "Create Task without Groups") {
      redirectHome();
    }
    exit;
  } else {
    echo "Error: " . $qry . "<br>" . $link->error;
  }
?>