<!-- What this page currently does (4.12.2018)
     - adds members to a group that has already set the cookie
-->

<!-- What this page need (4.12.2018)
     - check if the user even exists in the database
     - needs to clear the cookie/delete it when it is done
-->

<?php
  // todo: Don't use root
  $link = mysqli_connect("localhost","root", "", "Gryzl");

  $newuser = $_POST["newuser"];
  $moremems= $_POST["addmems"];
  $qry = "SELECT COUNT(*) FROM Users WHERE Users.usr_ID = '" . $newuser . "' GROUP BY usr_ID;";
  $result = mysqli_query($link, $qry);

  if ( $result == TRUE) {
    $qry = "INSERT INTO Group_Members (grm_gro_ID, grm_usr_ID) VALUES ( '". $_COOKIE["currGroupName"]  . "', ' ". $newuser . "');";
    if (mysqli_query($link, $qry) === TRUE) {
      if ($moremems  == 'done') {
        header('Location: ../home.php');
      } else {
        header('Location: ../addmemstogroup.html');
      }
    } 
    exit;
  } else {
      echo "Error2: " . $qry . "<br>" . $link->error;
  }
?>
