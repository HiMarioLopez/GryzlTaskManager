<?php

  require 'functions.php';

  $link = connectToServer();
  $old_username = $_POST["old_username"];

  $form_fields = array('usr_ID', 'usr_Email', 'usr_Password', 'pri_type');

  $qry = '';
  
  if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    foreach($form_fields as $fieldname) {
      if ( ! empty($_POST[$fieldname])) {
        
        $value = $_POST[$fieldname];
        
        if($_POST[$fieldname] != "usr_Password")
          $value = strtolower($value);
        if($_POST[$fieldname] == "usr_ID") {
          // We don't want to attempt to inner join on fifty tables
          // So I just made a function that updates the additional tables
          addUserToOtherTables($link, sanatize($value), $old_username);
        }
        
        $fieldname = sanatize($link, $fieldname);
        $qry .= "$fieldname = '$value', ";
      }
    }
  }
              
  // Remove trailing comma
  $qry = rtrim($qry);
  $qry = rtrim($qry, ",");

  $qry = "UPDATE Users INNER JOIN Privileges ON usr_ID=pri_usr_ID SET $qry WHERE usr_ID = \"$old_username\"";



  if ($link->query($qry) === TRUE) {
    redirectHome();
  } else {
      echo "Error updating record: " . $link->error;
  }

  mysqli_close($link);
  exit();

?>