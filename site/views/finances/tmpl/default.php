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
<h3>Member details</h3>

<?php if (!empty($this->data)) : ?>

<table class="table table-striped table-hover">
	<thead>
		<th>Date</th>
		<th>C/D</th>
		<th>Amount</th>
		<th>Total</th>
		<th>Description</th>
	</thead>
	<tbody>
	<?php  $total=0;?>
				<?php foreach ($this->data as $i => $row) : ?>
            		<tr>
						<td><?php echo $row->TransactionDate; ?> </td>
						<td><?php echo $row->CreditDebit; ?> </td>
						<td style="align:right"><?php echo "$ ".$row->Amount; ?> </td>
						<td><?php $total += $row->Amount; $formatted = sprintf("$ %01.2f", $total); echo $formatted; ?> </td>
						<td><?php echo $row->Description; ?> </td>
					</tr>
          
				<?php endforeach; ?>
	</tbody>
</table>

<?php else: ?>
No finance details.
<?php endif; ?>

