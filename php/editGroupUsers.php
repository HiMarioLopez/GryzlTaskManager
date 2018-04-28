<?php echo "Editing users!<br>";

require 'functions.php';

$link = connectToServer();

$group = $_COOKIE["current_group"];
$name = $_POST["name"];

$name = sanatize($link, $name);

// TODO: Stored Procedure
$qry = "CALL editUsersDelete('$group', '$name')";

if(mysqli_query($link, $qry))
  header("Location: ./editGroup.php");
else
  echo "Error: " . $qry . "<br>" . $link->error;

exit();

?>