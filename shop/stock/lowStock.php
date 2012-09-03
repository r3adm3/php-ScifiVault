<html>

<head>

<title>The Vault StoreRoom - Low Stock</title>
	<?php $gblnDebug = true; ?>
	<style type="text/css">
		@import "all.css"; /* just some basic formatting, no layout stuff */

		body {
			margin:5px 0px 0px 5px;
			}

		#topmenu {

			position: absolute;
			top:100px;
			left:1%;
			height:17px;
			width:95%;
			background:#9999CC;
			font-family:Arial;
			font-size:12px;
			color:white;

		}

		#leftcontent {
			position: absolute;
			left:1%;
			width:13%;
			top:125px;
			background:#fff;
			}

		#centerleftcontent {
			text-align: center;
			position: absolute;
			left:15%;
			width:70%;
			top:125px;
			background:#fff;
			font-size:11px;
			font-family: tahoma;

			}

		 #centerleftcontent, #leftcontent {
			border:0px solid #000;
			}

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


		#centerrightcontent p { font-size:10px}

	</style>

</head>

<body>
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
<p align="center">
  <br>
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="center"> 
      <?php
			//Write Debug information
			funcDebug ("this is a test debug");


			//connect to server
			funcDebug ("Connecting to database");

			$link = mysql_connect ("localhost", "sfvault_readStor", "fhyF=ruR^#1|WO")
					or die ("Could not connect: " . mysql_error() );

			funcDebug ("Connected to database");

			//change to correct database
			mysql_select_db ("sfvault_store") or die ("Could not select database");

			//run query to see if result is returned

			$strStockID = $_POST["stockID"];
			$strQuery = "SELECT stockID, Name, NoOfItems, RRP FROM tblItem where NoOfItems < 3 order by NoOfItems";
					funcDebug ("strQuery: " . $strQuery);
			$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());

			/*echo "<form method='POST' submit='updateItem.htm'>";*/
			echo "<center><table width='70%'>\n";
			echo "
			<tr>
				<td class='first' bgcolor='#9999CC'>&nbsp;StockID &nbsp;</td><td class='first' bgcolor='#9999CC'>&nbsp; Name &nbsp;</td><td class='first' bgcolor='#9999CC'>&nbsp; Stock Count &nbsp;</td><td class='first' bgcolor='#9999CC'> &nbsp;RRP&nbsp; </td>

			</tr>
			";

			$i = 1;

			while ($line = mysql_fetch_array($strResult, MYSQL_ASSOC))
			{

				funcDebug ( "stockID: " . $line["stockID"] ) ;

				echo "\t<tr>\n";
				$j = 1;
				foreach ($line as $col_value)
				{

					if ($i % 2 == 0)
					{
						//even number
						if ($j == 1)
							echo "\t\t<td class='seconda'><a href='displayItem.php?stockID=" . $line["stockID"] . "'>$col_value</a></td>\n";
						else
						{
							echo "\t\t<td class='seconda'>&nbsp;$col_value</td>\n";
						}

					}
					else
					{
						//odd number
						if ($j == 1)
							echo "\t\t<td class='secondb'><a href='displayItem.php?stockID=" . $line["stockID"] . "'>$col_value</a></td>\n";
						else
						{
							echo "\t\t<td class='secondb'>&nbsp;$col_value</td>\n";
						}
					}
					$j = $j + 1;

				}

				/*if ($i % 2 == 0)
				{
					//even number
					echo "\t<td class='seconda'><center><input type='radio' name='itemtoedit' value='" . $strStockID . "'></center></td></tr>\n";
				}
				else
				{
					//odd number
					echo "\t<td class='secondb'><center><input type='radio' name='itemtoedit' value='" . $strStockID . "'></center></td></tr>\n";
				}
				*/
				$i = $i + 1;

			}

			echo "<table></center></form>\n";

			//close connection to database
			funcDebug ("Closing link to db");
			mysql_close ($link);
		?>
    </td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>

</body>

<?php
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

</html>


