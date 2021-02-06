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
 * HTML View class for the HelloWorld Component
 *
 * @since  0.0.1
*/
class MembersViewSubsNotice extends JViewLegacy
{
	
	protected $data;

	protected $form;

	//protected $params;

	protected $state;
	
	
	/**
	 * Display the Hello World view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 */
	function display($tpl = null)
	{
		// Assign data to the view
		
		//$this->data	            = $this->get('Data'); // get membership data
		
		$this->balance        = $this->get('Balance');
		$this->membersub      = $this->get('MemberSub');
		$this->familysubs     = $this->get('FamilySubs');
		$this->lockers        = $this->get('Lockers');
		
		//$this->assignRef( 'data', $data);  // assign to variable
		//$this->userName = $data->username;
		//$this->useremail = $data->useremail;
		//$this->useraddress = $data->useraddress;
		//$this->mobilephone = $data->mobilephone;
		//$this->workphone = $data->workphone;
	    //$this->homephone = $data->homephone;
	    //$this->membertype = $data->membertype;
	    
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');
		
			return false;
		}
		
		//$input->set('hidemainmenu', true);
		// Set the toolbar
		//$this->addToolBar();
		
		// Display the view
		parent::display($tpl);
	}
	
	
}