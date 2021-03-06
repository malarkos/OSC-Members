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
 * HelloWorldList Model
 *
 * @since  0.0.1
 */
class MembersModelMemberWorkParties extends JModelList
{
    
        
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return      string  An SQL query
	 */
	protected function getListQuery()
	{
		// Initialize variables.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		// get values
		$jinput = JFactory::getApplication()->input;
		
		$memid = $jinput->get('memid',0);
 
		if ($memid != 0) { // check we have a valid value
			// Create the base select statement.
			$query->select('*');
			$query->from('workparty');
			$query->where('MemberID = ' . $memid);
		}
		else 
			$query = null;
		
                // Filter: like / search
		
		return $query;
	}
	
	// Function to return subs start date for the year
	
	public function getWorkPartyTotal()
	{
	    
	    $workpartytotal = 0;  
	    
	    // Initialize variables.
	    $db    = JFactory::getDbo();
	    $query = $db->getQuery(true);
	    
	    // get values
	    $jinput = JFactory::getApplication()->input;
	    
	    $memid = $jinput->get('memid',0);
	    
	    if ($memid != 0) {
    	    $query = $db->getQuery ( true );
    	    $query->select ( 'sum(WorkPartyDats) as totalworkparty' );
    	    $query->from('workparty');
    	    $query->where('MemberID = ' . $memid);
    	    $db->setQuery ( $query );
    	    $workpartytotal = $db->loadResult();
	    }
	    
	    return ($workpartytotal);
	}
	
	public function getMemberName()
	{
	    
	    $membername = "Harry";
	    
	    // Initialize variables.
	    $db    = JFactory::getDbo();
	    $query = $db->getQuery(true);
	    
	    // get values
	    $jinput = JFactory::getApplication()->input;
	    
	    $memid = $jinput->get('memid',0);
	    
	    if ($memid != 0) {
	        $query = $db->getQuery ( true );
	        $query->select ( 'concat(m.MemberFirstname,\' \',m.MemberSurname) as membername' );
	        $query->from('members AS m');
	        $query->where('MemberID = ' . $memid);
	        $db->setQuery ( $query );
	        $membername = $db->loadResult();
	    }
	    
	    return ($membername);
	}
	//override default list
	protected function populateState($ordering = null, $direction = null)
	{
	    // Initialise variables.
	    $app = JFactory::getApplication();
	    
	    // List state information
	    $limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->get('list_limit'));
	    
	    $limit = 2000;  // set list limit
	    
	    
	}
}