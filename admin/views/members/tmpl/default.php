<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
JHtml::_('formbehavior.chosen', 'select');
 
$listOrder     = $this->escape($this->filter_order);
$listDirn      = $this->escape($this->filter_order_Dir);
?>
<form action="index.php?option=com_members&view=members" method="post" id="adminForm" name="adminForm">
	<div class="row-fluid">
		<div class="span6">
			<?php echo JText::_('COM_MEMBERS_FILTER'); ?>
			<?php
				echo JLayoutHelper::render(
					'joomla.searchtools.default',
					array('view' => $this)
				);
			?>
		</div>
	</div>
	<table class="table table-striped table-hover">
		<thead>
		<tr>
			<th width="3%">
				<?php echo JHtml::_('grid.sort', 'COM_MEMBERS_ID', 'MemberID', $listDirn, $listOrder); ?>
			</th>
			
			<th width="3%">
				<?php echo JText::_('COM_MEMBERS_TITLE') ;?>
			
			
			<th width="8%">
				<?php echo JHtml::_('grid.sort', 'COM_MEMBERS_FIRSTNAME', 'MemberFirstname', $listDirn, $listOrder); ?>
			</th>
                        <th width="8%">
				
				<?php echo JHtml::_('grid.sort', 'COM_MEMBERS_SURSTNAME', 'MemberSurname', $listDirn, $listOrder); ?>
			</th>
                        <th width="5%">
				
				<?php echo JHtml::_('grid.sort', 'COM_MEMBERS_MEMBERTYPE', 'MemberType', $listDirn, $listOrder); ?>
			</th>
			</th>
				<th width="5%">
				<?php echo JText::_('COM_MEMBERS_FAMILY') ;?>
			</th>
			</th>
				<th width="5%">
				<?php echo JText::_('COM_MEMBERS_LOCKERS') ;?>
			</th>
			</th>
				<th width="5%">
				<?php echo JText::_('COM_MEMBERS_FINANCE') ;?>
			</th>
			</th>
				<th width="5%">
				<?php echo JText::_('COM_MEMBERS_LOA') ;?>
			</th>
			</th>
				<th width="5%">
				<?php echo JText::_('COM_MEMBERS_SUBSPAID') ;?>
			</th>
			</th>
				<th width="5%">
				<?php echo JText::_('COM_MEMBERS_SUBS') ;?>
			</th>
			</th>
				<th width="5%">
				<?php echo JText::_('COM_MEMBERS_PAYSUBS') ;?>
			</th>
			</th>
				<th width="5%">
				<?php echo JText::_('COM_MEMBERS_SUBS_RECEIPT') ;?>
			</th>
			</th>
				<th width="5%">
				<?php echo JText::_('COM_MEMBERS_WORKPARTIES') ;?>
			</th>
			<th width="10%">
				<?php echo JText::_('COM_MEMBERS_EMAIL') ;?>
			</th>
			<th width="10%">
				<?php echo JText::_('COM_MEMBERS_MOBILE') ;?>
			</th>
			<th width="10%">
				<?php echo JText::_('COM_MEMBERS_WORK') ;?>
			</th>
			
		</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="5">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php if (!empty($this->items)) : ?>
				<?php foreach ($this->items as $i => $row) :
					$link = JRoute::_('index.php?option=com_members&task=member.edit&MemberID=' . $row->MemberID);
					$wplink = JRoute::_('index.php?option=com_members&view=memberworkparties&memid=' . $row->MemberID);
					$subslink = JRoute::_('index.php?option=com_members&view=membersubsnotice&memid=' . $row->MemberID.'&tmpl=component');
					//$subslink = JRoute::_('index.php?option=com_members&view=membersubsnotice&memid=' . $row->MemberID.'&tmpl=component');
					$subspaymentlink = JRoute::_('index.php?option=com_members&view=membersubspayment&memid=' . $row->MemberID);
					$subsreceiptlink = JRoute::_('index.php?option=com_members&view=membersubsreceipt&memid=' . $row->MemberID);
					$lockerlink = JRoute::_('index.php?option=com_lockers&view=lockers&memid='. $row->MemberID);
					$financeslink = JRoute::_('index.php?option=com_finances&view=finances&memid='. $row->MemberID);
					$familieslink = JRoute::_('index.php?option=com_members&view=memberfamilies&memid='. $row->MemberID);
					//$subslink = JRoute::_('index.php?option=com_members&view=membersubsnotice&memid=' . $row->MemberID.'&tmpl=component&print=1&page=');
				?>
 
					<tr>
						<td align="center">
							<a href="<?php echo $link; ?>" title="<?php echo JText::_('COM_MEMBERS_EDIT_MEMBER'); ?>">
								<?php echo $row->MemberID; ?>
							</a>
						</td>
						
						<td>
								
								<?php echo $row->MemberTitle; ?>
						</td>
						<td>
								
								<?php echo $row->MemberFirstname; ?>
						</td>
                                                 <td>
							
								<?php echo $row->MemberSurname; ?>
							
						</td>                                               
						<td>
								<?php echo $row->MemberType; ?>
						</td>
						<td>
								
								<?php if ($row->familycount> 0)
								{?>
									<a href="<?php echo $familieslink; ?>" >
										Family members
									</a>
									<?php 
								}
								else {echo "-";}
									
								?>
									
						</td>
						<td>
								<?php if ($row->lockercount > 0)
								{?>
									<a href="<?php echo $lockerlink; ?>" >
										Locker(s)
									</a>
									<?php 
								}
								else {echo "-";}
									
									?>
						</td>
						<td>
								<a href="<?php echo $financeslink; ?>" >Finance</a>
						</td>
						<td>
								<?php echo $row->MemberLeaveofAbsence; ?>
						</td>
						<td>
								<?php echo $row->CurrentSubsPaid; ?>
						</td>
						<td>
								<a href="<?php echo $subslink; ?>">
									Subs Notice
								</a>
						</td>
						<td>
								<a href="<?php echo $subspaymentlink; ?>">
									Pay Subs
								</a>
						</td>
						<td>
								<a href="<?php echo $subsreceiptlink; ?>">
									Subs Receipt
								</a>
						</td>
						</td>
                        <td>
							<a href="<?php echo $wplink; ?>">
								Work parties
							</a>
						</td>  
						<td>
								<?php echo $row->MemberEmail; ?>
						</td>
						<td>
								<?php echo $row->MemberPhoneMobile; ?>
						</td>
						<td>
								<?php echo $row->MemberPhoneWork; ?>
						</td>
						
						
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
	<?php echo JHtml::_('form.token'); ?>
</form>