<?php
 
//print_r($_COOKIE);
include ('includes/SharedFunctionsStrict.php');

$strBin = hex2bin($_COOKIE["AUTH"]);
$strDecrypted = funcDecrypt ($strBin);
$strUserID = substr($strDecrypted,0,strpos($strDecrypted,"&"));
$strExpiry = time()+600;
$value = funcEncrypt ($strUserID . "&" . $strExpiry);
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

<?php
	//Get data from adduser.htm
	$strFirstName = funcSanitize ($_POST["FirstName"]);
	$strSurName  = funcSanitize ($_POST["SurName"]);
	$strAddressLine1 = funcSanitize ($_POST["AddressLine1"]);
	$strAddressLine2  = funcSanitize ($_POST["AddressLine2"]);
	$strTown = funcSanitize ($_POST["Town"]);
	$strCounty = funcSanitize ($_POST["County"]);
	$strCountry = funcSanitize ($_POST["Country"]);
	$strPostCode = funcSanitize ($_POST["PostCode"]);
	$strDayTimeNo = funcSanitize ($_POST["DayTimeNo"]);
	$strMobile = funcSanitize ($_POST["Mobile"]);
	//$strEmailAddress = funcSanitize ($_POST["EmailAddress"]);
	$strEmailAddress = funcSanitize ($strUserID);
	$strMailUser = funcSanitize($_POST["emailUser"]);
	
	if ($strMailUser == 'on')
	{
		$strMailUser = '1';
	}
	else 
	{
		$strMailUser = '0';
	}
	
	$strEncFirstName = funcEncrypt ($strFirstName);
	$strEncSurName = funcEncrypt ($strSurName);
	$strEncAddressLine1 = funcEncrypt ($strAddressLine1);
	$strEncAddressLine2 = funcEncrypt ($strAddressLine2);
	$strEncTown = funcEncrypt ($strTown);
	$strEncCounty = funcEncrypt ($strCounty);
	$strEncCountry = funcEncrypt ($strCountry);
	$strEncPostCode = funcEncrypt ($strPostCode);
	$strEncDayTimeNo = funcEncrypt ($strDayTimeNo);
	$strEncMobile = funcEncrypt ($strMobile);


	//connect to server
	$link = mysql_connect ("localhost", "sfvault_writeSto", "Ti*ESUf3*_b?Km")
			or die ("Could not connect: " . mysql_error() );

	//change to correct database
	mysql_select_db ("sfvault_store") or die ("Could not select database");

	//Does User Exist

	$strUpdateQuery = "UPDATE tbl_UserLogin SET FirstName = '" . $strEncFirstName . "', SurName = '" . $strEncSurName . "',AddressLine1 = '" . $strEncAddressLine1 .
		"',AddressLine2 = '" . $strEncAddressLine2 . "', Town = '" . $strEncTown . "', County = '" . $strEncCounty . "', Country = '" . $strEncCountry .
		"', PostCode = '" . $strEncPostCode . "', DayTimeNo = '" . $strEncDayTimeNo . "',Mobile = '" . $strEncMobile . "', EmailAddress = '" . $strEmailAddress . "', MailUser = '" . $strMailUser . "'  where UserID = '" . $strUserID . "'";
	$strResult = mysql_query ($strUpdateQuery) or die ("Query Failed:" . mysql_error());

	echo "<meta http-equiv='refresh' content='0;url=/UserDetails.php?strUserID=" . $strUserID . "'>";


	funcLogtoDebug ("addDetails.php: " . $strEmailAddress . " amended their details");

	mail($strEmailAddress, "ScifiVault.com, User Amended Details" , "\n\n This is a notification mail to make you aware that changes we're made to your account. \n\n If you didn't make these changes please get in touch with us immediately.",
			     "From: webmaster@{$_SERVER['SERVER_NAME']}\r\nBCC:webmaster@{$_SERVER['SERVER_NAME']}\r\n" .
			     "Reply-To: webmaster@{$_SERVER['SERVER_NAME']}\r\n" .
			"X-Mailer: PHP/" . phpversion());

?>

</HEAD>
</HTML>

<?php }?>
