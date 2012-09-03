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

	echo "<tr><td>Order No:</td><td>" . $strOrderNo . "</td></tr>";
	echo "<tr><td>Date Submitted:</td><td>" . $strOrderSubmitted . "</td></tr>";
	echo "<tr><td>Cookie:</td><td>" . $strCookie . "</td></tr>";
	echo "<tr><td>Items:</td><td>" . $strItems . "</td></tr>";
	echo "<tr><td>Cost:</td><td>" . $strCost . "</td></tr>";
	echo "<tr><td>Address:</td><td>" . $strAddress . "</td></tr>";
	echo "<tr><td>Name:</td><td>" . $strName . "</td></tr>";
	echo "<tr><td>Phone:</td><td>" . $strPhone . "</td></tr>";
	echo "<tr><td>IPN Recieved:</td><td>" . $strIPNSubmitted . "</td></tr>";
	echo "<tr><td>PayPal Txn No:</td><td>" . $strPaypalTXN . "</td></tr>";
}


//mail webmasters

$ip = getenv("REMOTE_ADDR");
$httpref = getenv ("HTTP_REFERER");
$httpagent = getenv ("HTTP_USER_AGENT");

switch ($strStatus)
{

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
		     "From: webmaster@{$_SERVER['SERVER_NAME']}\r\nBCC:webmaster@{$_SERVER['SERVER_NAME']}\r\n" .
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
		     "From: webmaster@{$_SERVER['SERVER_NAME']}\r\nBCC:webmaster@{$_SERVER['SERVER_NAME']}\r\n" .
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


			redirect( "ListOrders.php" , 1, "<B>Redirecting...</B><br> <a href='displayBugs.php'>Click here if redirect fails</a>" );


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


?>




