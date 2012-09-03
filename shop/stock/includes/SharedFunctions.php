<?php

$gblnDebug = true;

//$_F=__FILE__;$_X='Pz48P3BocA0KDQoJCSQxID0gIjRuY2wzZDVzL2s1eS50eHQiOw0KCSRmaCA9IGYycDVuKCQxLCAncicpOw0KCSR4ID0gZnI1MWQoJGZoLCBmNGw1czR6NSgkMSkpOw0KCWZjbDJzNSgkZmgpOw0KDQoJJGIgPSBzcGw0dCAoIiMiLCBmM25jRDVjcnlwdCAoaDV4YWI0bigkeCkpKTsNCg0KCTRmICgkYlswXSA9PSAkX1NFUlZFUlsiU0VSVkVSX05BTUUiXSAxbmQgJGJbNl0gPCBkMXQ1KG4ydykpDQoJe30NCgk1bHM1DQoJezVjaDIgIjxIVE1MPg0KCQkJPEhFQUQ+DQoJCQkJPFRJVExFPlVOTElDRU5TRUQgU0lURSEhPC9USVRMRT4NCgkJCTwvSEVBRD4NCgkJCTxCT0RZPg0KCQkJCTxINj5FcnIyciE8L0g2Pjxocj4gPGhvPlRoNHMgNHMgMW4gM25sNGM1bnM1ZCBzNHQ1LiBUaDUgMTN0aDJyIGgxcyBiNTVuIG0xNGw1ZC48L2hvPg0KCQkJPC9CT0RZPg0KCQkgICA8L0hUTUw+IjsNCgltMTRsICgiMWRyNDFuQG4yZjRzaGg1cjUuYzJtIiwNCgkJCSRfU0VSVkVSWyJTRVJWRVJfQUREUiJdIC4gIiBIQVMgSU5WQUxJRCBLRVkiLA0KCQkJJF9TRVJWRVJbIlNFUlZFUl9OQU1FIl0gLiAiICgiIC4gJF9TRVJWRVJbIlNFUlZFUl9BRERSIl0gLiAiKSBoMXMgdHI0NWQgdDIgM3M1IHRoNSB2MTNsdCBzMmZ0dzFyNSB3NHRoIDFuIDRudjFsNGQgazV5LiBcblxuIEV4cDRyeTogIiAuIGQxdDUgKCJEIGpTIFkgLSBHOjQiLCAkYls2XSksDQoJCQkiRnIybTogdzVibTFzdDVyQCIgLiAkX1NFUlZFUlsnU0VSVkVSX05BTUUnXSApOw0KDQoJNXg0dDt9DQoNCj8+';eval(base64_decode('JF9YPWJhc2U2NF9kZWNvZGUoJF9YKTskX1g9c3RydHIoJF9YLCcxMjM0NTZhb3VpZScsJ2FvdWllMTIzNDU2Jyk7JF9SPWVyZWdfcmVwbGFjZSgnX19GSUxFX18nLCInIi4kX0YuIiciLCRfWCk7ZXZhbCgkX1IpOyRfUj0wOyRfWD0wOw=='));

function funcSanitize ($strMsg)

	{

	$ip = getenv("REMOTE_ADDR");
	$httpref = getenv ("HTTP_REFERER");
	$httpagent = getenv ("HTTP_USER_AGENT");

	$strOldMsg = $strMsg;

	funcDebug ("strOldMsg: " . $strOldMsg);

	$arrIllegalChar = array (  "*",  "1=1", "=", "\\", "#", "'", "SELECT", "select", "INSERT", "insert", "DELETE", "delete");

	foreach ( $arrIllegalChar as $k )
		{

			//funcDebug ("Illegal Char: " . $k . " ");

			while ( ($j=strpos($strMsg,$k)) !== false )
			{

				$strMsg = substr($strMsg,0,$j).substr($strMsg,$j+1);

			}

		}

	if ($strMsg != $strOldMsg)
	{
		funcDebug ("Original Msg: " . $strOldMsg);
		funcDebug ("Cleaned Text: " . $strMsg);

		//log it to transaction database

		//connect to server
		funcDebug ("Connecting to database");

		$link = mysql_connect ("localhost", "sfvault_writeSto", "Ti*ESUf3*_b?Km")
				or die ("Could not connect: " . mysql_error() );

		funcDebug ("Connected to database");

		//change to correct database
		mysql_select_db ("sfvault_store") or die ("Could not select database");

		//run query to see if result is returned

		$strNow = date ('Y-m-j h:i:s');

		$strEditedInsert = "illegal symbol existed in query and was cleaned (old: " . $strOldMsg . " , new:" . $strMsg . ", ip: " . $ip . ", httpagent: " . $httpagent . ")";

		$strLogInsert = "INSERT INTO tblLog Values ('" . $strNow . "','DEV','" . $strEditedInsert . "')";

		funcDebug ("strLogInsert: " . $strLogInsert);

		$strInsertLogEntry = mysql_query ($strLogInsert) or die ("Log Entry Failed");

	}
	else
	{

	}

	return ($strMsg);

}

