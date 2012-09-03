<HTML>

	<HEAD>
		<TITLE> Update Bug </TITLE>

			<?php $gblnDebug = true; ?>

	</HEAD>

	<BODY>
		<?php
			//Write Debug information
			funcDebug ("this is a test debug");

//mail webmasters

$ip = getenv("REMOTE_ADDR");
$httpref = getenv ("HTTP_REFERER");
$httpagent = getenv ("HTTP_USER_AGENT");
			
			//connect to server
			funcDebug ("Connecting to database");

			$link = mysql_connect ("localhost", "sfvault_writeSto", "Ti*ESUf3*_b?Km")
					or die ("Could not connect: " . mysql_error() );

			funcDebug ("Connected to database");

			//change to correct database
			mysql_select_db ("sfvault_store") or die ("Could not select database");

			//run query to see if result is returned

			$strFix = funcSanitize($_POST["fix2"]);
			$strNow = date ('Y-m-j h:i:s');
			$strPriority = funcSanitize($_POST["STATUS"]);
			
			
			$strBugQuery = "SELECT * from tblBugs where IssueNo = '" . $strFix . "'";
			
			$strBugResult = mysql_query ($strBugQuery) or die ("Query Failed :" . mysql_error());
			
			while ($lineBug = mysql_fetch_array($strBugResult, MYSQL_ASSOC))
			{
			
				$arrIssue = split ("</br>", $lineBug["Issue"]);
				
				$strIssue = str_replace( "<br>", "", $arrIssue[0]);
			
			}
		
			
			
			if ($strFix <> "")
			{
			$strUpdateQuery = "UPDATE tblBugs SET Fixed = 'Y', WhenFixed = '" . $strNow . "' WHERE IssueNo = '" . $_POST["fix"] . "'";

mail("adrian@nofishhere.com,james@scifivault.com,david@scifivault.com,hilary@scifivault.com", "BUG Changed status from Open to Closed" , "Issue No: " . $_POST["fix"] . " has been closed off " . $ip . "\n\n" . $strIssue,
     "From: webmaster@{$_SERVER['SERVER_NAME']}\r\n" .
     "Reply-To: webmaster@{$_SERVER['SERVER_NAME']}\r\n" .
     "X-Mailer: PHP/" . phpversion());	

			}
			else 
			{
			
			$strUpdateQuery = "UPDATE tblBugs SET Priority = '" . $strPriority . "' WHERE IssueNo = '" . $_POST["fix2"] . "'";

mail("adrian@nofishhere.com,james@scifivault.com,david@scifivault.com,hilary@scifivault.com", "BUG Changed Priority to " . $strPriority , "Issue No: " . $_POST["fix2"] . " has changed status " . $ip  . "\n\n" . $strIssue,
     "From: webmaster@{$_SERVER['SERVER_NAME']}\r\n" .
     "Reply-To: webmaster@{$_SERVER['SERVER_NAME']}\r\n" .
     "X-Mailer: PHP/" . phpversion());	


			}

					$strUpdateResult = mysql_query ($strUpdateQuery) or die ("Query Failed :" . mysql_error());





		

	
			//close connection to database
			funcDebug ("Closing link to db");
			mysql_close ($link);

			
			redirect( "default.php?Action=ViewBugs" , 1, "<B>Redirecting...</B><br> <a href='displayBugs.php'>Click here if redirect fails</a>" );


		?>
	
</BODY>


</HTML>

<?php


   // Redirects to another Page using HTTP-META Tag
   function redirect( $url, $delay = 0, $message = "" )
   {
      /* redirects to a new URL using meta tags */
      echo "<meta http-equiv='Refresh' content='".$delay."; url=".$url."'>";
      die( "<div style='font-family: Arial, Sans-serif; font-size: 12pt;' align=center> ".$message." </div>" );
   }

function funcSanitize ($strMsg)

	{

	$ip = getenv("REMOTE_ADDR");
	$httpref = getenv ("HTTP_REFERER");
	$httpagent = getenv ("HTTP_USER_AGENT");

	$strOldMsg = $strMsg;

	funcDebug ("strOldMsg: " . $strOldMsg);

	$arrIllegalChar = array ( "?", "*", "@", "<", ">", ";", ":", "-", "%", "1=1", "=", "\\", "#", "'", "WHERE", "where", "SELECT", "select", "INSERT", "insert", "DELETE", "delete", "FROM", "from");

	foreach ( $arrIllegalChar as $k )
		{

			//funcDebug ("Illegal Char: " . $k . " ");

			while ( ($j=strpos($strMsg,$k)) !== false )
			{

				$strMsg = substr($strMsg,0,$j).substr($strMsg,$j+1);

			}

		}

	if ($strMsg != $strOldMsg)
	{
		funcDebug ("Original Msg: " . $strOldMsg);
		funcDebug ("Cleaned Text: " . $strMsg);

		//log it to transaction database

		//connect to server
		funcDebug ("Connecting to database");

		$link = mysql_connect ("localhost", "sfvault_writeSto", "Ti*ESUf3*_b?Km")
				or die ("Could not connect: " . mysql_error() );

		funcDebug ("Connected to database");

		//change to correct database
		mysql_select_db ("sfvault_store") or die ("Could not select database");

		//run query to see if result is returned

		$strNow = date ('Y-m-j h:i:s');

		$strEditedInsert = "illegal symbol existed in query and was cleaned (old: " . $strOldMsg . " , new:" . $strMsg . ", ip: " . $ip . ", httpagent: " . $httpagent . ")";

		$strLogInsert = "INSERT INTO tblLog Values ('" . $strNow . "','DEV','" . $strEditedInsert . "')";

		funcDebug ("strLogInsert: " . $strLogInsert);

		$strInsertLogEntry = mysql_query ($strLogInsert) or die ("Log Entry Failed");

	}
	else
	{

	}

	return ($strMsg);

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





