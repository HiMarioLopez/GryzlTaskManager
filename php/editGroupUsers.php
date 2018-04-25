<?php echo "Editing users!<br>"; 

require 'functions.php';

$link = connectToServer();

$group = $_COOKIE["current_group_name"];
$name = $_POST["name"];

$name = sanatize($link, $name);

// TODO: Stored Procedure
$qry = "DELETE FROM Group_Members WHERE grm_gro_ID='$group' AND grm_usr_ID='$name'";

if(mysqli_query($link, $qry))
  header("Location: ./editGroup.php");
else
  echo "Error: " . $qry . "<br>" . $link->error;

exit();

?>