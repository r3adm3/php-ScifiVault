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

 if ($_GET["key"] <> "")
{
		$strBin = hex2bin($_GET["key"]);
		$strDecrypted = funcDecrypt ($strBin);
		$strUserID = substr($strDecrypted,0,strpos($strDecrypted,"&"));
		
		//$str = strpos(strDecrypted,"&");
		
		funcLogToDebug ("submitOrder2.php: " . $strBin );
		funcLogToDebug ("submitOrder2.php: " . $strDecrypted );
		funcLogToDebug ("submitOrder2.php: " . $strUserID );
} 
  
  
if ($_GET["strUserID"] <> $strUserID)
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

?>
<HTML>
	<HEAD>
		<TITLE>Sci-Fi Vault</TITLE>

<link rel="stylesheet" href="stylesheets/mainstylesheet.css" type="text/css">
</HEAD>


<BODY bgcolor="#FFFFFF" text="#000000" link="#000000" vlink="#000000" alink="#000000" leftmargin="0" topmargin="0">
<table  border="0" cellspacing="0" cellpadding="5" width="100%" align="center">
  <tr>
    <td><a href="http://shop.scifivault.com/index3.php"><img src="images/scifi-small-best.jpg" width="403" height="62" border="0"></a>
    </td>
  </tr>
</table>
<br>
<table  border="0" cellspacing="0" cellpadding="5" align="center" width="102%">
  <tr>
    <td width="246" align="left" valign="top"> <br>
    </td>
    <td width="735" align="center" valign="top">
      <p align="left"><b>Final order Totals:</b>
        <?php

$total = "0.00";
$totalWeight = "0";

//connect to database
$link = mysql_connect ("localhost", "sfvault_readStor", "fhyF=ruR^#1|WO")
		or die ("Could not connect: " . mysql_error() );

//change to correct database
mysql_select_db ("sfvault_store") or die ("Could not select database");


//query to get all items in basket
$strQuery = "SELECT c.Weight, t.item, c.name, t.qty, c.RRP, c.SaleRRP, c.ShortDescription, c.stockID
		FROM tblBasket t
		INNER JOIN tblItem c
		ON t.item = c.stockId
		WHERE t.PHPSessionID = '" . session_id() . "'";

//execute query
$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());

$conNumberofRows = mysql_num_rows($strResult);

if ($conNumberofRows == 0)
{
	echo "You've no items in your basket!";
	echo "<br><br> Click <a href='index3.php'>here</a> to go back to shop";
	exit;
}

?>
      </p>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>
            <p><b>To be Delivered to:</b> </p>
            <p>
              <?php
$strAddressQuery = "SELECT * from tbl_UserLogin where UserID = '" . $strUserID . "'";

$strAddressResult = mysql_query($strAddressQuery) or die ("Query Failed :" . mysql_error());

$conNumberofRows = mysql_num_rows($strAddressResult);

if ($conNumberofRows == 0)
{
	echo "You've not got a delivery address";
	echo "<br><br> Click <a href='UserDetails.php?strUserID=" . $strUserID . "'>here</a> to go back to shop";
	exit;
}

	while ($line2 = mysql_fetch_array($strAddressResult, MYSQL_ASSOC))
	{

		if ($line2["FirstName"] <> "")
		{
		$strFirstName = trim (funcDecrypt (hex2bin ( $line2["FirstName"])));
		}
		if ($line2["SurName"] <> "")
		{
		$strSurName = trim (funcDecrypt (hex2bin ( $line2["SurName"])));
		}
		if ($line2["AddressLine1"] <> "")
		{
		$strAddressLine1 = trim (funcDecrypt (hex2bin ( $line2["AddressLine1"])));
		}
		if ($line2["AddressLine2"] <> "")
		{
		$strAddressLine2 = trim (funcDecrypt (hex2bin ( $line2["AddressLine2"])));
		}
		if ($line2["Town"] <> "")
		{
		$strTown = trim (funcDecrypt (hex2bin ( $line2["Town"])));
		}
		if ($line2["County"] <> "")
		{
		$strCounty = trim (funcDecrypt (hex2bin ( $line2["County"])));
		}
		if ($line2["Country"] <> "")
		{
		$strCountry = trim (funcDecrypt (hex2bin ( $line2["Country"])));
		}
		if ($line2["PostCode"] <> "")
		{
		$strPostCode = trim (funcDecrypt (hex2bin ( $line2["PostCode"])));
		}
		if ($line2["DaytimeNo"] <> "")
		{
		$strDayTimeNo = trim (funcDecrypt (hex2bin ( $line2["DaytimeNo"])));
		}
		if ($line2["Mobile"] <> "")
		{
		$strMobile = trim (funcDecrypt (hex2bin ( $line2["Mobile"])));
		}
		$strEmailAddress = $line2["emailAddress"];
	}

	echo "\n<br>" . $strFirstName . " " . $strSurName;
	echo "\n<br>" . $strAddressLine1;
	if ($strAddressLine2 <> "")
		{
		echo "\n<br>" . $strAddressLine2;
		}
	echo "\n<br>" . $strTown;
	echo "\n<br>" . $strCounty;
	echo "\n<br>" . $strCountry;
	echo "\n<br>" . $strPostCode. "<br>";

