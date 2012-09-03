<?

//expires cookies after 1/2 hour
$sessionExpire = 60*30;

session_set_cookie_params($sessionExpire);

//start new session
session_start();
if (!isset($_SESSION['cart']))
  $_SESSION['cart'] = array();

include ('includes/SharedFunctions.php');

$Total = "0.00";

//connect to database
$link = mysql_connect ("localhost", "sfvault_readStor", "fhyF=ruR^#1|WO")
		or die ("Could not connect: " . mysql_error() );

//change to correct database
mysql_select_db ("sfvault_store") or die ("Could not select database");
		

//query to get all items in basket
$strQuery = "SELECT t.item, c.name, t.qty, c.RRP, c.ShortDescription, c.stockID
		FROM tblBasket t
		INNER JOIN tblItem c
		ON t.item = c.stockId 
		WHERE t.PHPSessionID = '" . session_id() . "'";

//execute query
$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());

?>

<HTML>

	<HEAD>
		<TITLE>Welcome to SciFi Vault!</TITLE>

	<style type="text/css">
	<link rel="stylesheet" type="text/css" href="includes/GeneralStyle.css" />
	</HEAD>

<br>
<br>
<br>
<br>
<br>

<center>
<table>

<tr>

	<td></td><td>Name</td><td>QuickFind</td><td>Cost/Item</td><td>Cost</td>
	
</tr>

<?


//enumerate through each of the rows and display
while ($line = mysql_fetch_array($strResult, MYSQL_ASSOC))
{

	//display row.
	echo "<tr><td><form action='removeFromBasket.php' method='post'><input type='hidden' name='removeitem' value='" . $line["stockID"] . "'><input type='submit' name='remove' value='-'></form></td><td>" . $line["name"] . " " . $line["ShortDescription"] . "</td>
	<td>" . $line["stockID"] . "</td><td>" . sprintf ("%01.2f",$line["RRP"]) ."</td><td>" . sprintf ("%01.2f",$line["RRP"] * $line["qty"]) . "</td></tr>\n";
	
	//cumulative total
	$total = $total + ($line["RRP"] * $line["qty"]);
	

}

?>
</table>
</center>
<?
echo "\n<br> Total Spent = " . $total ; 

echo "<br><br><a href='/index3.php'>Back to Shop</a> or <a href='BasketLogin.php'>Checkout</a>";
?>
