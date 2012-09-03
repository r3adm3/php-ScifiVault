	<?php
			//Write Debug information
			funcDebug ("this is a test debug");


			//connect to server
			funcDebug ("Connecting to database");

			$link = mysql_connect ("localhost", "sfvault_writeSto", "Ti*ESUf3*_b?Km")
					or die ("Could not connect: " . mysql_error() );

			funcDebug ("Connected to database");

			//change to correct database
			mysql_select_db ("sfvault_store") or die ("Could not select database");


	$ip = getenv("REMOTE_ADDR");
	$httpref = getenv ("HTTP_REFERER");
	$httpagent = getenv ("HTTP_USER_AGENT");

			$strBug = "<b>" . $_POST["Description"] ." </b><font size=-2><br>---------<br>ip: " . $ip .  "<br>httpref: " .$httpref . "<br>httpagent: ".$httpagent ."</font>";
			$strNow = date ('Y-m-j h:i:s');

			$strInsertQuery = "INSERT INTO tblBugs VALUES ('".$_POST["priority"]."','','','" . $strNow . "','" . $strBug . "','N','')";

			$strInsertResult = mysql_query ($strInsertQuery) or die ("Query Failed :" . mysql_error());


mail("adrian@nofishhere.com,james@scifivault.com", "BUG Report" , $_POST["Description"] . "\n\n The priority of this is " . $_POST["priority"],
     "From: webmaster@{$_SERVER['SERVER_NAME']}\r\n" .
     "Reply-To: webmaster@{$_SERVER['SERVER_NAME']}\r\n" .
     "X-Mailer: PHP/" . phpversion());

redirect( "displayBugs.php" , 1, "<B>Redirecting...</B><br> <a href='displayBugs.php'>Click here if redirect fails</a>" );

?>




<?php


   // Redirects to another Page using HTTP-META Tag
   function redirect( $url, $delay = 0, $message = "" )
   {
      /* redirects to a new URL using meta tags */
      echo "<meta http-equiv='Refresh' content='".$delay."; url=".$url."'>";
      die( "<div style='font-family: Arial, Sans-serif; font-size: 12pt;' align=center> ".$message." </div>" );
   }

	// ******************************************************************
	//
	//  Name	: funcDebug
	//  Author	: Adrian Farnell
	//  Notes	: funcDebug displays debugging info whilst page
	//		  is processing. To stop messages set $blnDebug
	//		  to false
	//
	// ******************************************************************
	function funcDebug ($strMsg)
		{
		//allow this function to "see" the global boolean set at the
		//top of the page
		global $gblnDebug;

		//only display text if $gblnDebug is set to true
		if ($gblnDebug == true)
			{

			//format now time and put into a string
			$strToday = date("H:i:s");

			//display the message with a time stamp
			echo "<!-- " .$strToday . " Debug: " . $strMsg . "--><br>\n";

			//return a value if needed
			return $retval;

			//end if statement
			}

		//end function
		}
?>












