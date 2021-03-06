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
class MembersViewMembers extends JViewLegacy
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
		
		$this->data	            = $this->get('Data'); // get membership data
		$this->lockers          = $this->get('Lockers');
		$this->form	            = $this->get('Form');
		$this->state            = $this->get('State');
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
	
	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function addToolBar()
	{
		$input = JFactory::getApplication()->input;
 
		// Add whatever buttons you require
		JToolBarHelper::save('members.save');
		JToolBarHelper::divider();
		JToolBarHelper::cancel('members.cancel');
		
		
	}
}