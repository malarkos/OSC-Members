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
 *  10 Nov - add Getting of subs year
 */
class MembersViewMemberSubsNotice extends JViewLegacy
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
		$this->membersubs 	= $this->get('MemberSub');
		$this->subsyear     = $this->get('SubsDates');  
		$this->subsduedate  = $this->get('SubsDueDate');
		$this->subsstartdate = $this->get('SubsStartDate');
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
		
		JToolBarHelper::title(JText::_('COM_MEMBERS_MEMBER_SUBS_NOTICE'));
		//JToolBarHelper::addNew('memberworkparty.add');
		//JToolBarHelper::editList('memberworkparty.edit');
		
	}
	
}