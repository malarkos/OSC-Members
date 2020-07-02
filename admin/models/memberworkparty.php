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
 * Member Model
 *
 * @since  0.0.1
 */
class MembersModelMemberWorkParty extends JModelAdmin
{
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
	public function getTable($type = 'MemberWorkParty', $prefix = 'MembersTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
 
	/**
	 * Method to get the record form.
	 *
	 * @param   array    $data      Data for the form.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  mixed    A JForm object on success, false on failure
	 *
	 * @since   1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm(
			'com_members.member',
			'memberworkparty',
			array(
				'control' => 'jform',
				'load_data' => $loadData
			)
		);
 
		if (empty($form))
		{
			return false;
		}
 
		return $form;
	}
 
	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return  mixed  The data for the form.
	 *
	 * @since   1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState(
			'com_members.edit.memberworkparty.data',
			array()
		);
 
		if (empty($data))
		{
			$data = $this->getItem();
		}
 
		return $data;
	}
	
	protected function prepareTable($table)
	{
	
		$user = JFactory::getUser();
		$modname = $user->name;
	
		$table->lastModifiedby = $modname;
		
		    
	    $table->oldMemberID = $table->MemberID;
	    $table->WorkPartyDays = $table->WorkPartyDats;
		
	
	}
	
	public function delete(&$pks) {
	    
	    //JFactory::getApplication()->enqueueMessage('In Member Work party delete with pks'.$pks);
	    
	    // check have a valid entry
	    if ($pks > 0) {
	        
	    // Set MemberID = 0
    	    $db = JFactory::getDbo();
    	    $query = $db->getQuery ( true );
    	    $fields = array('MemberID = 0');
    	    $conditions = array( 'WorkPartyID = ' . $pks  );
    	    $query->update('workparty');
    	    $query->set($fields);
    	    $query->where($conditions);
    	    
    	    $db->setQuery ( $query );
    	    $result = $db->execute ();
    	    
    	    // Get Work party ID$query = $db->getQuery ( true );
    	    $query = $db->getQuery ( true );
    	    $query->select ( 'WorkPartyRefID' );
    	    $query->from ( 'workparty' );
    	    $query->where ( 'WorkPartyID = ' . $pks );
    	    $db->setQuery ( $query );
    	    
    	    $wpid = $db->loadResult();
    	    if ($wpid > 0) { // have a valid wpid
    	        
    	        // Get number of attendees
    	        $query = $db->getQuery ( true );
    	        $query->select ( 'numattendees' );
    	        $query->from ( 'oscworkparty' );
    	        $query->where ( 'id = ' . $wpid );
    	        $db->setQuery ( $query );
    	        
    	        $numattendees = $db->loadResult();
    	        //JFactory::getApplication()->enqueueMessage('Num attendees = '.$numattendees);
    	        if ($numattendees > 0) {
    	            $numattendees--;  //Only decrement if greater than zero!
    	        }
    	        
    	        $query = $db->getQuery ( true );
    	        $fields = array('numattendees = '.$numattendees);
    	        $conditions = array( 'id = ' . $wpid  );
    	        $query->update('oscworkparty');
    	        $query->set($fields);
    	        $query->where($conditions);
    	        
    	        $db->setQuery ( $query );
    	        $result = $db->execute ();
    	        
    	    }
    	    
    	    return true;
	    }
	    else 
	        return false;
	    
	    
	}
}