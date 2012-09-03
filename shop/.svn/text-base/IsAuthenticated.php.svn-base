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

//expires cookies after 1/2 hour
$sessionExpire = 60*30;

session_set_cookie_params($sessionExpire);

//start new session
session_start();
if (!isset($_SESSION['cart']))
  $_SESSION['cart'] = array();

if ($strUserID == "")
{
	setcookie("AUTH", "", time()-600, "/", "shop.scifivault.com", 0);  /* expire in 10 mins ago */
	echo "Forwarding to Logon Page. Give it 3 seconds";
	echo "<meta http-equiv='refresh' content='3;url=/UserLogon.php'>";
}
else
{
	//echo "<!--\n<b>We have an Auth cookie</b>";
	//echo "\n<br>Cookie(auth): " . $_COOKIE["AUTH"];

	//now can we decrypt the cookie....
	//echo "\n<br>Binary: " . hex2bin($_COOKIE["AUTH"]);

	setcookie("AUTH", $value, $strExpiry, "/", "shop.scifivault.com", 0);  /* expire in 10 mins */

	echo "Letting it through. No need to re-logon. '" .$strUserID . "'";
	echo "\n<meta http-equiv='refresh' content='0;url=/UserMenu.php?strUserID=" . $strUserID . "'>";

	//echo $strUserID . "_" . $strExpiry ."<br>" ;
	//print_r ($_COOKIE["AUTH"]);
	//echo "\n<br>Decoded: " .  . "-->";
}
?>

