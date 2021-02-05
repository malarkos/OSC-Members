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
<?php echo $this->totalworkparties;?>
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

