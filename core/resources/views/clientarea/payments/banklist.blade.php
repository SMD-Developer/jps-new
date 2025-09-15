<table border="0" cellpadding="0" cellspacing="0" height="300" width="722">
    <tbody>
      <tr>
        <td colspan="3" align="left" height="111"><table style="background:#FDE6C4;border: 1px solid rgb(222, 217, 197);" cellpadding="0" cellspacing="0" height="111" width="722" >
            <tbody>
              <tr>
                <td align="center"><strong>SAMPLE FPX MERCHANT PAGE</strong></td>
              </tr>
            </tbody>
          </table>
		  </td>
      </tr>
      <!-- header_eof //-->
      <!-- body //-->
      <tr>
        <td style="padding-right: 1px;" align="right" valign="top" width="6"><br>
        </td>
        <td style="padding-left: 1px; padding-right: 1px;" align="left" valign="top" width="716" colspan=2>
		<table bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="5" class="infoBelow" width="100%" height="100%">
		  <tbody>
              <tr>
                <td height="150" valign="top">				
				<p class="normal">
                    Thanks for shopping with us online! </p>
                  <p>&nbsp;</p>				  
				  
				  <p class="normal"><b>BANK DETAILS</b></p>
				<!-- Display details for Receipt -->
				  <table width="100%" align="center">
				  
					<tr>
                      <td width="44%" align="left" class="main">Buyer Banks</td>
                      <td width="7%" align="center" class="main">:</td> 
                      <td width="49%" align="left" class="main">
					  <select name="banklist" multiple="multiple">					  
					  <?php
					  foreach($bank_list as $key=>$value) {
						   ?>
						   <option><?php echo $key.'='.$value ?></option>					  
						<?php 
					}
						?>
						 
						 
						 </option>
						 </select>
						 </td>
                    </tr>					
                  </table>
			    </td>
              </tr>
		  </tbody>
          </table></td>
      </tr>
      <!-- footer //-->  
    </tbody>
  </table>
  <p>&nbsp;</p>
  <hr>
  <center>
  <p class="infoBelow">&nbsp;</p>
    <p class="infoBelow">This parameter should be hidden from customer </p>  
	<p>&nbsp;</p>
	<tr>
        <td style="padding-left: 1px; padding-right: 1px;" align="left" valign="top" width="716" colspan=2>
			<table width="100%" border="0" align="center" cellpadding="7" cellspacing="0" >
				<tr>
				  <td colspan="100"></td>
				</tr>
				<tr>
				  <td class="infoBelow" align="center">Message From FPX
					<p>&nbsp;</p>
					<textarea cols=80 rows=4 ><?php echo $data; ?></textarea>
					<p>&nbsp;</p>		
				</tr>
				
			</table>
		</td>
	</tr>
  <p>&nbsp;</p>
</center>   
<!-- footer_eof //-->
<br>
</body></html>