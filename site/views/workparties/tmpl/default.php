<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_members
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;

?>
<h3>Member Work Parties</h3>

<?php if (!empty($this->data)) : ?>

 <?php if (!empty($this->totalworkparties)) : ?>  Total Work Parties =
<?php echo $this->totalworkparties; $wpdays = $this->totalworkparties;
if ($wpdays < 20) $wpdisc = 0;
else if ($wpdays < 40) $wpdisc = 20;
else if ($wpdays < 60) $wpdisc = 30;
else if ($wpdays < 80) $wpdisc = 40;
else if ($wpdays < 100) $wpdisc = 50;
else if ($wpdays < 120) $wpdisc = 60;
else if ($wpdays < 140) $wpdisc = 70;
else $wpdisc = 80;?><p>
You are entitled to a <?php echo $wpdisc."%";?>discount on your Winter lodge bookings.

<?php endif; ?>

<table class="table table-striped table-hover">
	<thead>
		<th>Date</th>
		<th>Days</th>
		<th>Comment</th>
		
	</thead>
	<tbody>
	<?php  $total=0;?>
				<?php foreach ($this->data as $i => $row) : ?>
            		<tr>
						<td><?php echo $row->WorkPartyDate; ?> </td>
						<td><?php echo $row->WorkPartyDats; ?> </td>
						<td><?php echo $row->Comments; ?> </td>
						
					</tr>
          
				<?php endforeach; ?>
	</tbody>
</table>

<?php else: ?>
No work party details.
<?php endif; ?>

