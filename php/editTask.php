<?php

if ($_POST['action'] && $_POST['id']) {
  if ($_POST['action'] == 'Edit') {
    
    /* Let's edit a task! */
    
    $taskName = $_POST['id'];
    echo "You're currently editing " . $taskName;
  } else if($_POST['action'] == 'Delete') {
    /* Let's delete this task! */
    $taskName = $_POST['id'];
    echo "You're currently going to delete " . $taskName;
  }
}

?>