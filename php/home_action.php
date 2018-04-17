<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  if($_POST['homeAction'] == 'addTask') {
    header("Location: ../createTask.html");
    exit();
  } else {
    header("Location: ../createGroup.html");
    exit();
  }
}

?>