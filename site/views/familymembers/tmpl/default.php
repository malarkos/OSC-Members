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
<h3>Family Member details</h3>

<?php if (!empty($this->data)) : ?>

<table class="table table-striped table-hover">
	<thead>
		<th>Family Member</th>
		<th>Type</th>
		<th>DoB</th>
	</thead>
	<tbody>
				<?php foreach ($this->data as $i => $row) : ?>
            		<tr>
						<td><?php echo $row->FamilyMemberFirstname; ?> <?php echo $row->FamilyMemberSurname; ?></td>
						<td><?php echo $row->FamilyMembershipType; ?> </td>
						<td><?php echo $row->FamilyMemberBirthDate; ?> </td>
					</tr>
          
				<?php endforeach; ?>
	</tbody>
</table>

<?php else: ?>
No family members.
<?php endif; ?>

Please contact the Membership Officer if you need to add, change or remove family or buddy members.
 		