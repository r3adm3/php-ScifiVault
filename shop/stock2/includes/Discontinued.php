<?php

	include ('includes/Link.php');
	include ('includes/SharedFunctions.php');
	echo "<b>This is the Discontinued Stock View</b>";
	
	$strUserID = funcSanitize($_POST["UserID"]);
	
	//query to get all baskets
	$strQuery = "SELECT stockID, Name, NoOfItems, RRP FROM tblItem where NoOfItems = -1 order by NoOfItems";
	
	//execute query
	$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());


	if (mysql_num_rows($strResult)<>0)
	{
	
		echo "<p><table><tr><td class='titleRow'>stockID</td><td class='titleRow'>Name</td><td class='titleRow'>NoOfItems</td><td class='titleRow'>RRP</td></tr>";
		
		while ($line = mysql_fetch_array($strResult, MYSQL_ASSOC))
		{

		echo "\n<tr>";

		echo "\n<td><a href='default.php?Action=ViewItem&stockID=" . $line["stockID"] . "'>" . $line["stockID"] . "</a></td><td>" . $line["Name"] . "</td><td>" . $line["NoOfItems"] . "</td><td>" . $line["RRP"] . "</td>";

		echo "\n</tr>";

		}
		
			
		echo "</table>";
	}
	else
	{
		echo "<p>No Outstanding orders to display!";
	}
?>
