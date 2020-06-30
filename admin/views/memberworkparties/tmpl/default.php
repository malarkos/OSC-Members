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
<h2>Work Party summary</h2>
<?php 
    $wpdays = $this->workpartytotal;
    
    if ($wpdays < 20) $wpdisc = 0;
    else if ($wpdays < 40) $wpdisc = 20;
    else if ($wpdays < 60) $wpdisc = 30;
    else if ($wpdays < 80) $wpdisc = 40;
    else if ($wpdays < 100) $wpdisc = 50;
    else if ($wpdays < 120) $wpdisc = 60;
    else if ($wpdays < 140) $wpdisc = 70;
    else $wpdisc = 80;
    
   

?>
<?php echo $this->membername; ?> has <?php echo $this->workpartytotal; ?> work party days and is entitled to <?php echo $wpdisc; ?>% discount on winter bookings.
<h2>Work Party attendance</h2>
<form action="index.php?option=com_members&view=memberworkparties" method="post" id="adminForm" name="adminForm">
	
	<table class="table table-striped table-hover">
		<thead>
		<tr>
			<th width="5%">
				<?php echo JHtml::_('grid.sort', 'COM_MEMBERS_WORKPARTYID', 'WorkPartyID'); ?>
			</th>
			<th width="2%">
				<?php echo JHtml::_('grid.checkall'); ?>
			</th>
			
			<th width="30%">
				<?php echo JText::_('COM_MEMBERS_WORKPARTY_DATE') ;?>
			</th>
			<th width="30%">
				<?php echo JText::_('COM_MEMBERS_WORKPARTY_DAYS') ;?>
			</th>
			<th width="30%">
				<?php echo JText::_('COM_MEMBERS_WORKPARTY_COMMENT') ;?>
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
					$link = JRoute::_('index.php?option=com_members&task=member.edit&WorkPartyID=' . $row->WorkPartyID);
				?>
 
					<tr>
						<td align="center">
							<?php echo $row->WorkPartyID; ?>
						</td>
						<td>
							<?php echo JHtml::_('grid.id', $i, $row->WorkPartyID); ?>
						</td>
						<td>
								
								<?php echo $row->WorkPartyDate; ?>
						</td>
						<td>
								
								<?php echo $row->WorkPartyDays; ?>
						</td>
                                                
						                                              
						<td>
								<?php echo $row->Comments; ?>
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