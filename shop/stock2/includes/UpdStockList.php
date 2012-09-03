<?php

	include ('includes/Link.php');
	include ('includes/SharedFunctions.php');
	echo "<b>This is a stock Search List View</b>";
	
	//query to get all baskets
	$strStockID = $_POST["stockID"];
	$strQuery = "SELECT stockID, Name, ShortDescription, RRP FROM tblItem where stockID LIKE '%" . $strStockID . "%' or name like '%" . $strStockID . "%'";
	
	//execute query
	$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());


	if (mysql_num_rows($strResult)<>0)
	{
	
		echo "<p><table><tr><td class='titleRow'>stockID</td><td class='titleRow'>Name</td><td class='titleRow'>Small Description</td><td class='titleRow'>RRP</td></tr>";
		
		while ($line = mysql_fetch_array($strResult, MYSQL_ASSOC))
		{

		echo "\n<tr>";

		echo "\n<td><a href='default.php?Action=ViewItem&stockID=" . $line["stockID"] . "'>" . $line["stockID"] . "</a></td><td>" .  $line["Name"] . "</td><td>" . $line["smallDescription"] . "</td><td>" . $line["RRP"] . "</td>";

		echo "\n</tr>";

		}
		
			
		echo "</table>";
	}
	else
	{
		echo "<p>No Outstanding orders to display!";
	}
?>
