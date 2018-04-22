<?php

  function sanatize($link, $input) {
    $input = mysqli_real_escape_string($link, $input);
    $input = strip_tags($input);
    $input = htmlentities($input);
    $input = htmlspecialchars($input);
    return $input;
  }

  function setGryzlCookie($cookie_name, $username) {
    unset($_COOKIE[$cookie_name]);
		// We set the cookie to expire after 30 days, for some reason
    setcookie($cookie_name, $username, time() +  (86400 * 30), "/");
    echo "Cookie has been set! " . $_COOKIE[$cookie_name];
  }

  // @todo: don't use root
  function connectToServer() {
    $link = mysqli_connect("localhost","root", "", "Gryzl");
    
    if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
    return $link;
  }

	function redirectHome() {      
      if($_COOKIE["current_user_permissions"] == "ad") {
        header("Location: ../adminhome.php");
      } else
        header("Location: ../home.php");
      exit();
	}

	function addUserToOtherTables($link, $username, $old_username) {
		// @TODO: STORED PROCEDURES
		
		$qry = "UPDATE Group_Members SET grm_usr_ID='$username' WHERE grm_usr_ID='$old_username'";		
		if ($link->query($qry) === TRUE) {
			redirectHome();
		} else {
				echo "Error updating record: " . $link->error;
		}
		
		$qry = "UPDATE Groups SET gro_ID='$username' WHERE gro_ownerID='$old_username'";
		if ($link->query($qry) === TRUE) {
			redirectHome();
		} else {
				echo "Error updating record: " . $link->error;
		}
		
		$qry = "UPDATE Tasks SET tas_usr_ID='$username' WHERE tas_usr_ID='$old_username'";
		if ($link->query($qry) === TRUE) {
			redirectHome();
		} else {
				echo "Error updating record: " . $link->error;
		}
		
		$qry = "UPDATE Privileges SET pri_usr_ID='$username' WHERE pri_usr_ID='$old_username'";
		if ($link->query($qry) === TRUE) {
			redirectHome();
		} else {
				echo "Error updating record: " . $link->error;
		}
		
		// Are we even using Task_Owners anymore? Who knows...
	}

?>