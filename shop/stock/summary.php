<?php
	
	include ('includes/DataBaseConnection.php');

?>
<HTML>

	<HEAD><TITLE>Summary Page</TITLE></HEAD>

	<BODY>
	
	<p>
		<H1>Users</H1>
		Total Number of Users: 
		<?php
		
		$strQuery = "SELECT count(*) as Count from tbl_UserLogin";

		$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());
		
		while ($row = mysql_fetch_array($strResult, MYSQL_ASSOC)) {
		
			echo $row['Count'];
			
			}
		
		?>
		<br />Unverified Users:
		<?php
		
		$strQuery = "SELECT count(*) as Count from tbl_UserLogin where UserVerified<>'1'";

		$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());
		
		while ($row = mysql_fetch_array($strResult, MYSQL_ASSOC)) {
		
			echo $row['Count'];
			
			}
		
		?>
		<br />Number Logged in, Last 7 days:
		<?php
		
		$strQuery = "SELECT Count(*) as Count FROM tbl_UserLogin t where DATE_SUB(CURDATE(),INTERVAL 7 DAY) <= LastLoginTime";

		$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());
		
		while ($row = mysql_fetch_array($strResult, MYSQL_ASSOC)) {
		
			echo $row['Count'];
			
			}
		
		?>

		<br />Registered in Last 7 days:
				<?php
		
		$strQuery = "SELECT Count(*) as Count FROM tbl_UserLogin t where DATE_SUB(CURDATE(),INTERVAL 7 DAY) <= CreateDate";

		$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());
		
		while ($row = mysql_fetch_array($strResult, MYSQL_ASSOC)) {
		
			echo $row['Count'];
			
			}
		
		?>

	</p>
	
	<p>
		<H1>Active Sessions</H1>
		Sessions in the last 30 minutes:
				<?php
		
		/*$strQuery = "SELECT Count(*) as Count FROM tbl_UserLogin t where DATE_SUB(CURDATE(),INTERVAL 7 DAY) <= CreateDate";

		$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());
		
		while ($row = mysql_fetch_array($strResult, MYSQL_ASSOC)) {
		
			echo $row['Count'];
			
			}
		*/
		?>		
		<br />Active Baskets:`	
	</p>
	
	<p>
		<H1>Orders</H1>
		Total Orders:
		<br />Total Takings:
		<br />Number of Orders this Year:
		<br />Takings this year:
	</p>
	
	<p>
		<H1>Log Entries</H1>
		
		<table width='70%'><tr><td>Time</td><td>Message</td></tr>
				<?php
		
		$strQuery = "SELECT  * FROM tblLog Order by timeStamp DESC LIMIT 25";

		$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());
		
		while ($row = mysql_fetch_array($strResult, MYSQL_ASSOC)) {
		
			echo "<tr><td>" . $row['timeStamp'] . "</td><td>" . $row['Detail'] . "</td></tr>";
			
			}
		
		?>			
		</table>
	</p>
	
	<p>
		<H1>Stock Items</H1>
		Total No of Items in DB:
		<br />
	</p>
	
	
</BODY>

</HTML>
