	<?php

		//connect to server
		include ('includes/Link.php');
		include ('includes/SharedFunctions.php');



		$ip = getenv("REMOTE_ADDR");
		$httpref = getenv ("HTTP_REFERER");
		$httpagent = getenv ("HTTP_USER_AGENT");

	
		
		$strNow = date ('Y-m-j G:i:s');

		//$strPrice = substr($item, strpos($item,"(" )+1 , strrpos($item,")")- strpos($item,"(" )-1);
		
		//echo $_POST["SubjectTag"];
		$strSTag = funcSanitize (substr ($_POST["SubjectTag"], 0, strpos($_POST["SubjectTag"], "#")));
		//echo "<br>"  . $strSTag;
		$strCTag = funcSanitize (substr ($_POST["SubjectTag"], strpos($_POST["SubjectTag"], "#")+1, strrpos($_POST["SubjectTag"], "#") -1  - strpos($_POST["SubjectTag"], "#")));
		//echo "<br>" . $strVTag;
		$strVTag = funcSanitize (substr ($_POST["SubjectTag"], strrpos($_POST["SubjectTag"], "#")+1));
		//echo "<br>" . $strCTag;
		$strItem1 = funcSanitize($_POST["item1"]);
		$strItem2 = funcSanitize ($_POST["item2"]);
		$strItem3 =  funcSanitize ($_POST["item3"]);

		//first thing is first, remove all special items (subcategory) tags for the posted category
		$strQuery = "UPDATE tblItem SET DisplayonSubCatPage = '0' where SubjectTag = '" .  $strSTag . "' and CategoryTag = '" . $strCTag. "' and VersionTag = '" . $strVTag . "' and DisplayonSubCatPage = '1'";
		//echo $strQuery;
		$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());
		
		//run query to update 1st item
		
		$strQuery = "UPDATE tblItem SET DisplayonSubCatPage = '1' where stockID = '" . $strItem1 . "'";
		//echo "<br>" . $strQuery;
		$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());
		
		//run query to update 2nd item		
		$strQuery = "UPDATE tblItem SET DisplayonSubCatPage = '1' where stockID = '" . $strItem2 . "'";
		
		$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());
		
		//run query to update 3rd item
		$strQuery = "UPDATE tblItem SET DisplayonSubCatPage = '1' where stockID = '" . $strItem3 . "'";
		
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












