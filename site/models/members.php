<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * HelloWorld Model
 *
 * @since  0.0.1
*/
class MembersModelMembers extends JModelForm
{
	/**
	 * @var string message
	 */
	protected $data;

	/**
	 * Method to get a table object, load it if necessary.
	 *
	 * @param   string  $type    The table name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JTable  A JTable object
	 *
	 * @since   1.6
	 */
	public function getTable($type = 'Members', $prefix = 'MembersTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	
	
	/**
	 * Get the message
	 *
	 * @return  string  The message to be displayed to the user
	 */
	public function getData()
	{
		
		// returns information from oscmembers database to the view.

		// Get logged in user info
		$user = JFactory::getUser();
		$userName = $user->name;		
		$useremail = $user->email;
		
		
		$db    = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		$query->select('*');
		$query->from('oscmembers');
		$query->where('memberemail = '.$db->quote($useremail));
		
		$db->setQuery($query);
		
		try  // ensure in a try block for any errors.
		{
			//$row = $db->loadAssoc();
			$row = $db->loadObject();
		}
		catch (RuntimeException $e)
		{
			$this->setError(JText::sprintf('COM_MEMBERS_DATABASE_ERROR', $e->getMessage()), 500);
		
			return false;
		}
		
		
		$this->data = $row; // assign data to return object
		$this->data->username = $userName; // save username and email
		$this->data->useremail = $useremail;
		
		return $this->data;
	} // getData
	
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_members.members', 'members', array('control' => 'jform', 'load_data' => $loadData));
	
		if (empty($form))
		{
			return false;
		}
		
		// return form variable
		return $form;
	} // getForm
	
	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return  mixed  The data for the form.
	 *
	 * @since   1.6
	 */
	protected function loadFormData()
	{
		$data = $this->getData();
	
		$this->preprocessData('com_members.members', $data);
	
		return $data;
	} // loadFormData
	
	 /*
	 * Method to save the form data.
	 *
	 * @param   array  $data  The form data.
	 *
	 * @return  mixed  The user id on success, false on failure.
	 *
	 * @since   1.6
	 */
	public function save($data)
	{
	    
	    JFactory::getApplication()->enqueueMessage('In model save:');
	    
		// get the table
		$table = $this->getTable('Members');
		
		// save the data
		if (!$table->save( $data )) {
			return false;
		}
		
		// need to update email and login id if email address has changed
		
		//if (!$this->store()) {
		//	return false;
		//}
		
		/* $db = $this->getDbo();
		$query = $db->getQuery(true);
		
		$memid = 351;
		//$firstname = $data->MemberFirstname;
		$firstname = $data['MemberFirstname'];
		//$firstname='Geoffrey';
		
		//$query->update($db->quoteName('oscmembers'))
		//->set($db->quoteName('MemberFirstname') . ' = ' . $db->quoteName($firstname))
		//->where($db->quoteName('id') . ' = ' . $db->quoteName($memid));
		//->where('id = ' . $memid);
		
		// Create the base update statement.
		$query->update('oscmembers')->set('MemberFirstname = ' . $firstname)->where('id = ' . $memid);
		
		// Set the query and execute the update.
		$db->setQuery($query);
		
		try
		{
			$db->execute();
		}
		catch (RuntimeException $e)
		{
			JError::raiseWarning(500, $e->getMessage());
		
			return false;
		}
		*/
		return true;
		
	} // save 
	
}