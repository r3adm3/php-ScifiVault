<?php
/************************************************************************
* connect to database
*************************************************************************/
$link = mysql_connect ("localhost", "sfvault_readStor", "fhyF=ruR^#1|WO")
		or die ("Could not connect: " . mysql_error() );


//change to correct database
mysql_select_db ("sfvault_store") or die ("Could not select database");
?>
