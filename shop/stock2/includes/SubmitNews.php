<?php

	include ('includes/Link.php');
	include ('includes/SharedFunctions.php');
	echo "<b>This is the Submit News View</b>";
	
?>	

<p>
  <form method="POST" action="submitNewsintoDB.php">
    
   <br>Title
	<br><input type='text' name='Title' size='16'>
	
	<br>Link
	<br><input type='text' name='Link' size='16'>
	
	<br>Description
	<br><textarea name='Description' cols='50' rows='16'></textarea>
    <br>
    <br>
    <input type="submit" value="Submit" name="B1">
    </font>
  </form>

	
<?php
	
	
	
	
?>
