<?php

	//connect to server
	$link = mysql_connect ("localhost", "sfvault_writeSto", "Ti*ESUf3*_b?Km")
			or die ("Could not connect: " . mysql_error() );

	//change to correct database
	mysql_select_db ("sfvault_store") or die ("Could not select database");

	$strPostage = 3.89;

	for ($counter=1250; $counter <=10000; $counter+=250)
	{
		$strPostage = $strPostage + 0.85;

		$strQuery = "INSERT tbl_Postage values ('1stClassInland', " . $counter . ", $strPostage)";
		$strResult = mysql_query ($strQuery) or die ("Query Failed:" . mysql_error());

	}


?>
