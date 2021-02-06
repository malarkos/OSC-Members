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
<h3>Member Subs notice</h3>
The Subs notice is as follows

<table class="table table-striped table-hover">
	<tbody>
		<tr>
			<td>Member:</td>
			<td><?php echo $this->data->MemberFirstname; ?> <?php echo $this->data->MemberSurname; ?></td>
			<td >Date of Birth:</td>
			<td ><?php echo $this->data->memberdob; ?> </td>
		</tr>
		
		
	</tbody>
</table>

<?php if (!empty($this->lockers)) : ?>

<h4>Lockers assigned</h4>
<table class="table table-striped table-hover">
	
	<tbody>
	<?php  $total=0;?>
				<?php foreach ($this->lockers as $i => $row) : ?>
            		<tr>
						<td><?php echo "Locker ".$row->LockerNumber; ?> </td>
						
						
					</tr>
          
				<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>
 		