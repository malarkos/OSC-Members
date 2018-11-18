<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );

/**
 * HelloWorldList Model
 *
 * @since 0.0.1
 */
class MembersModelMemberSubsPayment extends JModelList {
	
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return string An SQL query
	 */
	protected function getListQuery() {
		// Initialize variables.
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		
		// get values
		$jinput = JFactory::getApplication ()->input;
		
		$memid = $jinput->get ( 'memid', 0 );
		
		if ($memid != 0) { // check we have a valid value
		                   // Create the base select statement.
			$query->select ( '*' );
			$query->from ( 'members' );
			$query->where ( 'MemberID = ' . $memid );
		} else
			$query = null;
			
			// Filter: like / search
		
		return $query;
	}
	
	public function checkSubinFinances($memid,$fammemid,$memtype)
	{
	    // Function to check Sub has a corresponding finance entry
	    // return true if ok
	    // return false if not
	    $financetype = 's';
	    $creditdebit = 'D';
	    
	    // 
	    // if memtype == m check that an entry exists with s and D
	    
	    // if memtype == f or c, check entry exists with fammemid
	    
	    // if memtype == l, check entry exists with $fammemid being the locker id
	    
	    return true;
	}
	// function to return all details about a member
	public function getMemberDetails() {
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		
		// get values
		$jinput = JFactory::getApplication ()->input;
		$memid = $jinput->get ( 'memid', 0 );
		$memberdetails = array ();
		
		if ($memid != 0) { // check we have a valid value
			// Create the base select statement.
			$query->select ( '*' );
			$query->from ( 'members' );
			$query->where ( 'MemberID = ' . $memid );
			$db->setQuery ( $query );
			$db->execute ();
			
			$memberdetails = $db->loadObjectList ();
		}
		return $memberdetails;
	}
	// other calls
	public function getMemberSub() {
	    
	    
	    
	    
		// Initialize variables.
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		
		// get input values
		$app = JFactory::getApplication ();
		$jinput = JFactory::getApplication ()->input;
		$memid = $jinput->get ( 'memid', 0 );
		
		require_once JPATH_ADMINISTRATOR. '/components/com_subs/helpers/subs.php';
		
		$subsyear = SubsHelper::returnSubsYear();
		//$app->enqueueMessage('Subsyear  = '.$subsyear.';');
		
		if ($memid != 0) {
			// $app->enqueueMessage('MemberID = '.$memid.';');
			
			// get member type to get the correct subs rates
			$query->select ( 'MemberType' );
			$query->from ( 'members' );
			$query->where ( 'MemberID = ' . $memid );
			
			$db->setQuery ( $query );
			$db->execute ();
			$membertype = $db->loadResult ();
			
			// get if member is on Loa
			$query = $db->getQuery ( true );
			$query->select ( 'MemberLeaveofAbsence' );
			$query->from ( 'members' );
			$query->where ( 'MemberID = ' . $memid );
			
			$db->setQuery ( $query );
			$db->execute ();
			$memberloa = $db->loadResult ();
			// $app->enqueueMessage('Membertype = '. $membertype . ':');
			
			if ($memberloa == "No") {
				
				if ($membertype == "Life" || $membertype == "Hon Life") {
					// $app->enqueueMessage('In Life and Hon Life');
					$membersub = 0;
				} elseif ($membertype == "Graduate") {
					$query = $db->getQuery ( true );
					$query->select ( 'Graduate' );
					$query->from ( 'oscmemberrates' );
					$query->where ( 'Year = '.$db->q($subsyear) );
					$db->setQuery ( $query );
					$db->execute ();
					$membersub = $db->loadResult ();
					// $app->enqueueMessage('In graduate, membersub = ' . $membersub. ":");
				} elseif ($membertype == "Student") {
					$query = $db->getQuery ( true );
					$query->select ( 'Student' );
					$query->from ( 'oscmemberrates' );
					$query->where ( 'Year = '.$db->q($subsyear) );
					$db->setQuery ( $query );
					$db->execute ();
					$membersub = $db->loadResult ();
					// $app->enqueueMessage('In Student, membersub = ' . $membersub. ":");
				} else {
					$membersub = 0.00;
					// $app->enqueueMessage('No Member type specified');
				}
			} else {
				$membersub = 0.00;
			}
		} else {
			$app->enqueueMessage ( 'No MemID' );
			// $membersub = 0;
		}
		// $app->enqueueMessage('membersub = '. $membersub . ':');
		return $membersub;
	}
	
