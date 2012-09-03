 <HTML>

	<HEAD>
		<TITLE> Update Bug </TITLE>

			<?php $gblnDebug = true; ?>

	</HEAD>

	<BODY>
		<?php

			include ('includes/SharedFunctionsStrict.php');

			//Write Debug information
			funcDebug ("this is a test debug");


			//connect to server
			funcDebug ("Connecting to database");

			$link = mysql_connect ("localhost", "sfvault_writeSto", "Ti*ESUf3*_b?Km")
					or die ("Could not connect: " . mysql_error() );

			funcDebug ("Connected to database");

			//change to correct database
			mysql_select_db ("sfvault_store") or die ("Could not select database");

			//run query to see if result is returned

			$strNow = date ('Y-m-j h:i:s');
			$strStatus = funcSanitize($_POST["STATUS"]);
			$strOrder = funcSanitize($_POST["orderno"]);
			
			funcLogToDebug ("updateOrder.php: Order (" . $strOrder . ") changed status to " . $strStatus );
			
			$strUpdateQuery = "UPDATE tbl_Orders SET Status = '" . $strStatus . "' WHERE OrderNo = '" . $strOrder . "'";


			$strUpdateResult = mysql_query ($strUpdateQuery) or die ("Query Failed :" . mysql_error());

			//query to get all baskets
			$strQuery = "SELECT * FROM tbl_Orders where OrderNo = '" . $strOrder . "'";

			//execute query
			$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());

while ($line = mysql_fetch_array($strResult, MYSQL_ASSOC))
{

	$strOrderNo= $line["OrderNo"];
	$strOrderSubmitted = $line["DateTme"];
	$strCookie = $line["Cookie"];
	$strItems = $line["Items"];
	$strShipping = $line["Shipping"];
	$strCost = $line["Cost"];
	$strAddress = $line["Address"];
	$strEmailAddress = $line["emailaddress"];
	$strName = $line["Name"];
	$strPhone = $line["Phone"];
	$strIPNSubmitted = $line["IPNDateTime"];
	$strPaypalTXN = $line["PaypalTXN"];
	$strStatus = $line["Status"];

	/*echo "<tr><td>Order No:</td><td>" . $strOrderNo . "</td></tr>";
	echo "<tr><td>Date Submitted:</td><td>" . $strOrderSubmitted . "</td></tr>";
	echo "<tr><td>Cookie:</td><td>" . $strCookie . "</td></tr>";
	echo "<tr><td>Items:</td><td>" . $strItems . "</td></tr>";
	echo "<tr><td>Cost:</td><td>" . $strCost . "</td></tr>";
	echo "<tr><td>Address:</td><td>" . $strAddress . "</td></tr>";
	echo "<tr><td>Name:</td><td>" . $strName . "</td></tr>";
	echo "<tr><td>Phone:</td><td>" . $strPhone . "</td></tr>";
	echo "<tr><td>IPN Recieved:</td><td>" . $strIPNSubmitted . "</td></tr>";
	echo "<tr><td>PayPal Txn No:</td><td>" . $strPaypalTXN . "</td></tr>";
	*/
}


//mail webmasters

$ip = getenv("REMOTE_ADDR");
$httpref = getenv ("HTTP_REFERER");
$httpagent = getenv ("HTTP_USER_AGENT");

