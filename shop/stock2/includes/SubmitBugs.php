<?php

	include ('includes/Link.php');
	include ('includes/SharedFunctions.php');
	echo "<b>This is the SubmitBugs View</b>";
	
?>	

<p>
  <form method="POST" action="submitBug.php">
    <font size="3">
    <textarea name='Description' cols='50' rows='16'></textarea>
    <br>
    <br>
    Priority: <select name="priority">
		
        <option value="3">Low</option>
        <option value="2">Medium</option>
        <option value="1">High</option>
		<option value="4">Feature</option>
    </select>
    <input type="submit" value="Submit" name="B1">
    </font>
  </form>

	
<?php
	
	
	
	
?>
