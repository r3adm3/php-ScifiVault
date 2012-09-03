<?php

	include ('includes/Link.php');
	include ('includes/SharedFunctions.php');
	echo "<b>This is the Add Item View</b><p>";
	
?>
<table width="750" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="375" valign="top">
      <form method="POST" action="submitAdd.php">
        <table >
          <tr>
            <td bgcolor="#FFFFCC">Subject: </td>
            <td>
              <input type="text" name="Subject" size="20">
              <br>
            </td>
          </tr>
          <tr>
            <td bgcolor="#FFFFCC">Version: </td>
            <td>
              <input type="text" name="Version" size="20">
              <br>
            </td>
          </tr>
          <tr>
            <td bgcolor="#FFFFCC">Category: </td>
            <td>
              <input type="text" name="Category" size="20">
              <br>
            </td>
          </tr>
          <tr>
            <td bgcolor="#FFFFCC">stockID:</td>
            <td>
              <input type="text" name="stockID" size="20">
              <br>
            </td>
          </tr>
          <tr>
            <td bgcolor="#FFFFCC">Barcode: </td>
            <td>
              <input type="text" name="Barcode" size="20">
              <br>
            </td>
          </tr>
          <tr>
            <td bgcolor="#FFFFCC">Name: </td>
            <td>
              <input type="text" name="Name" size="20">
              <br>
            </td>
          </tr>
          <tr>
            <td bgcolor="#FFFFCC">shortDescription:</td>
            <td>
              <input type="text" name="shortDescription" size="20">
              <br>
            </td>
          </tr>
          <tr>
            <td bgcolor="#FFFFCC">Features: </td>
            <td>
              <input type="text" name="Features" size="20">
              <br>
            </td>
          </tr>
          <tr>
            <td bgcolor="#FFFFCC">Size: </td>
            <td>
              <input type="text" name="Size" size="20">
              <br>
            </td>
          </tr>
          <tr>
            <td bgcolor="#FFFFCC">Weight: </td>
            <td>
              <input type="text" name="Weight" size="20">
              <br>
            </td>
          </tr>
          <tr>
            <td bgcolor="#FFFFCC">Cost: </td>
            <td>
              <input type="text" name="Cost" size="20">
              <br>
            </td>
          </tr>
          <tr>
            <td bgcolor="#FFFFCC">RRP: </td>
            <td>
              <input type="text" name="RRP" size="20">
              <br>
            </td>
          </tr>
          <tr>
            <td bgcolor="#FFFFCC">SaleRRP:</td>
            <td>
              <input type="text" name="SaleRRP" size="20">
              <br>
            </td>
          </tr>
          <tr>
            <td bgcolor="#FFFFCC">% Discount: </td>
            <td>
              <input type="text" name="percentDiscount" size="20">
              <br>
            </td>
          </tr>
          <tr>
            <td bgcolor="#FFFFCC">WholeSale Price:</td>
            <td>
              <input type="text" name="WholeSalePrice" size="20">
              <br>
            </td>
          </tr>
          <tr>
            <td bgcolor="#FFFFCC">Supplier: </td>
            <td>
              <input type="text" name="Supplier" size="20">
              <br>
            </td>
          </tr>
          <tr>
            <td bgcolor="#FFFFCC">Availaibility: </td>
            <td>
              <input type="text" name="Availability" size="20">
              <br>
            </td>
          </tr>
          <tr>
            <td bgcolor="#FFFFCC">Stock Count: </td>
            <td>
              <input type='text' name='NoOfItems' size='20'>
            </td>
          </tr>
        </table>

    </td>
    <td width="375" valign="top">
      <table>
        <tr>
          <td  bgcolor="#FFFFCC" valign='top'>Description: </td>
          <td>
            <textarea name='Description' cols='50' rows='16'></textarea>
          </td>
        </tr>
        <tr>
          <td bgcolor="#FFFFCC">Small Picture: </td>
          <td>
            <input type='text' name='smallPicture' size='25'>
          </td>
        </tr>
        <tr>
          <td bgcolor="#FFFFCC">Large Picture: </td>
          <td>
            <input type='text' name='bigPicture' size='25'>
          </td>
        </tr>
        <tr>
          <td bgcolor="#FFFFCC">Category Tag:</td>
          <td>
            <input type='text' name='CategoryTag' size='25'>
          </td>
        </tr>
        <tr>
          <td bgcolor="#FFFFCC">Subject Tag:</td>
          <td>
            <input type='text' name='SubjectTag' size='25'>
          </td>
        </tr>
        <tr>
          <td bgcolor="#FFFFCC">Version Tag:</td>
          <td>
            <input type='text' name='VersionTag' size='25'>
          </td>
        </tr>
		<tr>

			<td  bgcolor='#FFFFCC' valign='top'>On the Front Page?:  </td>
			<td><input type='checkbox' name='FrontPage'></td>

		</tr>

		<tr>

			<td  bgcolor='#FFFFCC' valign='top'>Featured on subCategory:  </td>
			<td><input type='checkbox' name='SubCatPage'></td>

		</tr>
		
		
		
      </table>
      <br>
      <center>
        <input type="submit" value="Submit" name="B1">
        <input type="reset" value="Reset" name="B2">
      </center>

</form>




<?php

	
	
?>
