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
				<?php foreach ($this->data as $i => $row) :
				?>
				<A href="<?php echo JRoute::_('index.php?option=com_members&view=familymembers&layout=edit'); ?>">Update details</A>
            <table class="table table-striped table-hover">
            	<tbody>
            		<tr>
            			<td>Family Member:</td>
            			<td><?php echo $row->FamilyMemberFirstname; ?> <?php echo $row->FamilyMemberSurname; ?></td>
            		</tr>
            		<tr>
            			<td>Family Member Type:</td>
            			<td><?php echo $row->FamilyMembershipType; ?> </td>
            		</tr>
            		
            		<tr>
            			<td >Date of Birth:</td>
            			<td ><?php echo $row->FamilyMemberBirthDate; ?> </td>
            		</tr>
            	</tbody>
            </table>

		<?php endforeach; ?>
<?php else: ?>
No family members.
<?php endif; ?>
 		