<?php
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted Access' );
JHtml::_ ( 'formbehavior.chosen', 'select' );

$member = $this->items [0];
$totalowing = 0.00;
?>
<?php 
						$financeeditURL = 'index.php?option=com_subs&view=financeentry&layout=edit&memid='.$this->items[0]->MemberID;
						
						$link = JRoute::_($financeeditURL);
						?> 
<h2>Subs payment for <?php echo $this->items[0]->MemberFirstname." ".$this->items[0]->MemberSurname;?><a href="<?php echo $link; ?>"> Add Finance Entry</a></h2>
<form action="" method="post" name="adminForm" id="adminForm">
	<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th width="50%">Description</th>
							<th width="20%">Amount</th>
							<th width="20%">Paid</th>
							<th width="10%">Update</th>
						</tr>
					</thead>
					<tbody>
					<tr>
						<td>Member Sub for <?php echo $this->items[0]->MemberFirstname." ".$this->items[0]->MemberSurname;?>
						
						
						
						</td>
						<td>$<?php echo $this->membersubs; ?></td>
						<td><?php echo $this->items[0]->CurrentSubsPaid; ?></td>
						<td>Update</td>
					</tr>
					<?php // Section for showing family subs?>
					<?php if (!empty($this->familysubs)) : ?>
							<?php foreach ($this->familysubs as $i => $row) :?>
							<tr>
								<td>
									<?php echo $row->FamilyMembershipType;?> membership for <?php echo $row->FamilyMemberFirstname; echo " "; echo $row->FamilyMemberSurname;?>   
								</td>
								<td align="right">
									$<?php echo $row->Subsval;?>
								</td>
								<td><?php echo $row->CurrentSubsPaid;?></td>
								<td>Update</td>
							</tr>
							<?php endforeach; ?>
					<?php endif; ?>
					<?php // section for showing locker subs?>
					<?php if (!empty($this->lockersubs)) : ?>
						<?php foreach ($this->lockersubs as $i => $row) :?>
						<tr>
							<td>
									 Subscription for Locker <?php echo $row->LockerNumber; ?>   
							</td>
							<td align="right">
								$<?php echo $row->LockerRate;?>
							</td>
							<td><?php echo $row->CurrentSubsPaid;?></td>
							<td>Update</td>
						</tr>
								<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
					</table>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="memid" value="<?php echo $this->items[0]->MemberID;?>" />
		<?php echo JHtml::_('form.token'); ?>
		</form>
		

<h3>Payment</h3>