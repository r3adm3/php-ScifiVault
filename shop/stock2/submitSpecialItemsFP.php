	<?php

		//connect to server
		include ('includes/Link.php');
		include ('includes/SharedFunctions.php');

		

		$ip = getenv("REMOTE_ADDR");
		$httpref = getenv ("HTTP_REFERER");
		$httpagent = getenv ("HTTP_USER_AGENT");

	
		
		$strNow = date ('Y-m-j G:i:s');

		$strItem1 = funcSanitize($_POST["SPitem1"]);
		$strItem2 = funcSanitize ($_POST["SPitem2"]);
		$strItem3 =  funcSanitize ($_POST["SPitem3"]);
		$strItem4 =  funcSanitize ($_POST["SPitem4"]);
		$strItem5 =  funcSanitize ($_POST["SPitem5"]);
		$strItem6 =  funcSanitize ($_POST["SPitem6"]);
		
		funcLogToDebug ("submitSpecialItemsFP.php: " . $strItem1 . "," . $strItem2 . ",". $strItem3 . "," . $strItem4 . "," . $strItem5 );
		
		//first thing is first, remove all special items (subcategory) tags for the posted category
		$strQuery = "UPDATE tblItem SET DisplayonFrontPage = '0' where DisplayonFrontPage = '1'";
		//echo $strQuery;
		$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());
		
		//run query to update 1st item
		
		$strQuery = "UPDATE tblItem SET DisplayonFrontPage = '1' where stockID = '" . $strItem1 . "'";
		//echo "<br>" . $strQuery;
		$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());
		
		//run query to update 2nd item		
		$strQuery = "UPDATE tblItem SET DisplayonFrontPage = '1' where stockID = '" . $strItem2 . "'";
		
		$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());
		
		//run query to update 3rd item
		$strQuery = "UPDATE tblItem SET DisplayonFrontPage = '1' where stockID = '" . $strItem3 . "'";
		
		$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());		


		//run query to update 4th item
		$strQuery = "UPDATE tblItem SET DisplayonFrontPage = '1' where stockID = '" . $strItem4 . "'";
		
		$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());		
		
		//run query to update 5th item
		$strQuery = "UPDATE tblItem SET DisplayonFrontPage = '1' where stockID = '" . $strItem5 . "'";
		
		$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());		

		//run query to update 6th item
		$strQuery = "UPDATE tblItem SET DisplayonFrontPage = '1' where stockID = '" . $strItem6 . "'";
		
		$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());				
		
		redirect( "default.php?Action=SpecialItems" , 0, "" );
		
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












