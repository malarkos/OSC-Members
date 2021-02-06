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
	<?php $total = 0;?>
	<thead>
	<th>Item	</th>
	<th> Amount </th>
	<th> Total </th>
	
	</thead>
	<tbody>
	<tr>
	<td>Balance as at 01 Dec 2020</td>
	<td><?php echo $this->balance;?></td>
	<td><?php $total += $this->balance; echo money_format('%.2n', $total);?></td>
	</tr>
		<tr>
			<td><?php echo $this->membersub->membersubdescription;?></td>
			<td><?php echo $this->membersub->membersubamount;?></td>
			<td><?php $total-= $this->membersub->membersubamount;echo money_format('%.2n', $total);?></td>
	
			
		</tr>
		<tr>
			<td><?php echo $this->familysubs->membersubdescription;?></td>
			<td><?php echo $this->familysubs->membersubamount;?></td>
			<td><?php $total-= $this->familysubs->membersubamount;echo money_format('%.2n', $total);?></td>
	
			
		</tr>
		<tr>
			<td><?php echo $this->lockers->lockerdescription;?></td>
			<td><?php echo $this->lockers->lockeramount;?></td>
			<td><?php $total-= $this->lockers->lockeramount;echo money_format('%.2n', $total);?></td>
	
			
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
 		
 	