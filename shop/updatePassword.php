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
	echo "denied. you're being redirected";
	echo "<meta http-equiv='refresh' content='0;url=/UserLogon.php'>";
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

	//connect to server
	$link = mysql_connect ("localhost", "sfvault_writeSto", "Ti*ESUf3*_b?Km")
			or die ("Could not connect: " . mysql_error() );

	//change to correct database
	mysql_select_db ("sfvault_store") or die ("Could not select database");

	//Get data from adduser.htm
	$strPassword1 = funcSanitize($_POST['Password']);
	$strPassword2 = funcSanitize($_POST['Password2']);
	$strPassword3 = funcSanitize($_POST['Password3']);


	//check old password is correct

	$strPasswordQry = "SELECT Password from tbl_UserLogin where UserID = '" . $strUserID ."'";
	$strPasswordResult = mysql_query ($strPasswordQry) or die ("Query Failed:" . mysql_error());

	$conNumberofRows = mysql_num_rows($strPasswordResult);

	if ($conNumberofRows == 1)
	{
	while ($linePassword = mysql_fetch_array($strPasswordResult, MYSQL_ASSOC))
		{

			if ($linePassword["Password"]==md5($strPassword1))
			{
				//old password correct, you may progress...
			}
			else
			{
				//old password wrong
				echo "<meta http-equiv='refresh' content='0;url=/UserPasswordChange.php?strUserID=" . $strUserID . "&PasswordError=4'>";
				echo "</HEAD></HTML>";
				funcLogToDebug ("updatePassword.php:" . $strUserID . " got password wrong");
				exit();

			}
		}
	}
	else
	{

		//more than one user in our database with the same strUserID, log it and error
		//passwords don't match. Error gracefully.
		echo "<meta http-equiv='refresh' content='0;url=/UserPasswordChange.php?strUserID=" . $strUserID . "&PasswordError=3'>";
		echo "</HEAD></HTML>";
		funcLogToDebug ("updatePassword.php failed: More than one userID in the database (". $strUserID . ")");
		exit();

	}

	//check passwords match
	if ($strPassword2 == $strPassword3)
	{
		//passwords match, lets carry on
		$strMD5 = md5 ($strPassword2);
	}
	else
	{
		//passwords don't match. Error gracefully.
		echo "<meta http-equiv='refresh' content='0;url=/UserPasswordChange.php?strUserID=" . $strUserID . "&PasswordError=1'>";

		echo "</HEAD></HTML>";
		funcLogToDebug ("updatePassword.php:" . $strUserID . " couldn't match new passwords");
		exit();
	}


	$strChPassQuery = "UPDATE tbl_UserLogin set Password = '" . $strMD5 . "' where UserID = '" . $strUserID . "'";
	$strResult = mysql_query ($strChPassQuery) or die ("Query Failed:" . mysql_error());

	funcLogToDebug ("updatePassword.php: Update " . $strUserID . " Password");

	echo "<meta http-equiv='refresh' content='0;url=/passwordupdate.php?strUserID=" . $strUserID . "'>";



?>

</HEAD>
</HTML>

<?php } ?>
