<?php

	include ('includes/Link.php');
	include ('includes/SharedFunctions.php');
	
	$basketCode = funcSanitize ($_GET["BasketID"]);	
	
	echo "<b>This is the Basket Contents View (" . $basketCode . ")</b>";

	//query to get all items in basket
	$strQuery = "SELECT t.item, c.name, t.qty, c.RRP, c.SaleRRP, c.ShortDescription, c.stockID
		FROM tblBasket t
		INNER JOIN tblItem c
		ON t.item = c.stockId
		WHERE t.PHPSessionID = '" . $basketCode . "'";

	//execute query
	$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());


	if (mysql_num_rows($strResult)<>0)
	{

		echo "<p><table><tr><td class='titleRow'>Qty</td><td class='titleRow'>Name</td><td class='titleRow'>QuickFind</td><td class='titleRow'>Cost/Item</td><td class='titleRow'>Cost</td></tr>";
		
		while ($line = mysql_fetch_array($strResult, MYSQL_ASSOC))
		{

			if ($line["RRP"] == $line["SaleRRP"] or $line["SaleRRP"]==0.00)
			{	
				$strPrice = $line["RRP"];
			}
			else
			{
				$strPrice = $line["SaleRRP"];
			}
		
		echo "\n<tr>";

		echo "\n<td>" . $line["qty"] . "</td><td>&nbsp;" . $line["name"] . "&nbsp;</td><td><a href='default.php?Action=ViewItem&stockID=" . $line["stockID"] . "'>" . $line["stockID"] . "</a></td><td>". sprintf ("%01.2f",$strPrice) ."</td><td>" . sprintf ("%01.2f",$strPrice * $line["qty"]) . "</td>";

		echo "\n</tr>";

		}
		
			
		echo "</table>";
		
		
	}
	else
	{
		echo "<p>Nothing in this basket!";
	}
?>
