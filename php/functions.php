<?php

  function sanatize($link, $input) {
    $input = mysqli_real_escape_string($link, $input);
    $input = strip_tags($input);
    $input = htmlentities($input);
    $input = htmlspecialchars($input);
    return $input;
  }

  function sanatizeNoSpecial($link, $input) {
    $input = mysqli_real_escape_string($link, $input);
    $input = strip_tags($input);
    $input = htmlentities($input);
    return $input;
  }

  function setGryzlCookie($cookie_name, $username) {
    unset($_COOKIE[$cookie_name]);
		// We set the cookie to expire after 30 days
    setcookie($cookie_name, $username, time() +  (86400 * 30), "/");
  }

  
  function connectToServer() {
    $link = mysqli_connect("localhost","webAccess", "jordan", "Gryzl");
    
    if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
    return $link;
  }

	function redirectHome() {      
      if($_COOKIE["current_user_permissions"] == 'ad') {
        header("Location: ../adminhome.php");
      } else
        header("Location: ../home.php");
      exit();
	}

  function checkDate6Month($taskDueDate){
    $sixMonths = date("Y-m-d", strtotime("+6 month"));
    if ($taskDueDate < $sixMonths)
      return true;
    else
      return false;
  }

  function clearStoredResults($mysqli_link) {
      while($mysqli_link->more_results()) {
           $mysqli_link->next_result();
           if($l_result = $mysqli_link->store_result()) {
                $l_result->free();
           }
       }
  }
?>