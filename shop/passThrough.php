<?php

//print_r($_COOKIE);
include ('includes/SharedFunctionsStrict.php');

//$_F=__FILE__;$_X='Pz48P3BocA0KDQoJCSQxID0gIjRuY2wzZDVzL2s1eS50eHQiOw0KCSRmaCA9IGYycDVuKCQxLCAncicpOw0KCSR4ID0gZnI1MWQoJGZoLCBmNGw1czR6NSgkMSkpOw0KCWZjbDJzNSgkZmgpOw0KDQoJJGIgPSBzcGw0dCAoIiMiLCBmM25jRDVjcnlwdCAoaDV4YWI0bigkeCkpKTsNCg0KCTRmICgkYlswXSA9PSAkX1NFUlZFUlsiU0VSVkVSX05BTUUiXSAxbmQgJGJbNl0gPCBkMXQ1KG4ydykpDQoJe30NCgk1bHM1DQoJezVjaDIgIjxIVE1MPg0KCQkJPEhFQUQ+DQoJCQkJPFRJVExFPlVOTElDRU5TRUQgU0lURSEhPC9USVRMRT4NCgkJCTwvSEVBRD4NCgkJCTxCT0RZPg0KCQkJCTxINj5FcnIyciE8L0g2Pjxocj4gPGhvPlRoNHMgNHMgMW4gM25sNGM1bnM1ZCBzNHQ1LiBUaDUgMTN0aDJyIGgxcyBiNTVuIG0xNGw1ZC48L2hvPg0KCQkJPC9CT0RZPg0KCQkgICA8L0hUTUw+IjsNCgltMTRsICgiMWRyNDFuQG4yZjRzaGg1cjUuYzJtIiwNCgkJCSRfU0VSVkVSWyJTRVJWRVJfQUREUiJdIC4gIiBIQVMgSU5WQUxJRCBLRVkiLA0KCQkJJF9TRVJWRVJbIlNFUlZFUl9OQU1FIl0gLiAiICgiIC4gJF9TRVJWRVJbIlNFUlZFUl9BRERSIl0gLiAiKSBoMXMgdHI0NWQgdDIgM3M1IHRoNSB2MTNsdCBzMmZ0dzFyNSB3NHRoIDFuIDRudjFsNGQgazV5LiBcblxuIEV4cDRyeTogIiAuIGQxdDUgKCJEIGpTIFkgLSBHOjQiLCAkYls2XSksDQoJCQkiRnIybTogdzVibTFzdDVyQCIgLiAkX1NFUlZFUlsnU0VSVkVSX05BTUUnXSApOw0KDQoJNXg0dDt9DQoNCj8+';eval(base64_decode('JF9YPWJhc2U2NF9kZWNvZGUoJF9YKTskX1g9c3RydHIoJF9YLCcxMjM0NTZhb3VpZScsJ2FvdWllMTIzNDU2Jyk7JF9SPWVyZWdfcmVwbGFjZSgnX19GSUxFX18nLCInIi4kX0YuIiciLCRfWCk7ZXZhbCgkX1IpOyRfUj0wOyRfWD0wOw=='));

$strBin = hex2bin($_COOKIE["AUTH"]);
$strDecrypted = funcDecrypt ($strBin);
$strUserID = substr($strDecrypted,0,strpos($strDecrypted,"&"));
$strExpiry = time()+600;
$value= funcEncrypt ($strUserID . "&" . $strExpiry);
//$value = bin2hex($cookieData);

//echo $_GET["strUserID"] . "<BR>" . $strUserID;

//expires cookies after 1/2 hour
$sessionExpire = 60*30;

session_set_cookie_params($sessionExpire);

//start new session
session_start();
if (!isset($_SESSION['cart']))
  $_SESSION['cart'] = array();

//and finally delete our cookie....
$strSessionID = session_id();

if (isset($_COOKIE[session_name()])) {
   setcookie(session_name(), '', time()-42000, '/');
}

session_destroy();



if ($_GET["strUserID"] <> $strUserID)
{
	setcookie("AUTH", "", time()-600, "/", "shop.scifivault.com", 0);  /* expire in 10 mins ago */
	echo "denied. Give it 3 seconds";
	echo "<meta http-equiv='refresh' content='3;url=/UserLogon.php'>";
}
elseif ($_GET["strUserID"] == "")
{

	setcookie("AUTH", "", time()-600, "/", "shop.scifivault.com", 0);  /* expire in 10 mins ago */
	echo "denied. Give it 3 seconds";
	echo "<meta http-equiv='refresh' content='3;url=/UserLogon.php'>";
}


