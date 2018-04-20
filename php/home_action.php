<?php

// Navigates user to specified action.
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  
  if($_POST['homeAction'] == 'addTask')
    header("Location: ../createTask.html");
  
  else 
    header("Location: ../createGroup.html");
  
  exit();
}

?>