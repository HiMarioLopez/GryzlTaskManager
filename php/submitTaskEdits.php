<?php

  require 'functions.php';

  $link = connectToServer();

  $tas_ID = $_POST["taskname"];
  $tas_Priority = $_POST["priority"];
  $tas_Category = $_POST["category"];
  $tas_Progress = $_POST["progress"];
  $tas_DueDate = $_POST["duedate"];
  $oldTaskname = $_POST["old_taskname"];

  $tas_ID = sanatize($link, $tas_ID);
  $oldTaskname = sanatize($link, $oldTaskname);
  $tas_DueDate = strtotime($tas_DueDate);
  $tas_DueDate = date('Y-m-d H:i:s', $tas_DueDate);

  // Checking to see what attributes the user would like to update

  // No new task name or due date entered
  if (empty($_POST["taskname"]) && empty($_POST["duedate"])) {
  
    // Stored Procedure
    $qry = "UPDATE Tasks SET tas_Priority='$tas_Priority', tas_Category='$tas_Category', tas_Progress='$tas_Progress' WHERE tas_ID='$oldTaskname'";
    
    if (mysqli_query($link, $qry) == TRUE)
      redirectHome();
    else
      echo "Error: " . $qry . "<br>" . $link->error;
    
  // New due date was entered, but not a new task name
  } else if (empty($_POST["taskname"]) && !empty($_POST["duedate"])) {
        
    // Stored Procedure
    $qry = "UPDATE Tasks SET " . 
    "tas_Priority='" . $tas_Priority . "'," .
    "tas_Category='" . $tas_Category . "'," . 
    "tas_Progress='" . $tas_Progress . "'," .
    "tas_DueDate='" . $tas_DueDate . "' " .
    "WHERE tas_ID=\"" . $oldTaskname . "\"";
    
    if (mysqli_query($link, $qry) == TRUE)
      redirectHome();
    else
      echo "Error: " . $qry . "<br>" . $link->error;
  
  // New task name was entered, but not a new due date 
  } else if (empty($_POST["duedate"]) && !empty($_POST["taskname"])) {
    
    // Stored Procedure
    $qry = "UPDATE Tasks SET " . 
    "tas_ID=\"" . $tas_ID . "\"," .
    "tas_Priority='" . $tas_Priority . "'," .
    "tas_Category='" . $tas_Category . "'," . 
    "tas_Progress='" . $tas_Progress . "' " .
    "WHERE tas_ID=\"" . $oldTaskname . "\"";

    if (mysqli_query($link, $qry) == TRUE)
      redirectHome();
    else
      echo "Error: " . $qry . "<br>" . $link->error;
  
  // New values for everything
  } else {
    
    // Stored Procedure
    $qry = "UPDATE Tasks SET " . 
    "tas_ID=\"" . $tas_ID . "\"," .
    "tas_Priority='" . $tas_Priority . "'," .
    "tas_Category='" . $tas_Category . "'," . 
    "tas_Progress='" . $tas_Progress . "'," .
    "tas_DueDate='" . $tas_DueDate . "' " .
    "WHERE tas_ID=\"" . $oldTaskname . "\"";
    
    if (mysqli_query($link, $qry) == TRUE)
      redirectHome();
    else
      echo "Error: " . $qry . "<br>" . $link->error;
    
  } 
exit();
?>