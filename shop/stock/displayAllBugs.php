<HTML>

<HEAD>
	<TITLE>Display Open Bugs.........</Title>
</HEAD>

	<style type="text/css">
		@import "all.css"; /* just some basic formatting, no layout stuff */

		p,h1,pre {
			margin:px 10px 10px 10px;
			}
		td.first {
			font-weight: 900;
			font-family:tahoma;
			font-size:11px;
			color: white;
		}
		td.seconda {
			font-family:tahoma;
			font-size:11px;
			color: black;
		}

		td.secondb {
			font-family:tahoma;
			font-size:11px;
			color: black;
			background-color: #FFFFCC;
		}
</style>

<BODY>

		<CENTER>
  <table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr> 
      <td> 
        <div align="center"> 
          <p><a href="index.htm"><img src="../images/scifi-small-best.jpg" width="403" height="62" border="0"></a></p>
          <center>
            <font size="3" face="Verdana, Arial, Helvetica, sans-serif"><b>S u 
            b m i t </b>B u g . . . . .</font><font size="3"></font> 
          </center>
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
  <br>
  <?php



			//Write Debug information
			funcDebug ("this is a test debug");


			//connect to server
			funcDebug ("Connecting to database");

			$link = mysql_connect ("localhost", "sfvault_readStor", "fhyF=ruR^#1|WO") or die ("Could not connect: " . mysql_error() );

			funcDebug ("Connected to database");

			//change to correct database
			mysql_select_db ("sfvault_store") or die ("Could not select database");


			$strQuery = "SELECT IssueNo,DateStamp,Issue,Fixed FROM tblBugs" ;
			funcDebug ("strQuery: " . $strQuery);
			$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());


			echo "<center><form method='POST' action='updateBug.php'><table width='70%'>\n";

echo "<tr> <td class='first' bgcolor='#9999CC'>Issue No</td> <td class='first' bgcolor='#9999CC'>Date Submitted</td> <td class='first' bgcolor='#9999CC'>Issue</td> <td class='first' bgcolor='#9999CC'>Fixed</td> </tr>\n";

$i=1;

while ($line = mysql_fetch_array($strResult, MYSQL_ASSOC) )
{

	echo "\t<tr>\n";
	$j=1;

	foreach ($line as $col_value)
	{

		if ($i %2 == 0)

		//even number
		{

			if ($j==3)
			{
			echo "\t\t<td class='seconda'>" . $col_value . "</td>\n\t\t";
			}
			else
			{
			echo "\t\t<td class='seconda'>" . $col_value . "</td>\n";
			}

		}
		else
		{

			if ($j==3)
			{
			echo "\t\t<td class='secondb'>" . $col_value . "</td>\n\t\t";
			}
			else
			{
			echo "\t\t<td class='secondb'>" . $col_value . "</td>\n";
			}


		}




		$j=$j+1;
	}

	$i=$i+1;
}

echo "</table><br><input type='submit' value='Update Bug DB' name='B1'></form></center>";

			//close connection to database
			funcDebug ("Closing link to db");
			mysql_close ($link);







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
</CENTER>

</BODY>

</HTML>













































