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
class MembersModelMemberFamilies extends JModelList
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
					'FamilyMemberID','f.FamilyMemberID',
					'MemberID','f.MemberID',
					'FamilyMemberFirstname','f.FamilyMemberFirstname',
					'FamilyMemberSurname','f.FamilyMemberSurname',
					'FamilyMembershipType','f.FamilyMembershipType'
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
		
		$jinput = JFactory::getApplication ()->input;
		$memid = $jinput->get ( 'memid', 0 );
		
 
		// Create the base select statement.
		$query->select('f.*,concat(m.memberfirstname," ",m.membersurname) as membername'); //,sum(w.WorkPartyDays) as wpdays');
        $query->from('familymembers as f');
        $query->leftJoin('members as m on f.MemberID = m.MemberID');
        //$query->leftJoin('familyworkparty as w on f.FamilyMemberID = w.FamilyMemberID');
        // Filter: like / search
		$search = $this->getState('filter.search');
		//JFactory::getApplication()->enqueueMessage('In model');
		if (!empty($search))
		{
			//JFactory::getApplication()->enqueueMessage('In search');
			$like = $db->quote('%' . $search . '%');
			$query->where('FamilyMemberSurname LIKE ' . $like.' OR FamilyMemberFirstname LIKE '.$like);
		}
 
		
		// Filter by family member
		$familymember = $this->getState('filter.familymember');
		if (is_numeric($familymember))
		{
			$query->where('f.FamilyMemberID = '.(int) $familymember);
		}
		
		// Filter by  member
		$member = $this->getState('filter.member');
		if (is_numeric($member))
		{
			$query->where('f.MemberID = '.(int) $member);
		}
		// filter by family membership type
		$membertype = $this->getState('filter.familymembertype');
		if (!empty($membertype)) {
			$query->where('f.FamilyMembershipType = \''.$db->escape($membertype).'\'');
		}
		
		// filter by specific member
		if($memid <> 0)
		 {
		 	$query->where('f.MemberID = '.$memid);
		 	$this->setState('filter.member', $memid);
		 }
 		
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
		
		$familymember = $app->getUserStateFromRequest($this->context . 'filter.familymember', 'filter_familymember', '', 'string');
		$this->setState('filter.familymember', $familymember);
		
		$member = $app->getUserStateFromRequest($this->context . 'filter.member', 'filter_member', '', 'string');
		$this->setState('filter.member', $member);
		
		$membertype = $app->getUserStateFromRequest($this->context . 'filter.familymembertype', 'filter_familymembertype', '', 'string');
		$this->setState('filter.familymembertype', $membertype);
		
		
		parent::populateState('m.FamilyMemberID', 'asc');
	
	}
}