<HTML>

<HEAD><link rel="stylesheet" href="stylesheets/mainstylesheet.css" type="text/css"></HEAD>

<BODY>
<?php

//standard functions
include ('includes/SharedFunctionsStrict.php');

//Connect to database
		$link = mysql_connect ("localhost", "sfvault_writeSto", "Ti*ESUf3*_b?Km")
				or die ("Could not connect: " . mysql_error() );

		mysql_select_db ("sfvault_store") or die ("Could not select database");


//Place posted email address in to a string
$strEmailAddress = funcSanitize($_POST["email"]);

//check user is in our database
	//Does User Exist

	$strUserQuery = "SELECT UserID,emailAddress,password FROM tbl_UserLogin where emailAddress = '" . $strEmailAddress . "'";
	$strUserResult = mysql_query ($strUserQuery) or die ("Query Failed:" . mysql_error());

	//User Exists, so Error gracefully, then forward the user on
	$conNumberofRows = mysql_num_rows($strUserResult);
	if ($conNumberofRows == 0)
	{
		//if not, log to event log and forward to front page.

		funcLogToDebug ("passwordRetrieval.php: No user in DB for " . $strEmailAddress);

		echo "<meta http-equiv='refresh' content='0;url=/index3.php'>";
	}
	else
	{
	//User Does exist so end

		//Generate 8 digit random password

		$length    = 8;
		$key_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$rand_max  = strlen($key_chars) - 1;

		for ($i = 0; $i < $length; $i++)
		{
		   $rand_pos  = rand(0, $rand_max);
		   $rand_key[] = $key_chars{$rand_pos};
		}

		$rand_pass = implode('', $rand_key);

		//set in database
		//change to correct database
		mysql_select_db ("sfvault_store") or die ("Could not select database");


		$strChPassQuery = "UPDATE tbl_UserLogin set Password = '" . md5($rand_pass) . "' where UserID = '" . $strEmailAddress . "'";
		$strResult = mysql_query ($strChPassQuery) or die ("Query Failed:" . mysql_error());



		//display msg
		//echo "Password has been sent to your account";

		//and send....
		mail($strEmailAddress, "ScifiVault.com Password Retrieval" , "\n\n Your Password is  " . $rand_pass .", Once logged in successfully, please change it as a security measure",
		     "From: webmaster@{$_SERVER['SERVER_NAME']}\r\n" .
		     "Reply-To: webmaster@{$_SERVER['SERVER_NAME']}\r\n" .
			"X-Mailer: PHP/" . phpversion());


		funcLogToDebug ("passwordRetrieval.php: Password sent to " . $strEmailAddress);

		funcLogToDebug ("passwordRetrieval.php: " . $rand_pass );



	}
?>

<table  border="0" cellspacing="0" cellpadding="5" width="900" align="center">
  <tr>
    <td width="500"><a href="http://shop.scifivault.com/index3.php"><img src="images/scifi-small-best.jpg" width="403" height="62" border="0"></a>

    </td>
    <td align="right" valign="top" width="300">
      <div align="right">
        <script language=JavaScript>

    </td></tr>

<tr><td>
<br>Password has been sent to your email address.

<br>
<br><br><a href='index3.php'>Back to Shop</a></td><td></td></tr>


</BODY>

</HTML>
