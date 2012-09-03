<?php

//print_r($_COOKIE);
include ('includes/SharedFunctionsStrict.php');

$strBin = hex2bin($_COOKIE["AUTH"]);
$strDecrypted = funcDecrypt ($strBin);
$strUserID = substr($strDecrypted,0,strpos($strDecrypted,"&"));
$strExpiry = time()+600;
$value= funcEncrypt ($strUserID . "&" . $strExpiry);
//$value = bin2hex($cookieData);

//echo $_GET["strUserID"] . "<BR>" . $strUserID;

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
		<TITLE>Welcome to SciFi Vault!</TITLE>

<link rel="stylesheet" href="stylesheets/mainstylesheet.css" type="text/css">

	</HEAD>

	<BODY bgcolor="#FFFFFF" text="#000000" link="#FF0000" vlink="#990000" alink="#FF0000" leftmargin="0" topmargin="0">
<table  border="0" cellspacing="0" cellpadding="5" width="100%">
  <tr>
    <td><a href="http://shop.scifivault.com/index3.php"><img src="images/scifi-small-best.jpg" width="403" height="62" border="0"></a>
    </td>
    <td>
    </td>
  </tr>
  </table>
    <p>&nbsp;</p>

<div align="center"><a href='/UserDetails.php?strUserID=<?php echo $strUserID;  ?>'>Add/Update
  User Details</a><br>
  <a href='/UserPasswordChange.php?strUserID=<?php echo $strUserID;  ?>'>Change
  Password</a><br>
  <a href='/basket.php?strUserID=<?php echo $strUserID;  ?>'>Shopping Basket</a><br>
  <a href='/UserOrderHistory.php?strUserID=<?php echo $strUserID;  ?>'>Order History</a><br>
  <a href='/UserOutstandingOrders.php?strUserID=<?php echo $strUserID;  ?>'>Outstanding
  Orders</a></div>
<P align="center"> <a href='/index3.php?strUserID=<?php echo $strUserID;  ?>'>Back
  to Shop</a> <BR>
  <?php
}




?>