	public function getMemberSubPaid() {
		// Initialize variables.
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
	
		// get input values
		$app = JFactory::getApplication ();
		$jinput = JFactory::getApplication ()->input;
		$memid = $jinput->get ( 'memid', 0 );
	
		$membersubspaid="No"; // default value
		
		if ($memid != 0) {
			$query = $db->getQuery ( true );
			$query->select ( 'CurrentSubsPaid' );
			$query->from ( 'members' );
			$query->where ( 'MemberID = ' . $memid );
				
			$db->setQuery ( $query );
			$db->execute ();
			$membersubspaid = $db->loadResult ();
		}
		return $membersubspaid;
	}
	
	public function getFamilySubs() {
		$app = JFactory::getApplication ();
		
		$familysubs = array ();
		$jinput = JFactory::getApplication ()->input;
		
		$memid = $jinput->get ( 'memid', 0 );
		
		require_once JPATH_ADMINISTRATOR. '/components/com_subs/helpers/subs.php';
		
		$subsyear = SubsHelper::returnSubsYear();
		
		// Initialize variables.
		$db = JFactory::getDbo ();
		
		if ($memid != 0) {
			
			// get if member is on Loa
			$query = $db->getQuery ( true );
			$query->select ( 'MemberLeaveofAbsence' );
			$query->from ( 'members' );
			$query->where ( 'MemberID = ' . $memid );
			
			$db->setQuery ( $query );
			$db->execute ();
			$memberloa = $db->loadResult ();
			// $app->enqueueMessage('Membertype = '. $membertype . ':');
			
			if ($memberloa == "No") {
				
				
				$query = $db->getQuery ( true );
				
				$query->select ( '*,date_format(FamilyMemberBirthDate,\'%d %M %Y\') as FMBirthdate' );
				$query->from ( 'familymembers' );
				$query->where ( 'MemberID = ' . $memid . ' AND FamilyMembershipType in (\'Spouse\',\'Child\',\'Buddy\') ' );
				
				$db->setQuery ( $query );
				$db->execute ();
				$num_rows = $db->getNumRows ();
				$familysubs = $db->loadObjectList ();
				// $app->enqueueMessage('Familysubs = '. $familysubs . ':');
				
				// cycle through and add subs
				for($i = 0; $i < $num_rows; $i ++) {
					// get membership type
					$memtype = $familysubs [$i]->FamilyMembershipType;
					// $app->enqueueMessage('Familysubs = '. $memtype . ':');
					
					if ($memtype == "Spouse") {
						$query = $db->getQuery ( true );
						$query->select ( 'Spouse' );
						$query->from ( 'oscmemberrates' );
						$query->where ( 'Year = '.$db->q($subsyear) );
						$db->setQuery ( $query );
						$db->execute ();
						$famsub = $db->loadResult ();
						// $app->enqueueMessage('Fam subs value = '. $famsub . ':');
					}
					if ($memtype == "Child") {
						$query = $db->getQuery ( true );
						$query->select ( 'Child' );
						$query->from ( 'oscmemberrates' );
						$query->where ( 'Year = '.$db->q($subsyear) );
						$db->setQuery ( $query );
						$db->execute ();
						$famsub = $db->loadResult ();
						// $app->enqueueMessage('Fam subs value = '. $famsub . ':');
					}
					if ($memtype == "Buddy") {
						$query = $db->getQuery ( true );
						$query->select ( 'Spouse' );
						$query->from ( 'oscmemberrates' );
						$query->where ( 'Year = '.$db->q($subsyear) );
						$db->setQuery ( $query );
						$db->execute ();
						$famsub = $db->loadResult ();
						// $app->enqueueMessage('Fam subs value = '. $famsub . ':');
					}
					
					// append subs val to the array.
					$familysubs [$i]->Subsval = $famsub;
				}
			} // not on Loa
		} // no memid
		return $familysubs;
	}
	public function getLockerSubs() {
		$app = JFactory::getApplication ();
		
		$familysubs = array ();
		$jinput = JFactory::getApplication ()->input;
		
		$memid = $jinput->get ( 'memid', 0 );
		
		// Initialize variables.
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		
		require_once JPATH_ADMINISTRATOR. '/components/com_subs/helpers/subs.php';
		
		$subsyear = SubsHelper::returnSubsYear();
		
		if ($memid != 0) {
			// get if member is on Loa
			$query = $db->getQuery ( true );
			$query->select ( 'MemberLeaveofAbsence' );
			$query->from ( 'members' );
			$query->where ( 'MemberID = ' . $memid );
			
			$db->setQuery ( $query );
			$db->execute ();
			$memberloa = $db->loadResult ();
			// $app->enqueueMessage('Membertype = '. $membertype . ':');
			
			if ($memberloa == "No") {
				
				$query = $db->getQuery ( true );
				$query->select ( '*' );
				$query->from ( 'lockers' );
				$query->where ( 'MemberID = ' . $memid );
				
				$db->setQuery ( $query );
				$db->execute ();
				$num_rows = $db->getNumRows ();
				$lockerinfo = $db->loadObjectList ();
				
				for($i = 0; $i < $num_rows; $i ++) {
					$query = $db->getQuery ( true );
					$query->select ( 'Locker' );
					$query->from ( 'oscmemberrates' );
					$query->where ( 'Year = '.$db->q($subsyear) );
					$db->setQuery ( $query );
					$db->execute ();
					$lockerrate = $db->loadResult ();
					$lockerinfo [$i]->LockerRate = $lockerrate;
				}
			}
		}
		
		return $lockerinfo;
	}
	public function getCurrentBalance() {
		// Initialize variables.
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		
		// get input values
		$app = JFactory::getApplication ();
		$jinput = JFactory::getApplication ()->input;
		$memid = $jinput->get ( 'memid', 0 );
		
		if ($memid != 0) {
			// $app->enqueueMessage('MemberID = '.$memid.';');
			
			$query->select ( 'sum(Amount)' );
			$query->from ( 'finances' );
			$query->where ( 'MemberID = ' . $memid );
			$query->where ('TransactionDate < \'2016-12-01\''); // TODO get this from database.
			
			$db->setQuery ( $query );
			$db->execute ();
			$membertotal = $db->loadResult ();
			// $app->enqueueMessage('Membertotal = '. $membertotal . ':');
		} else {
			
			$membertotal = 0;
		}
		// $app->enqueueMessage('membersub = '. $membersub . ':');
		return $membertotal;
	}
	
	// Function to return any payments since 30 Nov
	public function getSubsPayments()
	{
		// Initialize variables.
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$subspayment = array ();
		// get input values
		$app = JFactory::getApplication ();
		$jinput = JFactory::getApplication ()->input;
		$memid = $jinput->get ( 'memid', 0 );
		//JFactory::getApplication()->enqueueMessage('Member id: '.$memid.':');
		if ($memid != 0) {
			
			$query = $db->getQuery ( true );
			$query->select ( '*,date_format(TransactionDate,\'%d %M %Y\') as Transdate' );
			$query->from ( 'finances' );
			$query->where ( 'MemberID = ' . $memid );
			$query->where ('TransactionDate > \'2016-11-30\''); // TODO get this from database.
			$query->where('CreditDebit = \'C\'');
			
			$db->setQuery ( $query );
			$db->execute ();
			$num_rows = $db->getNumRows ();
			//JFactory::getApplication()->enqueueMessage('Num rows = '.$num_rows);
			$subspayment = $db->loadObjectList ();
			
			
		} //if 
		
		return $subspayment;
		
	} // function
}