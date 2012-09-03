
<HTML>

	<HEAD>
		<TITLE>The Vault Backend Stock System.</TITLE>
		<style type="text/css">
			body
			{
				background-image: url('images//Image1.gif');
				background-repeat: repeat-x;
				margin:0px;
				margin-top:0px;
			}
			td
			{
				font-size:small;
			}
			th
			{
				font-size:small;
				font-weight:normal;
			}

			.titleRow2
			{
				font-weight:bold;
				text-align:left;
				background-color: lightgrey;
			}
			.titleRow
			{
				font-weight:bold;
				text-align:center;
				background-color: lightgrey;
			}
			li
			{
				font-size:small
				padding-left:3px;
			}
			table.left_menus
			{
				border-width: 1px;
				border-style: solid #0000FF;
			}
			.toptitle
			{
				font-family: tahoma;
				font-weight:bold;
				font-color:white ;
				font-size:14px;
			}
			.toprighttitle
			{
				
				position:absolute;
				top:14px;
				left:700px;
				}
			img.toptitle
			{
				position:absolute;
				left:0px;
				top:0px;
			}
			body
			{
				font-family: tahoma;
				
			}
			
			.menu_underneath_title
			{
				position:absolute;
				left:15px;
				top:75px;
				font-family: tahoma;
				font-weight: bold;
				font-size: small;
				color:white;
			}
			.left_menus
			{
				position: absolute;
				left: 15px;
				top: 115px;
				font-size: small;
				
			}
			.left_menus
			{
				font-size:small;
				
			}
			.main_content
			{
				position: absolute;
				font-size:small;
				left: 250px;
				top: 125px;
			
			}
			.orders
			{
			
				position: absolute;
				font-size:small;
				left: 570px;
				top: 125px;			
			
			}
			.heading
			{
				font-size:small;
				font-weight:bold;
				background-color:lightGrey;
				padding-top: 2px;
				padding-bottom: 2px;
				padding-left: 10px;
				
			}
			table#leftmenus
			{
				width:160px;
				border: solid #D3D3D3 2px;
				padding:0px;
			}
			table#rightmenus
			{
				border: solid #000000 1px;
				padding:0px;
			}
			td#headings
			{
				
				border-bottom: solid #000000 1px;
			
			}
			.listitems
			{
			
				padding-left:5px;
				padding-top:2px;
				
			}
			td.seconda 
			{
				font-family:tahoma;
				font-size:11px;
				color: black;
				background-color: #FFFFFF;
			}

			td.secondb 
			{
				font-family:tahoma;
				font-size:11px;
				color: black;
				background-color: #FFFFCC;
			}
			</style>
			
	</HEAD>
	<BODY>
		<DIV CLASS='TOPTITLE'>
			<img src='images/image2.jpg'>

		</DIV>

		<DIV CLASS='TOPRIGHTTITLE'>
			<table border='0'>
				<tr>
					<td><a href='default.php?Action=Summary'><img src='images/kfm_home.png' alt='Home' border='0'></a></td>
					<td><img src='images/stock_outbox.png' alt='Orders'></td>
					<td><img src='images/stock_people.png' alt='Users'></td>
					<td><img src='images/stock_folder.png' alt='Products'></td>
					<td><img src='images/debugger.png' alt='Bugs'></td>
					<td><img src='images/stock_inbox.png' alt='Manual Orders'></td>
				</tr>
			</table>			
		</DIV>

		
		<DIV CLASS='MENU_UNDERNEATH_TITLE'><?php echo $_GET["Action"];?>
		
		</DIV>
		
		<DIV CLASS='LEFT_MENUS'>
			
			<TABLE id='leftmenus' cellspacing='0'>
				<TR><TD class='Heading'>Orders</TD></TR>
				<TR><TD>
					<LI class='listitems'><a href='default.php?Action=Summary'>Summary</a></LI>
					<LI class='listitems'><a href='default.php?Action=OutstandingOrders'>Outstanding Orders</a></LI>
					<LI class='listitems'><a href='default.php?Action=CancelledOrders'>Cancelled Orders</a></LI>
					<LI class='listitems'><a href='default.php?Action=RefundedOrders'>Refunded Orders</a></LI>
					<LI class='listitems'><a href='default.php?Action=CompletedOrders'>Completed Orders</a></LI>
					<LI class='listitems'><a href='default.php?Action=PreOrders'>Pre-Orders</a></LI>
					<LI class='listitems'><a href='default.php?Action=BasketAdmin'>Basket Admin</a></LI><br>
				</TD></TR>
			</TABLE>
			<p />
			<TABLE id='leftmenus' cellspacing='0'>
				<TR><TD class='Heading'>Find Users</TD></TR>
				<TR><TD>
					<LI class='listitems'><a href='default.php?Action=UserLists'>Full List</a></LI>
					<p><form method='POST' action='default.php?Action=UserLists'>
						&nbsp;&nbsp;<input class='listitems' name='UserID' type='text' size='15'/>
						<br>&nbsp;&nbsp;<input class='listitems' type='submit' text='Search'/>
					</form>
				</TD></TR>
			</TABLE>
			<p />
			<TABLE id='leftmenus' cellspacing='0'>
				<TR><TD class='Heading'>Products</TD></TR>
				<TR><TD>
					<LI class='listitems'><a href='default.php?Action=AddItem'>Add Item</a></LI>
					<!--<LI class='listitems'>Amend Item</LI>-->
					<LI class='listitems'><a href='default.php?Action=LowStock'>Low Stock</a></LI>
					<LI class='listitems'><a href='default.php?Action=OutofStock'>Out of Stock</a></LI>
					<LI class='listitems'><a href='default.php?Action=PreRelease'>Pre-Release</a></LI>
					<LI class='listitems'><a href='default.php?Action=Discontinued'>Discontinued</a></LI>
					<LI class='listitems'><a href='default.php?Action=SpecialItems'>Special Items</a></LI>
					<br><b>&nbsp;&nbsp;Search Stock</b>
					<form action='default.php?Action=UpdStockList' method='POST'>
						&nbsp;&nbsp;<input class='listitems' name='stockID' size='15'>
						<br>&nbsp;&nbsp;<input class='listitems' type='submit'>
					</form></LI>
				</TD></TR>
			</TABLE>
			<p />
			<TABLE id='leftmenus' cellspacing='0'>
				<TR><TD class='Heading'>Bugs/Features</TD><TR>
				<TR><TD>
					<LI class='listitems'><a href='default.php?Action=News'>News</a></LI>
					<LI class='listitems'><a href='default.php?Action=SubmitNews'>Submit News</a></LI>
					<LI class='listitems'><a href='default.php?Action=SubmitBugs'>Submit a Bug</a></LI>
					<LI class='listitems'><a href='default.php?Action=ViewBugs'>View Open Bugs</a></LI>
					<LI class='listitems'><a href='default.php?Action=ListAllBugs'>List All Bugs</a></LI>
					<LI class='listitems'>New feature?</LI>
				<br></TD></TR>
			</TABLE>
			<p />

			<p />
			<TABLE id='leftmenus' cellspacing='0'>
				<TR><TD class='Heading'>Category Management</TD><TR>
				<TR><TD>
					<LI class='listitems'>???</LI>
				<br></TD></TR>
			</TABLE>

			<p />

			<TABLE id='leftmenus' cellspacing='0'>
				<TR><TD class='Heading'>Order Entry</TD></TR>
				<TR><TD>
					<LI class='listitems'>Pre-Order Entry</LI>
					<LI class='listitems'><a href='default.php?Action=ManualOrder'>Manual Order</a></LI>
				</TD></TR>
			</TABLE>
		</DIV>
		
		<DIV CLASS='MAIN_CONTENT'>
		
		<?php
		
			if ($_GET["Action"] == "PreOrders")
			{
			
				include ('includes/PreOrderView.php');
			
			}
			elseif ($_GET["Action"] == "Summary")
			{
			
				include ('includes/Summary.php');
			
			}
			elseif  ($_GET["Action"] == "OutstandingOrders")
			{
			
				include ('includes/OutstandingOrders.php');
			
			}
			elseif  ($_GET["Action"] == "CompletedOrders")
			{
			
				include ('includes/CompletedOrders.php');
			
			}			
			elseif  ($_GET["Action"] == "UserDetails")
			{
			
				include ('includes/UserDetails.php');
			
			}			
			elseif ($_GET["Action"] == "UserLists")
			{
				include ('includes/UserLists.php');
			}
			elseif ($_GET["Action"] == "AddItem")
			{
				include ('includes/AddItem.php');
			}
			elseif ($_GET["Action"] == "ItemList")
			{
				include ('includes/ItemList.php');
			}
			elseif ($_GET["Action"] == "BasketAdmin")
			{
				include ('includes/BasketAdmin.php');
			}			
			elseif ($_GET["Action"] == "BasketContents")
			{
				include ('includes/BasketContents.php');
			}
			elseif ($_GET["Action"] == "AmendItem")
			{
				include ('includes/AmendItem.php');
			}
			elseif ($_GET["Action"] == "ViewItem")
			{
				include ('includes/ViewItem.php');
			}
			elseif ($_GET["Action"] == "LowStock")
			{
				include ('includes/LowStock.php');
			}
			elseif ($_GET["Action"] == "SpecialItems")
			{
				include ('includes/SpecialItems.php');
			}			
			elseif ($_GET["Action"] == "Discontinued")
			{
				include ('includes/Discontinued.php');
			}	
			elseif ($_GET["Action"] == "PreRelease")
			{
				include ('includes/PreRelease.php');
			}	
			elseif ($_GET["Action"] == "OutofStock")
			{
				include ('includes/OutOfStock.php');
			}	
			elseif ($_GET["Action"] == "UpdStockList")
			{
				include ('includes/UpdStockList.php');
			}	
			elseif ($_GET["Action"] == "News")
			{
				include ('includes/News.php');
			}
			elseif ($_GET["Action"] == "ViewBugs")
			{
				include ('includes/ViewBugs.php');
			}
			elseif ($_GET["Action"] == "SubmitBugs")
			{
				include ('includes/SubmitBugs.php');
			}
			elseif ($_GET["Action"] == "SubmitNews")
			{
				include ('includes/SubmitNews.php');
			}
			elseif ($_GET["Action"] == "ListAllBugs")
			{
				include ('includes/ListAllBugs.php');
			}
			elseif ($_GET["Action"] == "ManualOrder")
			{
				include ('includes/ManualOrder.php');
			}
			elseif ($_GET["Action"] == "CancelledOrders")
			{
				include ('includes/CancelledOrders.php');
			}
			elseif ($_GET["Action"] == "RefundedOrders")
			{
				include ('includes/RefundedOrders.php');
			}
			
			?>
		
		</DIV>
		<DIV CLASS='orders'><br><br>
<?php

		if ($_GET["Action"] == "Summary")
		{
			$strNewsQuery = "SELECT * FROM tbl_News order by ColDate DESC Limit 7";
			$strNewsResults = mysql_query($strNewsQuery) or die ("Query Failed :" . mysql_error());

			if (mysql_num_rows($strNewsResults)<>0)
			{
				echo "<p>\n<table id='rightmenus'>";
				echo "<tr><td id='headings'>Date</td><td id='headings'>Headline</td></tr>";
						
			While ($line = mysql_fetch_array($strNewsResults, MYSQL_ASSOC))
			{
				echo "<tr> <td>" . $line["colDate"] ."</td><td> <a href='/stock2/default.php?Action=News'>" . $line["colTitle"] . "</a></td> </tr>";
			}
			
			echo "</table>";
			}

		}
?>		
		</DIV>
	
</BODY>

</HTML>
