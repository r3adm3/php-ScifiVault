<?php

	include ('includes/Link.php');
	include ('includes/SharedFunctions.php');
	echo "<b>This is the Low Stock View</b>";
	
	$strUserID = funcSanitize($_POST["UserID"]);
	
	//query to get all baskets
	$strQuery = "SELECT IssueNo,DateStamp,Issue,Priority FROM tblBugs where Fixed = 'N' order by Priority";
	
	//execute query
	$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());


	if (mysql_num_rows($strResult)<>0)
	{
	
		echo "<p><table width='700'><tr><td class='titleRow'>Issue No</td><td class='titleRow'>DateStamp</td><td class='titleRow'>Issue</td><td class='titleRow'>Priority</td><td class='titleRow'>Close?</td></tr>";
		
		while ($line = mysql_fetch_array($strResult, MYSQL_ASSOC))
		{

		echo "\n<form method='POST' action='updateBug.php'><tr>";

		echo "\n<td>" . $line["IssueNo"] . "</td><td>" . $line["DateStamp"] . "</td><td>" . $line["Issue"] . "</td><td>";
		
		echo "<select name='STATUS'>";
		
		switch ($line["Priority"])
		{
			case "HIGH":
				echo "<OPTION VALUE='HIGH' selected='selected'>HIGH</OPTION><OPTION VALUE='MEDIUM'>MEDIUM</OPTION><OPTION VALUE='LOW'>LOW</OPTION>";
				break;
			case "MEDIUM":
				echo "<OPTION VALUE='HIGH'>HIGH</OPTION><OPTION VALUE='MEDIUM' selected='selected'>MEDIUM</OPTION><OPTION VALUE='LOW'>LOW</OPTION>";
				break;
			case "LOW":
				echo "<OPTION VALUE='HIGH'>HIGH</OPTION><OPTION VALUE='MEDIUM'>MEDIUM</OPTION><OPTION VALUE='LOW' selected='selected'>LOW</OPTION>";
				break;
		}	
		
		echo "</select>";
		echo "<input type='hidden' name='fix2' value='" . $line["IssueNo"] . "'>";
		echo "</td><td><input type='radio' name='fix' value='" . $line["IssueNo"] . "'></td><td><input type='submit' value='Update' name='B1'></td>";

		echo "\n</tr></form>";

		}
		
			
		echo "</table><br>";
	}
	else
	{
		echo "<p>No Outstanding orders to display!";
	}
?>
