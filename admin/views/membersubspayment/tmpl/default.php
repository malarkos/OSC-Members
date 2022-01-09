<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
JHtml::_('formbehavior.chosen', 'select');

$member = $this->items[0];
$totalowing = 0.00;
$totalpaid = 0.00;
$totalremain = 0.00;
?>
<?php
$financeeditURL = 'index.php?option=com_subs&view=financeentry&layout=edit&memid=' . $this->items[0]->MemberID;

$link = JRoute::_($financeeditURL);

?>
<h2>Subs payment for <?php echo $this->items[0]->MemberFirstname." ".$this->items[0]->MemberSurname;?>

</h2>
<form action="" method="post" name="adminForm" id="adminForm">
	<table class="table table-striped table-hover">
		<thead>
			<tr>
			
				<th>Description</th>
				<th>Amount</th>
				<th>Paid</th>
				<th>Pay Individual subs</th>
				
			</tr>
		</thead>
		<tbody>
			<tr>
			<?php $memlink = JRoute::_('index.php?option=com_members&view=member&layout=edit&MemberID=' . $this->items[0]->MemberID);
			$payonesublink = JRoute::_('index.php?option=com_members&task=membersubspayment.payonesub&memtype=m&MemberID='.$this->items[0]->MemberID.'&ID=' . $this->items[0]->MemberID);
				?>
				
				<td>Member Sub for <A href="<?php echo $memlink; ?>"><?php echo $this->items[0]->MemberFirstname." ".$this->items[0]->MemberSurname;?></A></td>
				<td>$<?php echo $this->membersubs; $totalowing += $this->membersubs; ?></td>
				<td><?php echo $this->items[0]->CurrentSubsPaid; ?></td>
				<td><a href="<?php echo $payonesublink;?>" >Pay this only</a></td>
				
			</tr>
			<?php // Section for showing family subs?>
			<?php if (!empty($this->familysubs)) : ?>
				<?php foreach ($this->familysubs as $i => $row) :
				$fammemlink = JRoute::_('index.php?option=com_members&view=memberfamily&layout=edit&FamilyMemberID=' . $row->FamilyMemberID);
				$payonesublink = JRoute::_('index.php?option=com_members&task=membersubspayment.payonesub&memtype=f&MemberID='.$this->items[0]->MemberID.'&ID=' . $row->FamilyMemberID); // TO DO work out if spouse, child or buddy
				?>
				<tr>
					
					<td>
						<?php echo $row->FamilyMembershipType;?> membership for <a href="<?php echo $fammemlink; ?>" > <?php echo $row->FamilyMemberFirstname; echo " "; echo $row->FamilyMemberSurname;?></a>
					</td>
					<td align="right">
						$<?php echo $row->Subsval; $totalowing += $row->Subsval;?>
					</td>
					<td><?php echo $row->CurrentSubsPaid;?></td>
					<td><a href="<?php echo $payonesublink;?>" >Pay this only</a></td>
					
				</tr>
			<?php endforeach; ?>
			<?php endif; ?>
			<?php // section for showing locker subs?>
			<?php if (!empty($this->lockersubs)) : ?>
				<?php foreach ($this->lockersubs as $i => $row) :
				$payonesublink = JRoute::_('index.php?option=com_members&task=membersubspayment.payonesub&memtype=l&MemberID='.$this->items[0]->MemberID.'&ID=' . $row->id);
				?>
					<tr>
						<td>
							Subscription for Locker <?php echo $row->LockerNumber; ?>   
						</td>
						<td align="right">
							$<?php echo $row->LockerRate; $totalowing += $row->LockerRate;?>
						</td>
						<td><?php echo $row->CurrentSubsPaid;?></td>
						<td><a href="<?php echo $payonesublink;?>" >Pay this only</a></td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
			<tr>
				<td>Total amount owed:</td>
				<td>$<?php echo $totalowing;?></td>
				<td colspan="2">&nbsp;</td>
			</tr>
		</tbody>
	</table>
	


<h3>Subs payment(s)</h3>
<?php if (!empty($this->subspayments)) : ?>
<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th width="20%">Date</th>
			<th width="20%">Amount</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($this->subspayments as $i => $row) :
		
		$subspaymentlink = JRoute::_('index.php?option=com_subs&view=financeentry&layout=edit&FinanceID=' . $row->FinanceID);
		?>
    		<tr>
    			<td><?php echo $row->Transdate;?></td>
    			<td>
    				<a href="<?php echo $subspaymentlink; ?>">
    					<?php echo $row->Amount;$totalpaid += $row->Amount;?>
    				</a>
    			</td>
    		</tr>
    	<?php endforeach; ?>
    	<tr>
    		<td>Balance remaining</td>
    		<td>$<?php echo $totalowing - $totalpaid;?></td>
    	</tr>
	</tbody>
</table>
<?php else: ?>
No subs payments received.
<?php endif; ?>	

<h3>Current finance balance</h3>
	
<input type="hidden" name="task" value="" /> 
	<input type="hidden" name="totalowing" value="<?php echo $totalowing;?>" /> 
	<input type="hidden" name="totalremain" value="<?php echo $totalremain;?>" /> 
	<input type="hidden" name="totalpaid" value="<?php echo $totalpaid;?>" /> 
	<input type="hidden" name="boxchecked" value="0" /> 
	<input type="hidden" name="memid" value="<?php echo $this->items[0]->MemberID;?>" />
	<?php echo JHtml::_('form.token'); ?>
</form>			