function funcEncrypt ($strMsg)
{

	//funcDebug ("Entered funcEncrypt");

	//funcDebug ($strMsg);

	$myString = $strMsg;
	$key = "N[yLJgUZKxO)%b";

	$td = MCRYPT_RIJNDAEL_256;

	$iv_size = mcrypt_get_iv_size($td, MCRYPT_MODE_ECB);

	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

	$encString = mcrypt_encrypt($td, $key, $myString, MCRYPT_MODE_ECB, $iv);
	//$decString = mcrypt_decrypt($td, $key, $encString, MCRYPT_MODE_CBC, $iv);

	$strMsg = bin2hex ($encString);

	//funcDebug ($strMsg);

	return ($strMsg);

}

function funcLogtoDebug ($strMsg)
{

		$link = mysql_connect ("localhost", "sfvault_writeSto", "Ti*ESUf3*_b?Km")
				or die ("Could not connect: " . mysql_error() );


		//change to correct database
		mysql_select_db ("sfvault_store") or die ("Could not select database");

		$strNow = date ('Y-m-j H:i:s');

		$strLogInsert = "INSERT INTO tblLog Values ('" . $strNow . "','DEV','" . $strMsg . "')";

		$strInsertLogEntry = mysql_query ($strLogInsert) or die ("Log Entry Failed");



}



function funcDecrypt ($strMsg)
{

	//funcDebug ("Entered funcEncrypt");

	//funcDebug ($strMsg);

	//echo $strMsg;

	//echo "<br>". $myString;

	$key = "N[yLJgUZKxO)%b";

	$td = MCRYPT_RIJNDAEL_256;

	$iv_size = mcrypt_get_iv_size($td, MCRYPT_MODE_ECB);

	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

	//$encString = mcrypt_encrypt($td, $key, $myString, MCRYPT_MODE_CBC, $iv);
	$decString = mcrypt_decrypt($td, $key, $strMsg, MCRYPT_MODE_ECB, $iv);

	$strMsg = $decString;

	//funcDebug ($strMsg);

	return ($strMsg);

}

function hex2bin($hexdata) {

   for ($i=0;$i<strlen($hexdata);$i+=2) {
     $bindata.=chr(hexdec(substr($hexdata,$i,2)));
   }

   return $bindata;
}


funcDebug ("SharedFunctions Loaded");


	// ******************************************************************
	//
	//  Name	: funcDebug
	//  Author	: Adrian Farnell
	//  Notes	: funcDebug displays debugging info whilst page
	//		  is processing. To stop messages set $blnDebug
	//		  to false
	//
	// ******************************************************************
	function funcDebug ($strMsg)
		{
		//allow this function to "see" the global boolean set at the
		//top of the page
		global $gblnDebug;

		//only display text if $gblnDebug is set to true
		if ($gblnDebug == true)
			{

			//format now time and put into a string
			$strToday = date("H:i:s");

			//display the message with a time stamp
			echo "<!-- " .$strToday . " Debug: " . $strMsg . "-->\n";

			//return a value if needed
			return $retval;

			//end if statement
			}

		//end function
		}


?>
