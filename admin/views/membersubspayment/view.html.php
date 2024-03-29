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
 
/**
 * Members View
 *
 * @since  0.0.1
 */
class MembersViewMemberSubsPayment extends JViewLegacy
{
	/**
	 * Display the Hello World view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 */
	function display($tpl = null)
	{
		// Get application
		$app = JFactory::getApplication();
		//$context = "members.list.admin.members";
		// Get data from the model
		$this->items		= $this->get('Items');
		$this->membersubs 	=$this->get('MemberSub');
		$this->membersubspaid = $this->get('MemberSubPaid');
		$this->familysubs 	= $this->get('FamilySubs');
		$this->lockersubs 	= $this->get('LockerSubs');
		$this->subspayments = $this->get('SubsPayments');
		$this->currentbalance = $this->get('CurrentBalance');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');
		// Get filter form.
		//$this->filterForm = $this->get('FilterForm');
		
		// Get active filters.
		//$this->activeFilters = $this->get('ActiveFilters');
		
 
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
 
			return false;
		}
		
		// Set the toolbar
		$this->addToolBar();
 
		// Display the template
		parent::display($tpl);
		

	}
	
		/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function addToolBar()
	{
		
		//if ($this->pagination->total)
		//	$title .= "<span style='font-size: 0.5em; vertical-align: middle;'>(" . $this->pagination->total . ")</span>";
		//}
		
		JToolBarHelper::title(JText::_('COM_MEMBERS_MEMBER_SUBS_PAYMENT'));
		JToolBarHelper::custom('membersubspayment.payall','','','Pay All',false);
		JToolBarHelper::custom('membersubspayment.markallpaid','','','Mark All Paid',false);
		JToolBarHelper::custom('membersubspayment.addFinanceEntry','','','Add Payment',false);
		//JToolbarHelper::custom('users.unblock', 'unblock.png', 'unblock_f2.png', 'COM_USERS_TOOLBAR_UNBLOCK', true);
		//JToolBarHelper::custom('printreceipt','','','Print Receipt',false);
		//JToolBarHelper::addNew('memberworkparty.add');
		//JToolBarHelper::editList('memberworkparty.edit');
		
	}
	
}