switch ($strStatus)
{

	case "CANCELLED":
	
		//echo "Hello!";
		$arrItems = split(';', $strItems);
		foreach ($arrItems as $item)
		{
			
			//echo "<br>" . $item;
			
			//break up $item into a qty and a stock code....
			$stockID = substr($item, 0, strpos($item, "(" ));
			
			$qty = substr($item, strpos($item, "x")+1);
			
			//echo "<br>" . $stockID . " * " . $qty;
			
			//re add the item into stock
			if ($stockID <> '')
			{
				funcDeleteItem ($stockID, $qty);

				//change the status of the order, that's already done higher up tho.			
				
				//log it				
				funcLogtoDebug ("updateOrder.php: (" . $stockID. "*" . $qty . ") Item returned to stock");
				
			}
			

			
 
			
		
		}
		
		
		
		exit;

	break;


	case "PROBLEM":

		$arrItems=split(';', $strItems);
		$strOrderList = "";
		foreach ($arrItems as $item)
		{
			//echo "Value: " . substr($item, 0, strpos($item, "(" )) . "<br />" ;

			$strItemQueryX = "SELECT Name from tblItem where stockID = '" . substr($item, 0, strpos($item, "(" )) . "'";
			$strItemResultX = mysql_query($strItemQueryX) or die ("Query Failed :" . mysql_error());

			$strStockIDX = substr($item, 0, strpos($item, "(" ));

			while ($lineItem = mysql_fetch_array($strItemResultX, MYSQL_ASSOC))
			{
				$strNamedItem = $lineItem["Name"];
				$strPrice = substr($item, strpos($item,"(" )+1 , strrpos($item,")")- strpos($item,"(" )-1);
				$strQty = substr($item, strpos($item, "x")+1);

				$strOrderList = $strOrderList . " " . $strNamedItem . "\t" . $strQty . "\t\t�" . $strPrice . "\n";

				//echo "<tr><td>" . $strQty . "</td><td><a href='displayItem.php?Item=" . $strStockID . "'>" . $strStockID . "</a></td><td><a href='displayItem.php?Item=" . $strStockID . "'>" . $strNamedItem . "</a></td><td align='right'>&pound;" . $strPrice ."</td><td align='right'>&pound;" . $strPrice * $strQty. "</td></tr><br />";
			}
		}
		$strDeliveryPlusTotal = $strShipping + $strCost;

$strMailText = "Order No: " . $strOrderNo . "
We are having difficulty with your order

----------------------------------------------------------
 Name		Qty			Price
----------------------------------------------------------
" . $strOrderList . "
----------------------------------------------------------
				DELIVERY: �" . $strShipping. "
				----------------------
				TOTAL: �" . $strDeliveryPlusTotal . "
				----------------------

Order Status: Problem

Your orders status has been changed to Problem.  This could be due to either: Your payment from Paypal has not been confirmed or the address you provided during registration is diffrent from the address provided by Paypal.

If you have any queries in relation to the above order, please contact our Customer Service department at info@scifivault.com

If you wish to cancel this order, please email info@scifivault.com.

Thank you for ordering with Sci-Fi Vault Ltd

By receiving this email from scifivault.com you are accepting our terms and conditions, a copy of which can be found on the website at: http://shop.scifivault.com/terms.htm
";

		mail($strEmailAddress .", webmaster@scifivault.com", "ScifiVault.com, Problems with your order." , $strMailText,
		     "From: webmaster@{$_SERVER['SERVER_NAME']}\r\nBCC:webmaster@{$_SERVER['SERVER_NAME']},david@scifivault.com, adrian@nofishhere.com, hilary@scifivault.com\r\n" .
		     "Reply-To: webmaster@{$_SERVER['SERVER_NAME']}\r\n" .
			"X-Mailer: PHP/" . phpversion());

		funcLogtoDebug ("updateOrder.php: Order(" . $strOrder . ") sent order problem summary mail");



		break;
	case "SENT":

		$arrItems=split(';', $strItems);
		$strOrderList = "";
		foreach ($arrItems as $item)
		{
			//echo "Value: " . substr($item, 0, strpos($item, "(" )) . "<br />" ;

			$strItemQueryX = "SELECT Name from tblItem where stockID = '" . substr($item, 0, strpos($item, "(" )) . "'";
			$strItemResultX = mysql_query($strItemQueryX) or die ("Query Failed :" . mysql_error());

			$strStockIDX = substr($item, 0, strpos($item, "(" ));

			while ($lineItem = mysql_fetch_array($strItemResultX, MYSQL_ASSOC))
			{
				$strNamedItem = $lineItem["Name"];
				$strPrice = substr($item, strpos($item,"(" )+1 , strrpos($item,")")- strpos($item,"(" )-1);
				$strQty = substr($item, strpos($item, "x")+1);

				$strOrderList = $strOrderList . " " . $strNamedItem . "\t" . $strQty . "\t\t�" . $strPrice . "\n";

				//echo "<tr><td>" . $strQty . "</td><td><a href='displayItem.php?Item=" . $strStockID . "'>" . $strStockID . "</a></td><td><a href='displayItem.php?Item=" . $strStockID . "'>" . $strNamedItem . "</a></td><td align='right'>&pound;" . $strPrice ."</td><td align='right'>&pound;" . $strPrice * $strQty. "</td></tr><br />";
			}
		}
		$strDeliveryPlusTotal = $strShipping + $strCost;

$strMailText = "Order No: " . $strOrderNo . "
Your Item has been sent:

----------------------------------------------------------
 Name		Qty			Price
----------------------------------------------------------
" . $strOrderList . "
----------------------------------------------------------
				DELIVERY: �" . $strShipping. "
				----------------------
				TOTAL: �" . $strDeliveryPlusTotal . "
				----------------------

Order Status: Dispatched

Your order status has been changed to Dispatched and is now on it's way.

If you have any queries in relation to the above order, please contact our Customer Service department at info@scifivault.com

If you wish to cancel this order, please email info@scifivault.com with your order reference within 7 days of receiving the goods.

Thank you for ordering with Sci-Fi Vault Ltd

By receiving this email from scifivault.com you are accepting our terms and conditions, a copy of which can be found on the website at: http://shop.scifivault.com/terms.htm
";

		mail($strEmailAddress . ", webmaster@scifivault.com" , "ScifiVault.com Order Dispatched" , $strMailText,
		     "From: webmaster@{$_SERVER['SERVER_NAME']}\r\nBCC:webmaster@{$_SERVER['SERVER_NAME']}, david@scifivault.com, adrian@nofishhere.com, hilary@scifivault.com\r\n" .
		     "Reply-To: webmaster@{$_SERVER['SERVER_NAME']}\r\n" .
			"X-Mailer: PHP/" . phpversion());

		funcLogtoDebug ("updateOrder.php: Order(" . $strOrder . ") sent order dispatched summary mail");




		break;
	default:
		break;



}


			//close connection to database
			funcDebug ("Closing link to db");
			mysql_close ($link);


			redirect( "default.php?Action=OutstandingOrders" , 1, "<B>Redirecting...</B><br> <a href='displayBugs.php'>Click here if redirect fails</a>" );


		?>
	
