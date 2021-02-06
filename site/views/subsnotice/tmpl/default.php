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
	
	<thead>
	<th>Item	</th>
	<th> Amount </th>
	
	</thead>
	<tbody>
	<tr>
	<td>Balance as at 01 Dec 2020</td>
	<td>$000</td>
	</tr>
		<tr>
			<td><?php echo $this->membersub->membersubdescription;?></td>
			<td><?php echo $this->membersub->membersubamount;?></td>
	
			
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
 		
 	