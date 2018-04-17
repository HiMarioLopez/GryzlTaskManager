<!-- What this page currently does (4.12.2018)
     - will check the submit button to see if there is another group to add or to go to the home page if no more are added
-->
<!-- What this page needs to do: (4.12.2018)
      - physically adding the group to the database (not currently adding the groups to the database)
      - cookies needed: taskID from make task page
      - need to also insert the new group ID 
-->

<?php
  require 'functions.php';

  // todo: Don't use root
  $link = connectToServer();

  $qry = "INSERT INTO Task_Groups (tgr_tas_ID, tgr_gro_ID) VALUES ('" . $_COOKIE["currTaskName"] . "', '" . $_POST["newGroup"] . "');";
  
  if (mysqli_query($qry, $link) === TRUE){
    if($_POST['tonext'] == "Add another group"){
       header('Location: ./addgrouptotask.html');
       exit;
    } else if ($_POST['tonext'] == "Add this group only"){
       header('Location:../home.php');
       exit;
    }
  } else {
    echo "error: " . mysqli_query($qry, $link)->error_log;
  }
  
?>