<!-- NOT COMPLETED -->
<?php

require 'functions.php';

$link = connectToServer();

  $form_fields = array('gro_ID', 'gro_ownerID', 'gro_Status');
  $qry = '';
  
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    foreach($form_fields as $fieldname) {
      if ( ! empty($_POST[$fieldname])) {
        
        $value = $_POST[$fieldname];
        $value = sanatize($link, $value);
        
        $qry .= "$fieldname = '$value', ";
      }
    }
              
    // Remove trailing comma
    if ($qry != "") {
      $qry = rtrim($qry);
      $qry = rtrim($qry, ",");
    }
    
    // Saves original "query" before we override it
    $collection = $qry;
    
    // @TODO: Stored Procedure
    $qry = "UPDATE Users INNER JOIN Privileges ON usr_ID = pri_usr_ID SET $qry 
            WHERE gro = \"$old_username\"";
    
    if ($collection != "") {
      if ($link->query($qry) === TRUE)
        redirectHome();
      else
        echo "Error updating record: " . $link->error;
    }
  }

?>