?>
            <p>
          </td>
        </tr>
      </table>
      <br>
      <table width="100%" border="1">
        <tr>
          <td width="50">Qty</td>
          <td width="50">Item Code</td>
          <td width="100%">Description</td>
          <td width="50">Cost/Item</td>
          <td width="50">Cost</td>
        </tr>
        <?php


//enumerate through each of the rows and display
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

	//display row.
	echo "<tr>
	<td>". $line["qty"] . "</td>
	<td>" . $line["stockID"] . "</td>
	<td>" . $line["name"] . " </td>
	<td align='right'>&pound;" . sprintf ("%01.2f",$strPrice) ."</td>
	<td align='right'>&pound;" . sprintf ("%01.2f",$strPrice * $line["qty"]) . "</td>
	</tr>\n";

	//cumulative total
	$total = $total + ($strPrice * $line["qty"]);
	$totalWeight = $totalWeight + ($line["Weight"] * $line["qty"]) ;

}

	$strPostageType = substr($_POST["Postage"],0,strpos($_POST["Postage"],"-"));
	$strPostageCost = substr($_POST["Postage"],strpos($_POST["Postage"],"- ")+1);

	echo "<tr><td></td><td></td><td>&nbsp;</td><td></td><td></td></tr>";
	echo "<tr><td></td><td></td><td><b>Shipping (" . $strPostageType . ")</b></td><td></td><td align='right'>&pound;" . sprintf ("%01.2f", $strPostageCost) . "</td></tr>";
	echo "<tr><td></td><td></td><td><b>Total</b></td><td></td><td align='right'>&pound;" . (sprintf ("%01.2f", $strPostageCost+$total)) . "</td></tr>";



?>
      </table>

        <br>
        <?php

//$strPostageCost = $_POST["Postage"];

//echo $strPostageCost;
//echo "Delivery Cost is: " . sprintf ("%01.2f", $strPostageCost);
//echo " using " . $strPostageType;

//echo "<br><br><b> Total Cost of Order = " . sprintf ("%01.2f", $total + $strPostageCost);

/*we have details here of our order now. We're going to prep the database...
$strQueryChk = "SELECT * FROM tbl_CompletedOrders where cookie = '" . $_COOKIE["AUTH"] . "' and total = "' . $total . '" ";

$strChkResults = mysql_query($strQueryChk) or die ("Query Failed :" . mysql_error());

$conResultsChkRows = mysql_num_rows($strChkResults);

//is this order already in the database?

if ($conResultsChkRows == 0)
{
	//if not, insert new record, set it to PRE-PAYPAL and grab transaction id
}
else
{
	//if so, grab it and pass the transaction id to paypal below
}



*/





?>
        <br>
        <br>
	<!--<form action="https://www.paypal.com/cgi-bin/webscr" method="post">-->
      <!--<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">-->
      <form action="passThrough.php?strUserID=<?php echo $strUserID;?>" method="post">
        <input type="hidden" name="cmd" value="_xclick">
        <input type="hidden" name="business" value="james@scifivault.com">
        <input type="hidden" name="item_name" value="x123456">
        <input type="hidden" name="shipping" value="<?php echo sprintf ("%01.2f", $strPostageCost);?>">
        <input type="hidden" name="currency_code" value="GBP">
        <input type="hidden" name="amount" value="<?php echo $total; ?>">
        <input type="hidden" name="email" value="<?php echo $strEmailAddress; ?>">
        <input type="hidden" name="first_name" value="<?php echo $strFirstName; ?>">
        <input type="hidden" name="last_name" value="<?php echo $strSurName; ?>">
        <input type="hidden" name="address1" value="<?php echo $strAddressLine1; ?>">
        <input type="hidden" name="address2" value="<?php echo $strAddressLine2 ."," . $strCounty . "," . $strCountry; ?>">
        <input type="hidden" name="city" value="<?php echo $strTown; ?>">
        <input type="hidden" name="zip" value="<?php echo $strPostCode; ?>">
        <input type="hidden" name="day_phone" value="<?php echo $strDayTimeNo; ?>">
        <input type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
      </form>
      <p>&nbsp; </p>


    </td>
    <td width="266" align="center" valign="top"> <br>
      <p><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"> </font></font></p>
      <br>
    </td>
  </tr>
</table>
<br>
    <div align="center">
      <hr width="50%">
      <p><img src="images/site_footer1.gif" width="411" height="31"></p>
      <p>Sci-Fi Vault Ltd &copy; 2006<br>
        Version 0.2a<br>
        www.scifivault.com<br>
      </p>
      </div>
</HTML>
<?php } ?>
