<?php
include ('includes/Link.php');

$strDD = $_GET["dd"];
$strMM = $_GET["mm"];
$strYYYY = $_GET["yyyy"];

if ($_GET["dd"] == "")
{echo "No Date";}
elseif ($_GET["mm"] == "")
{echo "No Date";}
elseif ($_GET["yyyy"] == "")
{echo "No Date";}
else
{

	$strQuery = "SELECT  * FROM tblLog where timeStamp Like '" . $strYYYY . "-" . $strMM . "-" . $strDD . "%' Order by timeStamp";

	$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());

	while ($row = mysql_fetch_array($strResult, MYSQL_ASSOC)) {

	echo "\n\r" . $row["timeStamp"] . "," . htmlentities($row["Detail"]);


	}
}		
?>		
