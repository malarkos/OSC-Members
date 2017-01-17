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
class MembersModelMembers extends JModelList
{
    /**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @see     JController
	 * @since   1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id',
				'MemberFirstname',
				'MemberSurname'
                                );
		}
 
		parent::__construct($config);
	}
        
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
 
		// Create the base select statement.
		$query->select('*');
        $query->from('oscmembers');
                
        // Filter: like / search
		$search = $this->getState('filter.search');
		//JFactory::getApplication()->enqueueMessage('In model');
		if (!empty($search))
		{
			//JFactory::getApplication()->enqueueMessage('In search');
			$like = $db->quote('%' . $search . '%');
			$query->where('MemberSurname LIKE ' . $like.' OR MemberType LIKE '.$like.' OR MemberFirstname LIKE '.$like);
		}
 
		/*if (!empty($loamemberfilter))
		{
			
			$query->where('MemberLeaveofAbsence = '.$loamemberfilter);
		}*/
		
		
		
		// hacks for subs printing. to be replaced by proper filters
		//$query->where('MemberLeaveofAbsence = \'No\'');
		//$query->where('MemberType IN (\'Graduate\',\'Student\',\'Life\',\'Hon Life\')');
		// end hacks
		
 		$orderCol	= $this->state->get('list.ordering', 'id');
		$orderDirn 	= $this->state->get('list.direction', 'asc');
 
		$query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));
		return $query;
	}
	
	//override default list
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication();
	
		// List state information
		$limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->get('list_limit'));
	
		$limit = 2000;  // set list limit
		
		// set filters
		$value = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $value);
		
		parent::populateState('id', 'asc');
	
	}
}