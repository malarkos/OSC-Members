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
<A href="<?php echo JRoute::_('index.php?option=com_members&view=members&layout=edit'); ?>">Update details</A>
<table class="table table-striped table-hover">
	<tbody>
		<tr>
			<td>Member:</td>
			<td><?php echo $this->data->MemberFirstname; ?> <?php echo $this->data->MemberSurname; ?></td>
		</tr>
		<tr>
			<td>Member Type:</td>
			<td><?php echo $this->data->MemberType; ?> </td>
		</tr>
		<tr>
			<td>Email:</td>
			<td><?php echo $this->data->useremail; ?> (Edit in 
			<A href="<?php $url = Uri::root() . 'index.php/your-profile'; echo $url; ?>">Your Profile</A>)</td>
		</tr>
		<tr>
			<td>Address:</td>
			<td><?php echo $this->data->MemberHomeAddress; ?>, <?php echo $this->data->MemberHomeAddress2; ?><br />
			<?php echo $this->data->MemberHomeSuburb; ?><br />
			<?php echo $this->data->MemberHomeState; ?> <?php echo $this->data->MemberHomePostcode; ?>
			 </td>
		</tr>
		<tr>
			<td >Mobile:</td>
			<td ><?php echo $this->data->MemberPhoneMobile; ?> </td>
		</tr>
		<tr>
			<td >Home:</td>
			<td ><?php echo $this->data->MemberPhoneHome; ?> </td>
		</tr>
		<tr>
			<td >Work:</td>
			<td ><?php echo $this->data->MemberPhoneWork; ?> </td>
		</tr>
		<tr>
			<td >Date of Birth:</td>
			<td ><?php echo $this->data->MemberBirthDate; ?> </td>
		</tr>
	</tbody>
</table>
 		