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
				'MemberID','m.MemberID',
				'MemberFirstname','m.MemberFirstname',
				'MemberSurname','m.MemberSurname',
				'MemberLeaveofAbsence','m.MemberLeaveofAbsence'	
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
		$query->select('m.*, count(LockerNumber) as lockercount,count(FamilyMemberID) as familycount,u.name as joomlauser');
        $query->from('members as m');
        $query->leftJoin('lockers as l on m.MemberID = l.MemberID');
        $query->leftJoin('familymembers as f on m.MemberID = f.MemberID');
        $query->leftJoin('#__users as u on m.joomlauserid = u.id');
        $query->group('m.MemberID');
        /*$query->where ('MemberType = \'Graduate\' ');
        $query->leftJoin('workparty AS w ON m.MemberID = w.MemberId');
        $query->order('MemberJoiningDate ASC');
        $query->group('m.MemberID');*/
                
        // Filter: like / search
		$search = $this->getState('filter.search');
		//JFactory::getApplication()->enqueueMessage('In model');
		if (!empty($search))
		{
			//JFactory::getApplication()->enqueueMessage('In search');
			$like = $db->quote('%' . $search . '%');
			$query->where('MemberSurname LIKE ' . $like.' OR MemberFirstname LIKE '.$like);
		}
 
		
		// Filter by member
		$member = $this->getState('filter.member');
		if (is_numeric($member))
		{
			$query->where('m.MemberID = '.(int) $member);
		}
		
		$membertype = $this->getState('filter.membertype');
		if (!empty($membertype)) {
			$query->where('m.MemberType = \''.$db->escape($membertype).'\'');
		}
		// Filter by memberLoA
		$memberloa = $this->getState('filter.memberloa');
		if (!empty($memberloa)) {
			$query->where('m.MemberLeaveofAbsence = \''.$db->escape($memberloa).'\'');
		}
		
 		/*$orderCol	= $this->state->get('list.ordering', 'm.MemberID');
		$orderDirn 	= $this->state->get('list.direction', 'asc');
 
		$query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));*/
		
		
		
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
		
		$member = $app->getUserStateFromRequest($this->context . 'filter.member', 'filter_member', '', 'string');
		$this->setState('filter.member', $member);
		$membertype = $app->getUserStateFromRequest($this->context . 'filter.membertype', 'filter_membertype', '', 'string');
		$this->setState('filter.membertype', $membertype);
		
		$memberloa = $app->getUserStateFromRequest($this->context . 'filter.memberloa', 'filter_memberloa', '', 'string');
		$this->setState('filter.memberloa', $memberloa);
		
		parent::populateState('m.MemberID', 'asc');
	
	}
}