</BODY>


</HTML>

<?php

function funcDeleteItem ($itemcode, $qty)
{

	funcLogtoDebug ("updateOrder.php: funcDeleteItem fired (" . $itemcode . "*" . $qty . ")");

	//$qty = funcSanitize($_POST['qty']);
	//$itemcode = funcSanitize($_POST['item']);
	$strBool = 0;
	$counter = 0;

	//additional check to make sure $qty is a numeric
	if (ereg ("[0-9]+", $qty))
	{
		funcDebug ("Quantity string is numeric");
	}
	else
	{
	
		echo "Invalid Input, stop trying to put non-numerics in the quantity field";
		exit();
	}



	//is row locked?
	$strLockCheck = "SELECT ColumnLock FROM tblItem WHERE stockID = '" . $itemcode ."'";
	$strLockResult = mysql_query ($strLockCheck) or die ("Query Failed: " . mysql_error());
	
	while ($line = mysql_fetch_array($strLockResult, MYSQL_ASSOC))
	{
		if ($line["ColumnLock"] == 'YES')
		{
			echo "Item being edited, please try again";
			echo "<br><a href='index3.php'>Back to Shop</a>";
			exit();
			//possible retry, or forward on back to original page??
		}
		else
		{
			funcLogtoDebug ("updateOrder.php: No locks, Free to carry on");
		}
	}
	
	//set row lock on in tblItem
	$strLockQuery = "UPDATE tblItem SET ColumnLock = 'YES' WHERE stockID = '" . $itemcode ."'";
	mysql_query ($strLockQuery) or die ("Query Failed: " . mysql_error());

	//Lets see how much stock for this item there is
	//$strStockQuery = "SELECT Qty FROM tblBasket where item = '" . $itemcode ."' and PHPSessionID = '" . $strSessionID . "'";
	//$strStockResult = mysql_query ($strStockQuery) or die ("Query Failed:" . mysql_error());

	//while ($line = mysql_fetch_array($strStockResult, MYSQL_ASSOC))
	//{
	
			
		if ($itemcode <> '')
		{
			//great we have some stock
			funcDebug ($itemcode . " in basket: " . $line["Qty"]);	
		
			//$qty = $line["Qty"] - $qty;
		
			funcDebug ("Request to return " . $qty . " of " . $itemcode );
			
			//insert/update into tblBasket
			$strBasket = "SELECT * FROM tblItem where stockID = '" . $itemcode . "'";
			$strBasketResult = mysql_query ($strBasket) or die ("Basket Query Failed:" . mysql_error());
			
			$conNumberofRows = mysql_num_rows($strBasketResult);
			
			if ($conNumberofRows == 1)
			{
				//need to update the table
				$line2 = mysql_fetch_array ($strBasketResult, MYSQL_ASSOC);
				funcDebug ("Quantity of " . $itemcode ." in stock is " . $line2["NoOfItems"]);
				$strUpdatedBasketValue = $line2["NoOfItems"] + $qty;
				$strAddToBasket = "UPDATE tblItem SET NoOfItems = '" . $strUpdatedBasketValue . "' where stockID = '" . $itemcode . "'";
				mysql_query ($strAddToBasket) or die ("Update Basket Query Failed:" . mysql_error());
			}
			else
			{
				//catchall for invalid entries in basket. stops 
				//before making any changes in the main tblItems.
				echo "Invalid number of rows in stock database, please contact us";
				$strLockQuery = "UPDATE tblItem SET ColumnLock = '' where stockID = '" . $itemcode ."'";
				mysql_query ($strLockQuery) or die ("Query Failed: " . mysql_error());			
				exit();
			}


			//update tblItems with new stock value
			/*$strUpdatedStockValue = $line["Qty"] - $qty;
			funcDebug ("Updated stock value: " . $strUpdatedStockValue);
			
			if ($strUpdatedStockValue == 0)
			{
			
				$strUpdateStockQuery = "DELETE FROM tblBasket where item = '" . $itemcode . "' and PHPSessionID = '" . $strSessionID . "'";
				mysql_query ($strUpdateStockQuery) or die ("Update Query Failed: " . mysql_error());
			}
			else
			{
				$strUpdateStockQuery = "UPDATE tblBasket SET qty = '" .$strUpdatedStockValue . "' WHERE item = '" . $itemcode ."' and PHPSessionID = '" . $strSessionID . "'";
				mysql_query ($strUpdateStockQuery) or die ("Update Query Failed: " . mysql_error());

			}
			
			*/
			
			$strLockQuery = "UPDATE tblItem SET ColumnLock = '' where stockID = '" . $itemcode ."'";
			mysql_query ($strLockQuery) or die ("ColumnLock to blank Query Failed: " . mysql_error());

		}
		//else
		//{
			//oh dear, no stock left
		//	echo "Not enough of that item in your basket";

			//$strLockQuery = "UPDATE tblItem SET ColumnLock = '' where stockID = '" . $itemcode ."'";
			//mysql_query ($strLockQuery) or die ("Query Failed: " . mysql_error());			
			
		//}
	
	//}

	//header('location: ' . $_SERVER['PHP_SELF']);
	//header('location: ' . $_POST['page']);

	echo "<meta http-equiv='refresh' content='0;url=/stock2/default.php?Action=BasketAdmin'>";

}


   // Redirects to another Page using HTTP-META Tag
   function redirect( $url, $delay = 0, $message = "" )
   {
      /* redirects to a new URL using meta tags */
      echo "<meta http-equiv='Refresh' content='".$delay."; url=".$url."'>";
      die( "<div style='font-family: Arial, Sans-serif; font-size: 12pt;' align=center> ".$message." </div>" );
   }


?>




