<?php

	include ('includes/SharedFunctionsStrict.php');

	$strToEncode = $_SERVER["SERVER_NAME"] . "#" . strtotime ("2037-04-04 02:00:00 GMT") . "#";

	echo $strToEncode . "<br>" . date(now);

	//echo funcEncrypt ($strToEncode) . "<br>";

//encode it a ByteRun.com

	$a = "includes/key.txt";
	$fh = fopen($a, 'r');
	$x = fread($fh, filesize($a));
	fclose($fh);

	$b = split ("#", funcDecrypt (hex2bin($x)));


	if ($b[0] == $_SERVER["SERVER_NAME"] and $b[1] < date(now))
	{}
	else
	{echo "<HTML>
			<HEAD>
				<TITLE>UNLICENSED SITE!!</TITLE>
			</HEAD>
			<BODY>
				<H1>Error!</H1><hr> <h3>This is an unlicensed site. The author has been mailed.</h3>
			
</BODY>
		   </HTML>";
	/*mail ("adrian@nofishhere.com",
			$_SERVER["SERVER_ADDR"] . " HAS INVALID KEY",
			$_SERVER["SERVER_NAME"] . " (" . $_SERVER["SERVER_ADDR"] . ") has tried to use the vault software with an invalid key. \n\n Expiry: " . date ("D jS Y - G:i", $b[1]),
			"From: webmaster@" . $_SERVER['SERVER_NAME'] );
*/
	exit;}


?>
