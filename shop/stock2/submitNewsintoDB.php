	<?php

			//connect to server
			include ('includes/Link.php');
			include ('includes/SharedFunctions.php');



			$ip = getenv("REMOTE_ADDR");
			$httpref = getenv ("HTTP_REFERER");
			$httpagent = getenv ("HTTP_USER_AGENT");
	
		
			
			$strNow = date ('Y-m-j G:i:s');
			$strTitle = funcSanitize($_POST["Title"]);
			$strDescription = funcSanitize($_POST["Description"]);
			$strLink = $_POST["Link"];

			$strInsertQuery = "INSERT INTO tbl_News VALUES ('', '" . $strTitle . "','" . $strLink . "','" .$strNow . "','" .$strDescription."')";

			$strInsertResult = mysql_query ($strInsertQuery) or die ("Query Failed :" . mysql_error());

			redirect( "default.php?Action=News" , 1, "<B>Redirecting...</B><br> <a href='default.php?Action=News'>Click here if redirect fails</a>" );

?>




<?php


   // Redirects to another Page using HTTP-META Tag
   function redirect( $url, $delay = 0, $message = "" )
   {
      /* redirects to a new URL using meta tags */
      echo "<meta http-equiv='Refresh' content='".$delay."; url=".$url."'>";
      die( "<div style='font-family: Arial, Sans-serif; font-size: 12pt;' align=center> ".$message." </div>" );
   }


?>












