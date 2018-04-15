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

?>
<form action="index.php?option=com_members&view=memberfamilies" method="post" id="adminForm" name="adminForm">
	<div class="row-fluid">
		<div class="span6">
			<?php echo JText::_('COM_MEMBERS_FAMILYMEMBER_FILTER'); ?>
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
				<?php echo JText::_('COM_MEMBERS_FAMILYMEMBER_ID') ; ?>
			</th>
			
			<th width="8%">
				<?php echo JText::_('COM_MEMBERS_FAMILYMEMBER_FIRSTNAME') ; ?>
			</th>
            <th width="8%">
				<?php echo JText::_('COM_MEMBERS_FAMILYMEMBER_SURSTNAME') ; ?>
			</th>
            <th width="5%">
				
				<?php echo JText::_('COM_MEMBERS_FAMILYMEMBER_FAMILYMEMBERTYPE') ; ?>
			</th>
				<th width="5%">
				<?php echo JText::_('COM_MEMBERS_FAMILYMEMBER_MEMBER') ;?>
			</th>
			<th width="5%">
				<?php echo JText::_('COM_MEMBERS_FAMILYMEMBER_SUBSPAID') ;?>
			</th>
			<th width="5%">
				<?php echo JText::_('COM_MEMBERS_FAMILYMEMBER_BIRTHDATE') ;?>
			</th>
			<th width="5%">
				<?php echo JText::_('COM_MEMBERS_FAMILYMEMBER_JOINDATE') ;?>
			</th>
			<th width="5%">
				<?php echo JText::_('COM_MEMBERS_FAMILYMEMBER_DEPATUREDATE') ;?>
			</th>
			
		</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="6">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php if (!empty($this->items)) : ?>
				<?php foreach ($this->items as $i => $row) :
					$link = JRoute::_('index.php?option=com_members&task=memberfamily.edit&FamilyMemberID=' . $row->FamilyMemberID);
					
					//$subslink = JRoute::_('index.php?option=com_members&view=membersubsnotice&memid=' . $row->MemberID.'&tmpl=component&print=1&page=');
				?>
 
					<tr>
						<td align="center">
							<a href="<?php echo $link; ?>" title="<?php echo JText::_('COM_MEMBERS_EDIT_FAMILYMEMBER'); ?>">
								<?php echo $row->FamilyMemberID; ?>
							</a>
						</td>
						
						
						<td>
								
								<?php echo $row->FamilyMemberFirstname; ?>
						</td>
                        <td>
							
								<?php echo $row->FamilyMemberSurname; ?>
							
						</td>                                               
						<td>
								<?php echo $row->FamilyMembershipType; ?>
						</td>
						
						
						<td>
								<?php echo $row->membername; ?>
						</td>
						<td>
								<?php echo $row->CurrentSubsPaid; ?>
						</td>
						<td>
								<?php echo $row->FamilyMemberBirthDate; ?>
						</td>
						<td>
								<?php echo $row->FamilyMemberJoinDate; ?>
						</td>
						<td>
								<?php echo $row->FamilyMemberDepartureDate; ?>
						</td>
						
						
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	
	<?php echo JHtml::_('form.token'); ?>
</form>