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
                  
                  <p class="normal"><b>TRANSACTION DETAILS</b></p>
                <!-- Display details for Receipt -->
                  <table width="100%" align="center">
                  <?php if($val=="00") { ?>
                    <tr>
                      <td width="44%" align="left" class="main">Transaction Status</td>
                      <td width="7%" align="center" class="main">:</td>
                      <td width="49%" align="left" class="main"><strong>
                      <!-- Comparing Debit Auth Code and Credit Auth Code to cater SUCCESSFUL and UNSUCCESSFUL result -->
                      <?php
                        if ($fpx_debitAuthCode == '00' && $fpx_debitAuthCode == '00') {
                          echo "SUCCESSFUL";
                        } elseif ($fpx_debitAuthCode == '99') {
                          echo "PENDING FOR AUTHORIZER TO APPROVE";
                        } elseif ($fpx_debitAuthCode != '00' || $fpx_debitAuthCode != '' || $fpx_debitAuthCode != '99') {
                          echo "UNSUCCESSFUL.";
                        }
                      ?>
                      </strong></td>
                    </tr>
                    <tr>
                      <td width="44%" align="left" class="main">FPX Txn ID</td>
                      <td width="7%" align="center" class="main">:</td>
                      <td width="49%" align="left" class="main"><?php echo isset($response_value['fpx_fpxTxnId']) ? $response_value['fpx_fpxTxnId'] : ''; ?></td>
                    </tr>
                    <tr>
                      <td width="44%" align="left" class="main">Seller Order Number</td>
                      <td width="7%" align="center" class="main">:</td>
                      <td width="49%" align="left" class="main"><?php echo isset($response_value['fpx_sellerOrderNo']) ? $response_value['fpx_sellerOrderNo'] : $paymentRecord->seller_order_no; ?></td>
                    </tr>
                    <tr>
                      <td width="44%" align="left" class="main">Buyer Bank</td>
                      <td width="7%" align="center" class="main">:</td>
                      <td width="49%" align="left" class="main"><?php echo isset($response_value['fpx_buyerBankId']) ? $response_value['fpx_buyerBankId'] : ''; ?></td>
                    </tr>
                    <tr>
                      <td width="44%" align="left" class="main">Transaction Amount</td>
                      <td width="7%" align="center" class="main">:</td>
                      <td width="49%" align="left" class="main">RM<?php 
                        if (isset($response_value['fpx_txnAmount'])) {
                          echo number_format($response_value['fpx_txnAmount'], 2);
                        } else {
                          echo number_format($paymentRecord->amount, 2);
                        }
                      ?></td>
                    </tr>
                    <tr>
                      <td width="44%" align="left" class="main">Transaction Time</td>
                      <td width="7%" align="center" class="main">:</td>
                      <td width="49%" align="left" class="main"><?php echo isset($response_value['fpx_fpxTxnTime']) ? $response_value['fpx_fpxTxnTime'] : ''; ?></td>
                    </tr>
                    <tr>
                      <td width="44%" align="left" class="main">Debit Auth Code</td>
                      <td width="7%" align="center" class="main">:</td>
                      <td width="49%" align="left" class="main"><?php echo $fpx_debitAuthCode ?? ''; ?></td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td width="44%" align="left" class="main">Error</td>
                      <td width="7%" align="center" class="main">:</td>
                      <td width="49%" align="left" class="main"><?php echo $ErrorCode ?? 'Unknown error occurred'; ?></td>
                    </tr>
                  <?php } ?>
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
    <p>&nbsp;</p>
    <tr>
        <td style="padding-left: 1px; padding-right: 1px;" align="left" valign="top" width="716" colspan=2>
            
        </td>
    </tr>
  <p>&nbsp;</p>
</center>   

<!-- footer_eof //-->
<br>
</body></html>