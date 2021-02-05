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
class MembersModelWorkParties extends JModelForm
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
	public function getTable($type = 'WorkParties', $prefix = 'MembersTable', $config = array())
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

	      // update to use Joomla id
		// Get logged in user info
		
	    // TODO - update
	    $db    = JFactory::getDBO();
	    $query = $db->getQuery(true);
	    
		$user = JFactory::getUser();
	
	    // Get joomlaid
		$userjoomlaid = $user->id;
		
		// get memberid
		$query->select('MemberID');
		$query->from('members');
		$query->where('joomlauserid = '.$db->quote($userjoomlaid));
		
		$db->setQuery($query);
		
		$db->execute ();
		$memberid = $db->loadResult ();
		
		// TODO code if memberid is invalid
		$app = JFactory::getApplication ();
		//$app->enqueueMessage('Memberid = '. $memberid . ':');
		// get family members
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from('workparty');
		$query->where('MemberID = '.$db->quote($memberid));
		
		
		//$app->enqueueMessage('Query = '. $query . ':');
		$db->setQuery ( $query );
		$db->execute ();
		$num_rows = $db->getNumRows();
		
		try  // ensure in a try block for any errors.
		{
			//$row = $db->loadAssoc();
			$row = $db->loadObjectList();
			
			//$app->enqueueMessage('Num rows = '. $num_rows . ':');
		}
		catch (RuntimeException $e)
		{
			$this->setError(JText::sprintf('COM_MEMBERS_DATABASE_ERROR', $e->getMessage()), 500);
		
			return false;
		}
		
		
		$this->data = $row; // assign data to return object
		
		
		return $this->data;
	} // getData
	
	
	
	
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_members.members', 'workparties', array('control' => 'jform', 'load_data' => $loadData));
	
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
	
		$this->preprocessData('com_members.workparties', $data);
	
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
	    
	    //JFactory::getApplication()->enqueueMessage('In model save:');
	    
		// get the table
		$table = $this->getTable('WorkParties');
		
		// save the data
		if (!$table->save( $data )) {
			return false;
		}
		
		
		return true;
		
	} // save 
	
}