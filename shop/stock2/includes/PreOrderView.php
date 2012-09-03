<?php

	include ('includes/Link.php');

	echo "<b>This is Pre-Order View</b>";
	
	echo "<form action='submitPreOrder.php' method='POST'>";
	
	echo "<p><table><tr><td class='titleRow'>Email Address</td><td class='titleRow'>Qty</td><td class='titleRow'>Comment</td><td class='titleRow'>Date</td><td class='titleRow'>StockID</td><td>&nbsp;</td></tr>";
	
	$strQuery = "SELECT * FROM tbl_PreOrder order by emailaddress,date";
	
	$strResult = mysql_query ($strQuery) or die ("Query Failed: " . mysql_error());
	
	while ($line = mysql_fetch_array($strResult, MYSQL_ASSOC))
	{
		/*echo "<tr><td><a href='default.php?Action=UserDetails&UserID=" . 
		$line["emailaddress"] . "'><input type='hidden' name='detail" . $line["uid"] . "' value='" .  $line["emailaddress"] ."#" . $line["uid"] . "#" . $line["stockID"] ."x" . $line["qty"] ."'>". $line["emailaddress"] ."</a></td><td>" . $line["qty"] 
		. "</td><td>" . $line["comment"] . "</td><td>" . $line["date"] . "</td><td>" . $line["stockID"] . "</td><td><input type='checkbox' name='combineOrder'></td></tr>";*/
		
		echo "<tr><td><a href='default.php=?Action=UserDetails&UserID=" . $line["emailaddress"] . "'>" . $line["emailaddress"] . "</a></td>" .
		     "<td>" . $line["qty"] . "</td>" . 
			 "<td>" . $line["comment"] . "</td>" .
			 "<td>" . $line["date"] . "</td>" . 
			 "<td>" . $line["stockID"] . "</td>" . 
			 "<td><input type='checkbox' name='combineorder[]' value='" . $line["stockID"] .  "#" . $line["qty"] . "#" . $line["emailaddress"] . "#" . $line["uid"] . "'></td></tr>";
		
		// lets create the order.What do we need?
		
		//
		
		
	}
	
		
	echo "</table>";

	echo "<input type='submit' name='submit'>";
	
	echo "</form>";

?>
