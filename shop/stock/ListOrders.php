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


//query to get all baskets
$strQuery = "SELECT * FROM tbl_Orders where status <> 'SENT'";

//execute query
$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());

?>

<HTML>

	<HEAD>
		<TITLE>Welcome to SciFi Vault!</TITLE>

	</HEAD>
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr> 
    <td> 
      <div align="center"> 
        <p><a href="index.htm"><img src="../images/scifi-small-best.jpg" width="403" height="62" border="0"></a><br>
          <font face="Verdana, Arial, Helvetica, sans-serif" size="3">T h e <b>S 
          t o c k</b> R o o m</font></p>
      </div>
    </td>
  </tr>
  <tr> 
    <td> 
      <hr>
      <p align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><a href="viewItem.htm">View</a> 
        | <a href="updateItem.htm">Update</a> | <a href="addItem.htm">Add<br>
        </a></font><font face="Verdana, Arial, Helvetica, sans-serif"><a href="DisplayBaskets.php">Display 
        Baskets</a> | <a href="ListOrders.php">Current Orders</a> | <a href="CompletedOrders.php"> 
        Completed Orders</a> | <a href="lowStock.php">Low Stock</a><br>
        <a href="bugReport.htm">Submit a Bug</a> | <a href="displayBugs.php">View 
        Open Bugs</a> | <a href="displayAllBugs.php">View All Bugs</a></font></p>
      <hr>
    </td>
  </tr>
</table>
<form action='DeleteBasket.php' method=POST>
  <div align="center">
    <table>
      <tr> 
        <td>OrderNo</td>
        <td>DateSubmitted</td>
        <td>emailaddress</td>
        <td>Name</td>
        <td>status</td>
      </tr>
      <?


//enumerate through each of the rows and display
while ($line = mysql_fetch_array($strResult, MYSQL_ASSOC))
{

	echo "\n<tr>";

	echo "\n<td><a href='OrderView.php?strOrder=" . $line["OrderNo"] . "'>" . $line["OrderNo"] . "</a></td><td>" . $line["DateTme"] . "</td><td>" . $line["emailaddress"] . "</td><td>" . $line["Name"] . "</td><td>" . $line["Status"] . "</td>";

	echo "\n</tr>";

}

?>
    </table>
    <br>
    <input type='submit' name='Update' value='Update'>
  </div>
</FORM>