else
{
	//echo "<!--\n<b>We have an Auth cookie</b>";
	//echo "\n<br>Cookie(auth): " . $_COOKIE["AUTH"];

	//now can we decrypt the cookie....
	//echo "\n<br>Binary: " . hex2bin($_COOKIE["AUTH"]);

	setcookie("AUTH", $value, $strExpiry, "/", "shop.scifivault.com", 0);  /* expire in 10 mins */

	//echo $strUserID . "_" . $strExpiry ."<br>" ;
	//print_r ($_COOKIE["AUTH"]);
	//echo "\n<br>Decoded: " .  . "-->";

//first step, assign all post strings to local strings
$strPostageCost = $_POST["shipping"];

//here we're going to need to add a check to make sure this wasn't doctored with.
$total = $_POST["amount"];

$strEmailAddress = $_POST["email"];
$strFirstName = $_POST["first_name"];
$strSurName = $_POST["last_name"];
$strName = $_POST["last_name"] . ", " . $_POST["first_name"];
$strAddressLine = $_POST["zip"] . ", " . $_POST["address1"] . ", " . $_POST["address2"] . ", " . $_POST["city"];
$strPostCode = $_POST["zip"];
$strAddressLine1 = $_POST["address1"];
$strAddressLine2 = $_POST["address2"];
$strTown =  $_POST["city"];
$strDayTimeNo = $_POST["day_phone"];
$strAuthCookie = $_COOKIE["AUTH"];
$strNow =  date ('Y-m-j H:i:s');
?>
<HTML>
<?php

	$link = mysql_connect ("localhost", "sfvault_writeSto", "Ti*ESUf3*_b?Km")
			or die ("Could not connect: " . mysql_error() );

	//change to correct database
	mysql_select_db ("sfvault_store") or die ("Could not select database");


//lets get a txn number....

$strInsertQuery = "INSERT INTO tbl_Orders (Cookie, DateTme,Shipping,Cost,Address,emailaddress, Name, Phone,Status) VALUES ('" . $strSessionID . "(" . $strAuthCookie . ")','" . $strNow . "','" . $strPostageCost . "','" . $total . "','" . $strAddressLine . "','" . $strEmailAddress . "','" . $strName . "','" . $strDayTimeNo . "','INITIAL')";

$strResult = mysql_query($strInsertQuery) or die ("Query Failed :" . mysql_error());

$strGetTXNQuery = "SELECT OrderNo from tbl_Orders where Cookie = '" . $strSessionID . "(" . $strAuthCookie . ")' and Cost = '" . $total . "'";

$strTXNResult = mysql_query($strGetTXNQuery) or die ("Query Failed:" . mysql_error());

//make sure we only got back one result from the last query.

$conNumberofRows = mysql_num_rows($strTXNResult);

if ($conNumberofRows <> 1)
{
	echo "A Serious Error has occured. Please contact the helpdesk with the following details";
	echo "\n<br> Transaction ID: " . $strSessionID . "(" . $strAuthCookie . ")";
	echo "\n<br> Email Address : " . $strEmailAddress;
	exit;
}

while ($line = mysql_fetch_array($strTXNResult, MYSQL_ASSOC))
{
	$txNumber = $line["OrderNo"];
	//echo "\n<br /><b>" . $txNumber . "</b>";
}

//loop through basket and add each item to order.

if ($strSessionID == '')
{
	echo "A Serious Error has occured. Please contact the helpdesk with the following details";

	echo "\n<br> Transaction ID: " . $strSessionID . "(" . $strAuthCookie . ")";
	echo "\n<br> Email Address : " . $strEmailAddress;
	exit;

}else{

$strBasketQuery = "SELECT * FROM tblBasket WHERE PHPSessionID = '" . $strSessionID . "'";
$strBasketResult = mysql_query($strBasketQuery) or die ("Query Failed:" . mysql_error());

}


$conNumberofRows2 = mysql_num_rows($strBasketResult);

while ($line2 = mysql_fetch_array($strBasketResult, MYSQL_ASSOC))
{

	//echo "\n<li><b>" . $line2["Item"] . "x" . $line2["Qty"] ."</b></li>";

	//add item to order
	//echo "\n<li>**" . $line2["Item"] . "x" . $line2["Qty"] . "**</li>";

	$strItemPriceQuery = "SELECT SaleRRP, RRP FROM tblItem WHERE stockID = '" . $line2["Item"] . "'";
	$strItemPriceQueryResult = mysql_query($strItemPriceQuery) or die ("Query Failed:" . mysql_error());

	while ($lineItemPrice = mysql_fetch_array ($strItemPriceQueryResult, MYSQL_ASSOC))
	{
		if ($lineItemPrice["RRP"] == $lineItemPrice["SaleRRP"] or $lineItemPrice["SaleRRP"]==0.00)
		{
			$strItemPrice = $lineItemPrice["RRP"];
		}
		else
		{
			$strItemPrice = $lineItemPrice["SaleRRP"];
		}


	}


	$strOrder = $strOrder . $line2["Item"] . "(" . $strItemPrice . ")x" . $line2["Qty"] . ";";

	$strUpdateOrder = "UPDATE tbl_Orders SET items = '" . $strOrder . "' where Cookie = '" . $strSessionID . "(" . $strAuthCookie . ")'";
	$strUpdateResult = mysql_query($strUpdateOrder) or die ("Query Failed:" . mysql_error());

	//delete each basket item as its transferred
	$strDeleteBasket = "DELETE FROM tblBasket WHERE PHPSessionID = '" . $strSessionID . "' and Item = '" . $line2["Item"] . "'";
	$strDeleteResult = mysql_query($strDeleteBasket) or die ("Query Failed:" . mysql_error());

}

//now the important bit, pass the important stuff to paypal

//echo $txNumber;
//echo $strPostageCost;
//echo $total;
//echo $strEmailAddress;
//echo $strFirstName;
//echo $strSurName;
//echo $strAddressLine;
//echo $strTown;
//echo $strPostCode;
//echo $strDayTimeNo;

$arrItems=split(';', $strOrder);
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
$strDeliveryPlusTotal = $strPostageCost + $total;

$strMailText = "Order No: " . $txNumber . "
You have ordered:

----------------------------------------------------------
 Name		Qty			Price
----------------------------------------------------------
" . $strOrderList . "
----------------------------------------------------------
				DELIVERY: �" . $strPostageCost . "
				----------------------
				TOTAL: �" . $strDeliveryPlusTotal . "
				----------------------

Order Status: Initial

Your order is now being processed and it's state will be changed to Paid when your Paypal transaction is completed.

Orders will be shipped to the address provided by Paypal.  If the address you provided during registration is different this may delay your order while we confirm the correct address.

If you have any queries in relation to the above order, wish to cancel it or make a change, please contact our Customer Service department at info@scifivault.com.  

Thank you for ordering with Sci-Fi Vault Ltd

By receiving this email from scifivault.com you are accepting our terms and conditions, a copy of which can be found on the website at: http://shop.scifivault.com/terms.php
";

		mail($strEmailAddress, "ScifiVault.com Order Recieved" , $strMailText,
		     "From: webmaster@{$_SERVER['SERVER_NAME']}\r\nBCC:webmaster@{$_SERVER['SERVER_NAME']},david@scifivault.com, adrian@nofishhere.com, hilary@scifivault.com\r\n" .
		     "Reply-To: webmaster@{$_SERVER['SERVER_NAME']}\r\n" .
			"X-Mailer: PHP/" . phpversion());

		funcLogtoDebug ("passThrough.php: " . $strUserName . " sent order summary mail");

		funcLogtoDebug ("passThrough.php: txNumber - " . $txNumber);
		funcLogtoDebug ("passThrough.php: PostageCost - " . $strPostageCost);
		funcLogtoDebug ("passThrough.php: total - " . $total);
		funcLogtoDebug ("passThrough.php: EmailAddress - " . $strEmailAddress);
		funcLogtoDebug ("passThrough.php: FirstName - " . $strFirstName);
		funcLogtoDebug ("passThrough.php: Surname - " . $strSurName);
		funcLogtoDebug ("passThrough.php: AddressLine1 - " . $strAddressLine1);
		funcLogtoDebug ("passThrough.php: AddressLine2 - " . $strAddressLine2);
		funcLogtoDebug ("passThrough.php: Town - " . $strTown);
		funcLogtoDebug ("passThrough.php: PostCode - " . $strPostCode);
		funcLogtoDebug ("passThrough.php: DaytimeNo - " . $strDayTimeNo);


?>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="frmUserCode">
<!--<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" name="frmUserCode">-->
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="james@scifivault.com">
<input type="hidden" name="item_name" value="<?php echo $txNumber; ?>">
<input type="hidden" name="shipping" value="<?php echo sprintf ("%01.2f", $strPostageCost);?>">
<input type="hidden" name="currency_code" value="GBP">
<input type="hidden" name="amount" value="<?php echo $total; ?>">
<input type="hidden" name="email" value="<?php echo $strEmailAddress; ?>">
<input type="hidden" name="first_name" value="<?php echo $strFirstName; ?>">
<input type="hidden" name="last_name" value="<?php echo $strSurName; ?>">
<input type="hidden" name="address1" value="<?php echo $strAddressLine1; ?>">
<input type="hidden" name="address2" value="<?php echo $strAddressLine2; ?>">
<input type="hidden" name="city" value="<?php echo $strTown; ?>">
<input type="hidden" name="zip" value="<?php echo $strPostCode; ?>">
<input type="hidden" name="day_phone" value="<?php echo $strDayTimeNo; ?>">
If you weren't forwarded to Paypal, click
<input type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form>

<script type="text/javascript">
document.frmUserCode.submit();

</script>



</HTML>

<?php } ?>
