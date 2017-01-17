<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted Access' );
JHtml::_ ( 'formbehavior.chosen', 'select' );

$member = $this->items [0];
$totalowing = 0.00;
?>
<?php  $u =& JURI::getInstance(); $ucomp = $u.'&tmpl=component';
$jinput = JFactory::getApplication ()->input;

$memid = $jinput->get ( 'memid', 0 );
?>

						<form action="<?php echo JRoute::_('index.php?option=com_members&task=membersubsreceipt.emailmember'); ?>"
						 method="post" id="adminForm" name="adminForm">
						<button type="submit" class="button"><?php echo JText::_('Email'); ?></button>
						
						<input type="hidden" name="memid" value="<?php echo JText::_($memid);?>"/>
						</form>
						
<table width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td align="center">
			<h2>
				Ormond Ski Club 2017 Subscription Notice<img
					src="http://www.ormondskiclub.com.au/images/osclogo58.png"
					alt="Ormond Ski Club Logo" height="58" width="111">
			</h2>
		</td>
	</tr>
	<tr>
		<td align="center"><h3>
				<font color="blue">TAX RECEIPT</font>
			</h3></td>
	</tr>
	<tr>
		<table width="100%" border="0">
			<tr>
				<td width="50%"><Font size="+2"><b><?php echo $member->MemberFirstname; echo " "; echo $member->MemberSurname;  ?></b></Font>
					<p>
						<font size="+1"><?php echo $member->MemberHomeAddress;echo " "; echo $member->MemberHomeAddress2;?></br>
					
					<?php echo $member->MemberHomeSuburb;?></br>
					<?php echo $member->MemberHomeState; echo " "; echo $member->MemberHomePostcode;?></font></td>
				<td width="50%" align="right"><i><b>Ormond Ski Club</b></br> 1/175 Fitzroy St</br> FITZROY, Vic, 3065</br> email:
						general@ormondskiclub.com.au</br> web: www.ormondskiclub.com.au</br>
						ABN: 75004765753
						<p>Date issued: <b><?php echo date("d M Y"); ?></b></i></br>
						<a href="<?php echo $ucomp;?>">Print</a> 
						
						
						
						</td>
			</tr>
		</table>
	</tr>
	<tr>
		<td>
			Dear <?php echo $this->items[0]->MemberFirstname;?>,<p>
			
			<p>
				Please find below your receipt for your subscriptions payment. If you have any questions, please contact the Membership officer at general@ormondskiclub.com.au.
		
		</td>
	</tr>
	<tr>
		<table width="100%" border="2">
			<td >
				<h3>2017 Membership Subscriptions</h3>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th width="60%">Description</th>
							<th width="15%">Amount</th>
							<th width="15%">Total</th>
							<th width="10%">Paid</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Balance as of 30 Nov 2016</td>
							<td align="right">$<?php echo $this->currentbalance; ?>
						<?php $totalowing += $this->currentbalance;?></td>
							<td>$<?php $totalowed = sprintf("%04.2f",$totalowing); echo $totalowed;  ?></td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>
							<?php echo $member->MemberType;?> Membership
						</td>
							<td align="right">$<?php $memsubs =  sprintf("%04.2f",$this->membersubs); echo $memsubs; ?> <?php $totalowing -= $this->membersubs;?>
						</td>
							<td>$<?php $totalowed = sprintf("%04.2f",$totalowing); echo $totalowed;  ?></td>
							<td>
								<?php echo $this->membersubspaid; ?>
							</td>
						</tr>
					
						<?php if (!empty($this->familysubs)) : ?>
							<?php foreach ($this->familysubs as $i => $row) :?>
							<tr>
							<td>
									<?php echo $row->FamilyMembershipType;?> membership for <?php echo $row->FamilyMemberFirstname; echo " "; echo $row->FamilyMemberSurname;?>   </td>
							<td align="right">$<?php echo $row->Subsval;?>
									<?php $totalowing -= $row->Subsval;?>
								</td>
							<td>$<?php $totalowed = sprintf("%04.2f",$totalowing); echo $totalowed;  ?></td>
							<td><?php echo $row->CurrentSubsPaid; ?></td>
						</tr>
								<?php endforeach; ?>
						<?php endif; ?>
						
					
								<?php if (!empty($this->lockersubs)) : ?>
									<?php foreach ($this->lockersubs as $i => $row) :?>
						<tr>
							<td>
									 Subscription for Locker <?php echo $row->LockerNumber; ?>   </td>
							<td align="right">$<?php echo $row->LockerRate;?>
									<?php $totalowing -= $row->LockerRate;?>
								</td>
							<td>$<?php $totalowed = sprintf("%04.2f",$totalowing); echo $totalowed;  ?></td>
							<td><?php echo $row->CurrentSubsPaid; ?></td>
						</tr>
								<?php endforeach; ?>
						<?php endif; ?>
						
						<?php if (!empty($this->subspayments)) : ?>
									<?php foreach ($this->subspayments as $i => $row) :?>
									<tr>
										<td>Subs payment received on <?php echo $row->Transdate; ?></td>
										<td>$<?php echo $row->Amount;$totalowing += $row->Amount;?></td>
										<td>$<?php $totalowed = sprintf("%04.2f",$totalowing); echo $totalowed;  ?></td>
										<td>&nbsp;</td>
									</tr>
							<?php endforeach; ?>
						<?php endif; ?>			
						<tr>
							<td>Balance due by <b>28th Feb 2017</b><?php if ($totalowing >= 0) echo " - No payment required.";?></td>
							<td>&nbsp;</td>
							<td align="right"><b>$<?php if ($totalowing < 0) $totalowing *= -1;  $totalowing = sprintf("%04.2f",$totalowing); echo $totalowing;?></b>
							</td>
							<td>&nbsp;</td>
						</tr>
					</tbody>
				</table>
			</td>
			
		</table>
	</tr>

	
	

</table>
<?php 
// print_r($this->familysubs)
//print_r ( $this->currentbalance)?>
