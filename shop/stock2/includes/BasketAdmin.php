<?php

	include ('includes/Link.php');

	echo "<b>This is the Basket Admin View</b>";
	

	
	//query to get all baskets
	$strQuery = "SELECT distinct(c.AutoNumber), t.PHPSessionID, c.timeStmp
		FROM tblBasket t
		INNER JOIN tblSession c
		ON t.PHPSessionID = c.PHPSessionID
		ORDER BY c.AutoNumber";

	//execute query
	$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());


	if (mysql_num_rows($strResult)<>0)
	{
	
		echo "<form action='DeleteBasket.php' method=POST>";
	
		echo "<p><table><tr><td class='titleRow'>Basket No</td><td class='titleRow'>Session ID</td><td class='titleRow'>Last Accessed</td><td class='titleRow'>Delete?</td></tr>";
		
		while ($line = mysql_fetch_array($strResult, MYSQL_ASSOC))
		{

		echo "\n<tr>";

		echo "\n<td>" . $line["AutoNumber"] . "</td><td><a href='default.php?Action=BasketContents&BasketID=" . $line["PHPSessionID"] . "'>" . $line["PHPSessionID"] . "</a></td><td>". $line["timeStmp"] ."</a></td><td><input type='radio' name='ToDelete' value='" . $line["PHPSessionID"] . "'></td>";

		echo "\n</tr>";

		}
		
			
		echo "</table>";
		
		echo " <input type='submit' name='Update' value='Update'></form>";
	}
	else
	{
		echo "<p>No Baskets to display!";
	}
?>
