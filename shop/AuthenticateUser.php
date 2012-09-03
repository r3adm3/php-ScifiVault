<?php

include ('includes/SharedFunctionsStrict.php');

$strNow = date ('Y-m-j H:i:s');

$strUserID = funcSanitize($_POST["EmailAddress"]);
$strPassword = $_POST["Password"];
$strEmailAddress = funcSanitize($_POST["EmailAddress"]);




/************************************************************************
* connect to database
*************************************************************************/
$link = mysql_connect ("localhost", "sfvault_readStor", "fhyF=ruR^#1|WO")
		or die ("Could not connect: " . mysql_error() );


//change to correct database
mysql_select_db ("sfvault_store") or die ("Could not select database");


$strQuery = "SELECT UserID, UserVerified, UserStatus, Password from tbl_UserLogin where UserID = '" . $strUserID . "' and emailAddress = '" . $strEmailAddress . "'";

$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());

$conNumberofRows = mysql_num_rows($strResult);

if ($conNumberofRows == 1)
{

	while ($line = mysql_fetch_array($strResult, MYSQL_ASSOC))
	{
		$strVerified = $line["UserVerified"];
		$strUserState = $line["UserStatus"];

		if ($strVerified <> "1")
		{

			funcLogtoDebug ("AuthenticateUser.php: " . $strUserID . " log on attempted, not verified" );
			echo "Your User isn't verified, please verify before continuing on...";
			echo "<meta http-equiv='refresh' content='5;url=/index3.php'>";
			exit;
		}

		if ($line["UserStatus"] > "2")
		{
			funcLogtoDebug ("AuthenticateUser.php: " . $strUserID . " account locked" );
			echo "Your User account has had 3 failed logon attempts. Please contact SciFiVault.com to get it unlocked.";
			echo "<meta http-equiv='refresh' content='5;url=/UserLogon.php?UserPassError=2'>";
			exit;

		}

		if ($line["Password"] <> md5($strPassword))
		{

			funcLogtoDebug ("AuthenticateUser.php: " . $strUserID . " incorrect password (" . $line["Password"] . "," . $strPassword . ")" );
			//echo "Incorrect User or Bad Password";
			echo "<meta http-equiv='refresh' content='0;url=/UserLogon.php?UserPassError=1'>";
			$strUserState = $strUserState + 1;

			$strUpdateQuery = "UPDATE tbl_UserLogin SET UserStatus = '" . $strUserState . "' where UserID = '" . $strUserID . "'";
			$strUpdateResult = mysql_query ($strUpdateQuery) or die ("Query Failed:" . mysql_error());

			exit;

		}

	}

	$value = funcEncrypt ($strUserID . "&" . $strNow);

	//$value = bin2hex($cookieData);

	funcLogtoDebug ("AuthenticateUser.php: " . $strUserID . " log on successful" );

	setcookie("AUTH", $value, time()+600, "/", "shop.scifivault.com", 0);  /* expire in 10 mins */


	$strUpdateQuery = "UPDATE tbl_UserLogin SET LastLoginTime = '" . $strNow . "', UserStatus = '0' where UserID = '" . $strUserID . "'";
	$strUpdateResult = mysql_query ($strUpdateQuery) or die ("Query Failed:" . mysql_error());



	//echo $value;
	//echo "<b>" . $cookieData;
	//echo $_POST["url"];
	funcLogtoDebug ("AuthenticateUser.php: " . $strUserID . " logged in from " . funcSanitize($_SERVER["HTTP_REFERER"]));
	if ($_POST["url"]=='BasketLogin.php')
	{
	//echo $_POST["url"];
	echo "<meta http-equiv='refresh' content='0;url=/ChooseDelivery.php?strUserID=" . $strUserID ."'>";
	}
	elseif ($_POST["pagelink"]=="")
	{
		funcLogtoDebug ("AuthenticateUser.php: " . $strUserID . " forwarding to account management"); 
		echo "<meta http-equiv='refresh' content='0;url=/UserOutstandingOrders.php?strUserID=" . $strUserID ."'>";
		
	}
	else
	{
	//echo $_GET["url"];
	//echo "<meta http-equiv='refresh' content='0;url=/UserOutstandingOrders.php?strUserID=" . $strUserID ."'>";
	funcLogtoDebug ("AuthenticateUser.php: " . $strUserID . " forwarding to " . funcSanitize($_POST["pagelink"]));
	echo "<meta http-equiv='refresh' content='0;url=" . $_POST["pagelink"] . "'>";
	
	}
}
elseif ($conNumberofRows == 0)
{

	funcLogtoDebug ("AuthenticateUser.php: " . $strUserID . " doesn't appear in the database.." );
	echo "User and/or Password incorrect";
	echo "<meta http-equiv='refresh' content='0;url=/UserLogon.php?UserPassError=1'>";

	$strUpdateQuery = "UPDATE tbl_UserLogin SET UserStatus = '" . $strUserState . "' where UserID = '" . $strUserID . "'";
	$strUpdateResult = mysql_query ($strUpdateQuery) or die ("Query Failed:" . mysql_error());


	//echo "<br>" . $strUserID;
	//echo "<br>" . $strPassword ."(" . md5($strPassword) .")";
	//echo "<br>" . $strEmailAddress;


}
else
{

	funcLogtoDebug ("AuthenticateUser.php: " . $strUserID . " multiple user entries with this user/pwd/combo" );
	echo "Serious Error here! More than 1 entry in the database with this user/password/email combination.";

}




?>
