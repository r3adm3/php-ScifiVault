<?php

	include ('includes/Link.php');
	include ('includes/SharedFunctions.php');
	echo "<b>This is the User List View</b>";
	
	$strUserID = funcSanitize($_POST["UserID"]);
	
	//query to get all baskets
	$strQuery = "SELECT * FROM tbl_UserLogin where emailAddress like '%" . $strUserID . "%' order by LastLoginTime DESC";
	
	//execute query
	$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());


	if (mysql_num_rows($strResult)<>0)
	{
	
		echo "<p><table><tr><td class='titleRow'>User</td><td class='titleRow'>Country</td><td class='titleRow'>Verified</td><td class='titleRow'>Created</td><td class='titleRow'>Last Login</td></tr>";
		
		while ($line = mysql_fetch_array($strResult, MYSQL_ASSOC))
		{

		echo "\n<tr>";

		echo "\n<td><a href='default.php?Action=UserDetails&UserID=" . $line["UserID"] . "'>" . $line["UserID"] . "</a></td><td>" . trim (funcDecrypt (hex2bin ( $line["Country"]))) . "</td><td>" . $line["UserVerified"] . "</td><td>" . $line["CreateDate"] . "</td><td>" . $line["LastLoginTime"] . "</td>";

		echo "\n</tr>";

		}
		
			
		echo "</table>";
	}
	else
	{
		echo "<p>No Outstanding orders to display!";
	}
?>
