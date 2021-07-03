<?php /* Smarty version 2.6.20, created on 2015-05-23 12:08:21
         compiled from /home/nolalico/public_website/campaigns/5357/media/templates/1432241262/1432241262.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', '/home/nolalico/public_website/campaigns/5357/media/templates/1432241262/1432241262.html', 22, false),array('modifier', 'number_format', '/home/nolalico/public_website/campaigns/5357/media/templates/1432241262/1432241262.html', 30, false),array('modifier', 'date_format', '/home/nolalico/public_website/campaigns/5357/media/templates/1432241262/1432241262.html', 61, false),array('function', 'math', '/home/nolalico/public_website/campaigns/5357/media/templates/1432241262/1432241262.html', 78, false),)), $this); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Invoice</title>
<link rel="stylesheet" href="http://<?php echo $this->_tpl_vars['domainData']['campaign_domain']; ?>
/media/templates/1432241262/1432241262.css">
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<td>
            <table width="1020" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td valign="top">
                    	<table width="1020" border="0" align="left" cellpadding="15" cellspacing="0">
                        	<tr>
                            	<td valign="top" style="font-size: 50px; font-family: Helvetica, Verdana, Arial, sans-serif;">
                                	<span style="font-family: 'Source Sans Pro', Helvetica, Verdana, Arial, sans-serif; font-size: 35px; font-weight: bold; text-transform: uppercase;">Invoice</span><br /><br />
									<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 40px; font-family: Helvetica, Verdana, Arial, sans-serif;">
										<tr>
											<td align="left">  
												<span style="font-family: 'Source Sans Pro', Helvetica, Verdana, Arial, sans-serif; font-size: 40px; font-weight: bold; text-transform: uppercase;"><?php echo $this->_tpl_vars['domainData']['campaign_name']; ?>
</span><br><br>
												Cell: <?php echo ((is_array($_tmp=@$this->_tpl_vars['invoiceData']['invoice_person_number'])) ? $this->_run_mod_handler('default', true, $_tmp, "N/A") : smarty_modifier_default($_tmp, "N/A")); ?>
 / Tel: <?php echo ((is_array($_tmp=@$this->_tpl_vars['invoiceData']['client_contact_telephone'])) ? $this->_run_mod_handler('default', true, $_tmp, "N/A") : smarty_modifier_default($_tmp, "N/A")); ?>
<br />
												Email: <?php echo ((is_array($_tmp=@$this->_tpl_vars['invoiceData']['invoice_person_email'])) ? $this->_run_mod_handler('default', true, $_tmp, "N/A") : smarty_modifier_default($_tmp, "N/A")); ?>
<br />
												To: <?php echo $this->_tpl_vars['invoiceData']['invoice_person_name']; ?>
<br />
											</td>
										</tr>
									</table>
									<br />
									<p>
									The invoice reference is <span style="font-family: 'Source Sans Pro', Helvetica, Verdana, Arial, sans-serif; font-size: 40px; font-weight: bold; text-transform: uppercase;"><?php echo $this->_tpl_vars['invoiceData']['invoice_code']; ?>
</span> and has a total remaining amount of <span style="font-family: 'Source Sans Pro', Helvetica, Verdana, Arial, sans-serif; font-size: 40px; font-weight: bold; text-transform: uppercase;">R <?php echo ((is_array($_tmp=$this->_tpl_vars['invoiceData']['payment_remainder'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ",", ' ') : number_format($_tmp, 2, ",", ' ')); ?>
</span>. Please use the reference; <strong><?php echo $this->_tpl_vars['invoiceData']['invoice_code']; ?>
</strong> when making payments.
									</p>							
									<p>
										Below is the break down of the invoice: 
									</p>		
										<table id="items" style="font-size: 40px; font-family: Helvetica, Verdana, Arial, sans-serif;">
											<tbody>
												<tr>
													<th width="20%">Item</th>
													<th width="50%">Description</th>
													<th width="5%">Unit</th>
													<th>Price</th>
													<th>Total</th>
												</tr>
												<tr class="item-row">
													<td colspan="5"></td>
												</tr>												
													<?php $_from = $this->_tpl_vars['invoiceData']['invoiceitem']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
													<tr class="item-row">
														<td class="item-name"><?php echo $this->_tpl_vars['item']['invoiceitem_name']; ?>
</td>
														<td class="description"><?php echo $this->_tpl_vars['item']['invoiceitem_description']; ?>
</td>
														<td class="item-name"><?php echo $this->_tpl_vars['item']['invoiceitem_quantity']; ?>
</td>
														<td align="right">R <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['invoiceitem_amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ",", ' ') : number_format($_tmp, 2, ",", ' ')); ?>
</td>
														<td align="right">R <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['invoiceitem_total'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ",", ' ') : number_format($_tmp, 2, ",", ' ')); ?>
</td>
													</tr>
													<?php endforeach; endif; unset($_from); ?>
												<tr>
													<th align="left" colspan="5" class="total-value" >Payments Made</th>
												</tr>
												<?php $_from = $this->_tpl_vars['invoiceData']['invoicepayment']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
												<tr class="item-row">
													<td class="item-name" colspan="2"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['invoicepayment_paid_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%B %e, %Y") : smarty_modifier_date_format($_tmp, "%B %e, %Y")); ?>
</td>
													<td class="description"colspan="3" align="right">- R <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['invoicepayment_amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ",", ' ') : number_format($_tmp, 2, ",", ' ')); ?>
</td>
												</tr>
												<?php endforeach; else: ?>
												<tr class="item-row">
													<td align="left" colspan="5">No Payments made yet.</td>
												</tr>			
												<?php endif; unset($_from); ?>
												<tr>
													<th align="left" colspan="5" class="total-value" >Total Amounts</th>
												</tr>												
												<tr>
													<td align="left" colspan="2">Item Total</td>
													<td align="center"></td>
													<td align="right" colspan="2">R <?php echo ((is_array($_tmp=$this->_tpl_vars['invoiceData']['item_total_sub'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ",", ' ') : number_format($_tmp, 2, ",", ' ')); ?>
</td>
												</tr>
												<tr>
													<td align="left" colspan="2">Vat Total at <?php echo smarty_function_math(array('equation' => "x * y",'x' => $this->_tpl_vars['domainData']['campaign_vat'],'y' => 100), $this);?>
%</td>
													<td align="center"></td>
													<td align="right" colspan="2">R <?php echo ((is_array($_tmp=$this->_tpl_vars['invoiceData']['item_vat'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ",", ' ') : number_format($_tmp, 2, ",", ' ')); ?>
</td>
												</tr>
												<tr>
													<td align="left" colspan="2">Sub Total</td>
													<td align="center"></td>
													<td align="right" colspan="2">R <?php echo ((is_array($_tmp=$this->_tpl_vars['invoiceData']['item_total'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ",", ' ') : number_format($_tmp, 2, ",", ' ')); ?>
</td>
												</tr>
												<tr>
													<td align="left" colspan="2">Payments Total</td>
													<td align="center"></td>
													<td align="right" colspan="2">R <?php echo ((is_array($_tmp=$this->_tpl_vars['invoiceData']['payment_total'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ",", ' ') : number_format($_tmp, 2, ",", ' ')); ?>
</td>
												</tr>
												<tr>
													<td align="left" colspan="2">Invoice Total (remaining)</td>
													<td align="center"></td>
													<td align="right" colspan="2">R <?php echo ((is_array($_tmp=$this->_tpl_vars['invoiceData']['payment_remainder'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ",", ' ') : number_format($_tmp, 2, ",", ' ')); ?>
</td>
												</tr>												
											</tbody>
										</table>		
										<p id="terms">
										Payments Made To:<br /><br />
										Account Holder: <?php echo $this->_tpl_vars['domainData']['campaign_bankaccount_holder']; ?>
<br />
										Bank: <?php echo $this->_tpl_vars['domainData']['campaign_bankaccount_bank']; ?>
<br />
										Account Number: <?php echo $this->_tpl_vars['domainData']['campaign_bankaccount_number']; ?>
<br />
										Branch Code: <?php echo $this->_tpl_vars['domainData']['campaign_bankaccount_branchcode']; ?>
<br />
										Reference: <?php echo $this->_tpl_vars['invoiceData']['invoice_code']; ?>
 
										</p>										
                                </td>								
                            </tr>
                        </table>
					</td>
				</tr>
            </table>
		</td>
	</tr>
</table>
</body>
</html>