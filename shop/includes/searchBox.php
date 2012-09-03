
      <table width="200"  border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#002A54">
        <tr>
          <td bgcolor="#002A54">
            <div align="center"><b>Feedback</b></div>
          </td>
        </tr>
        <tr>
          <td><font face="Verdana, Arial, Helvetica, sans-serif"> </font>
            <table width="200" border="0" cellpadding="5" bgcolor="#CCCCCC" id="partial">
              <tr>
                <td bgcolor="#CCCCCC"> We're asking for any feedback as you use this site.
					<form action='submitfeedback.php' method='post'>
						<input type='text' name='feedback' size='26'>
						<p align="center">
                      <input TYPE='submit' name='Submit' Value='Submit'>
                      <input TYPE='hidden' name='URL' Value='<?php echo $_SERVER['REQUEST_URI'] ?>'>
                  </form>
				</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
      </table>
