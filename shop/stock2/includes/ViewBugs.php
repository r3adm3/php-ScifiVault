<?php

	include ('includes/Link.php');
	include ('includes/SharedFunctions.php');
	echo "<b>This is the View Bugs View</b>";
	
	$strUserID = funcSanitize($_POST["UserID"]);
	
	//query to get all baskets
	$strQuery = "SELECT IssueNo,DateStamp,Issue,Priority FROM tblBugs where Fixed = 'N' order by Priority";
	
	//execute query
	$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());


	if (mysql_num_rows($strResult)<>0)
	{
	
		echo "<p><table width='700'><tr><td class='titleRow'>Issue No</td><td class='titleRow'>DateStamp</td><td class='titleRow'>Issue</td><td class='titleRow'>Priority</td><td class='titleRow'>Close?</td></tr>";
		
		$i = 1;
		
		while ($line = mysql_fetch_array($strResult, MYSQL_ASSOC))
		{

		if ($i %2 == 0)
		{
			$strFormat = "seconda";
		}
		else
		{
			$strFormat = "secondb";
		}
		
		echo "\n<form method='POST' action='updateBug.php'><tr>";

		echo "\n<td class='" . $strFormat . "'>" . $line["IssueNo"] . "</td><td class='" . $strFormat . "'>" . $line["DateStamp"] . "</td><td class='" . $strFormat  . "'>" . $line["Issue"] . "</td><td class='" .  $strFormat . "'>";
		
		echo "<select name='STATUS'>";
		
		switch ($line["Priority"])
		{
			case "1":
				echo "<OPTION VALUE='1' selected='selected'>HIGH</OPTION><OPTION VALUE='2'>MEDIUM</OPTION><OPTION VALUE='3'>LOW</OPTION><OPTION VALUE='4'>FEATURE</OPTION>";
				break;
			case "2":
				echo "<OPTION VALUE='1'>HIGH</OPTION><OPTION VALUE='2' selected='selected'>MEDIUM</OPTION><OPTION VALUE='3'>LOW</OPTION><OPTION VALUE='4'>FEATURE</OPTION>";
				break;
			case "3":
				echo "<OPTION VALUE='1'>HIGH</OPTION><OPTION VALUE='2'>MEDIUM</OPTION><OPTION VALUE='3' selected='selected'>LOW</OPTION><OPTION VALUE='4'>FEATURE</OPTION>";
				break;
			case "4":
				echo "<OPTION VALUE='1'>HIGH</OPTION><OPTION VALUE='2'>MEDIUM</OPTION><OPTION VALUE='3'>LOW</OPTION><OPTION VALUE='4' selected='selected'>FEATURE</OPTION>";
				break;
		}	
		
		echo "</select>";
		echo "<input type='hidden' name='fix2' value='" . $line["IssueNo"] . "'>";
		echo "</td><td class='" . $strFormat . "'><input type='radio' name='fix' value='" . $line["IssueNo"] . "'></td><td><input type='submit' value='Update' name='B1'></td>";

		echo "\n</tr></form>";

			$i = $i + 1;
		
		}
		
			
		echo "</table><br>";
	}
	else
	{
		echo "<p>No Outstanding orders to display!";
	}
?>
