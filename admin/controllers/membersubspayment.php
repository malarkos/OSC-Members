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
 * HelloWorlds Controller
 *
 * @since  0.0.1
 */
class MembersControllerMemberSubsPayment extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  object  The model.
	 *
	 * @since   1.6
	 */
	public function getModel($name = 'MemberSubsPayment', $prefix = 'MembersModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
 
		return $model;
	}
	
	
	public function payonesub()
	{
	    require_once JPATH_ADMINISTRATOR. '/components/com_subs/helpers/subs.php';
	    $subsyear = SubsHelper::returnSubsYear();
	    
	    // Function to pay just one sub
	    //JFactory::getApplication()->enqueueMessage('Pay only one sub');
	    
	    $jinput = JFactory::getApplication ()->input;
	    $memberid = $jinput->get('MemberID');
	    $memid = $jinput->get('ID');
	    $memtype = $jinput->get('memtype');
	    $memtypelong = "";
	    JFactory::getApplication()->enqueueMessage('Memtype='.$memtype.':');
	    
	    if ($memtype == 'm' || $memtype == 'f') 
	    {
	        $memtypelong = SubsHelper::returnMemberType($memtype, $memid);
	        JFactory::getApplication()->enqueueMessage('Memtypelong ='.$memtypelong);
	        if ($memtypelong == "Graduate") $memtypeval = "m";
	        if ($memtypelong == "Student") $memtypeval = "s";
	        if ($memtypelong == "Spouse") $memtypeval = "f";
	        if ($memtypelong == "Child") $memtypeval = "c";
	        if ($memtypelong == "Buddy") 
	        {  
	            $memtypeval = "b";
	            $memtypelong = "Spouse"; // no separate buddy rate
	        }
	    }
	    
	    
	    /*if ($memtype == 'f') $memtypelong = "Spouse";
	    if ($memtype == 'c') $memtypelong = "Child";
	    if ($memtype == 'b') $memtypelong = "Buddy";*/
	    
	    if ($memtype == 'l') 
	    {
	        $memtypelong = "Locker";
	        $memtypeval = $memtype;
	    }
	    
	    $this->setRedirect(JRoute::_('index.php?option=com_members&view=membersubspayment&memid='.$memberid, false));
	    
	    //JFactory::getApplication()->enqueueMessage('Memtype='.$memtype.': memid = '.$memid);
	    
	    /*($returnurl = "";
	    if  (isset($refererURL))
	    {
	        $returnurl= $session->get( 'refererURL');
	        $this->setRedirect($returnurl);
	    }*/
	    
	    // set up db link
	    $db    =  JFactory::getDbo();
	    $query = $db->getQuery(true);
	    // check if already paid by checking current subs paid flag
	    
	    if ( SubsHelper::checkIfSubPaid($memtype,$memid) == 'No')
	    {
	        //JFactory::getApplication()->enqueueMessage('That sub has not been paid!');
	        
	        // Get sub rate
	        $amount = SubsHelper::returnSubrate($subsyear,$memtypelong);
	        $today=time();
	        $transactiondate = date("Y-m-d",$today);
	        $creditdebit = "C";
	        $comment= $subsyear . ' Subscriptions Payment';
	        $description = $comment;
	        $amountnogst = (10*$amount)/11;
	        $gst = $amount/11;
	        $membertype = $memtypeval;
	        $financetype = 's';
	        SubsHelper::addFinanceEntry($memberid,$transactiondate,$creditdebit,$amountnogst,$gst,$amount,$description,$comment,$financetype,$subsyear,$membertype,$memid);
	        SubsHelper::setCurrentSubsPaid($memid,"Yes",$memtype);
	        
	        return ;
	        
	    }
	    else if ( SubsHelper::checkIfSubPaid($memtype,$memid) == 'Yes')
	    {
	        JFactory::getApplication()->enqueueMessage('That sub has already been paid!');
	        return ;
	        
	    } else {
	        JFactory::getApplication()->enqueueMessage('An unknown error occurred.');
	        
	    }
	    
	    
	    return;
	}
	/*
	 * Function to update all Member subs to paid
	 */
	public function payall()
	{
	    require_once JPATH_ADMINISTRATOR. '/components/com_subs/helpers/subs.php';
	    $subsyear = SubsHelper::returnSubsYear();
	    
	    // function to set paid to Yes for all entries for that member
	    $totalowing = JRequest::getVar('totalowing', null, 'post', 'string');
	    $totalremain = JRequest::getVar('totalremain', null, 'post', 'string');
	    
	    // JFactory::getApplication()->enqueueMessage('Totalowing= '.$totalowing.':');
	    // JFactory::getApplication()->enqueueMessage('Total remain= '.$totalremain.':');
	  	// build return URL
		$jinput = JFactory::getApplication ()->input;
		$memid = $jinput->get ( 'memid', 0 );
		
		JFactory::getApplication()->enqueueMessage('In payall');
		
		if ($memid == 0) { // error not set
		    JFactory::getApplication()->enqueueMessage('Error: invalid member id');
		    return false;
		}
		
		// update member
		// Get the DB object
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		// Need to a subs entry if not already paid.
		$today=time();
		$transactiondate = date("Y-m-d",$today);
		$creditdebit = "C";
		$comment= $subsyear . ' Subscriptions Payment';
		$description = $comment;
		$amount = $totalowing;
		$amountnogst = (10*$amount)/11;
		$gst = $amount/11;
		$membertype = "m";
		$financetype = 's';
		SubsHelper::addFinanceEntry($memid,$transactiondate,$creditdebit,$amountnogst,$gst,$amount,$description,$comment,$financetype,$subsyear,$membertype,$memid);
		
		
		
		$subsvalue = 'Yes';
		$fields = array('CurrentSubsPaid = '. $db->quote($subsvalue));
		$conditions = array('MemberID = '. $memid );
		$query->update('members');
		$query->set($fields);
		$query->where($conditions);
		
		JFactory::getApplication()->enqueueMessage('query = '.$query);
		$db->setQuery($query);
		JFactory::getApplication()->enqueueMessage('Set query');
		try
		{
			$db->execute();
		}
		catch (RuntimeException $e)
		{
			$this->setError($e->getMessage());
			JFactory::getApplication()->enqueueMessage('Error = '.$e->getMessage());
			JFactory::getApplication()->enqueueMessage('execute failed');
			return false;
		}
		// update family members
		$query = $db->getQuery(true);
		$query->select ( '*' );
		$query->from ( 'familymembers' );
		$query->where ( 'MemberID = ' . $memid . ' AND FamilyMembershipType in (\'Spouse\',\'Child\',\'Buddy\') ' );
		JFactory::getApplication()->enqueueMessage('query = '.$query);
		$db->setQuery ( $query );
		$db->execute ();
		$num_rows = $db->getNumRows ();
		JFactory::getApplication()->enqueueMessage('Num rows = '.$num_rows);
		$familysubs = $db->loadObjectList ();
		// cycle through and add subs
		for($i = 0; $i < $num_rows; $i ++) {
			// get membership type
			$fammemid = $familysubs[$i]->FamilyMemberID;
			JFactory::getApplication()->enqueueMessage('fammemid = '.$fammemid);
			$query = $db->getQuery(true);
			
			$subsvalue = 'Yes';
			$fields = array('CurrentSubsPaid = '. $db->quote($subsvalue));
			$conditions = array('FamilyMemberID = '. $fammemid );
			$query->update('familymembers');
			$query->set($fields);
			$query->where($conditions);
			JFactory::getApplication()->enqueueMessage('query = '.$query);
			$db->setQuery ( $query );
			try
			{
				$db->execute();
			}
			catch (RuntimeException $e)
			{
				$this->setError($e->getMessage());
				JFactory::getApplication()->enqueueMessage('Error = '.$e->getMessage());
				JFactory::getApplication()->enqueueMessage('execute failed');
				return false;
			}
		}
		// update lockers
		$query = $db->getQuery ( true );
		$query->select ( '*' );
		$query->from ( 'lockers' );
		$query->where ( 'MemberID = ' . $memid );
		
		$db->setQuery ( $query );
		$db->execute ();
		$num_rows = $db->getNumRows ();
		$lockerinfo = $db->loadObjectList ();
		
		for($i = 0; $i < $num_rows; $i ++) {
			$lockerid = $lockerinfo[$i]->id;
			JFactory::getApplication()->enqueueMessage('lockerid = '.$lockerid);
			$query = $db->getQuery(true);
				
			$subsvalue = 'Yes';
			$fields = array('CurrentSubsPaid = '. $db->quote($subsvalue));
			$conditions = array('id = '. $lockerid );
			$query->update('lockers');
			$query->set($fields);
			$query->where($conditions);
			JFactory::getApplication()->enqueueMessage('query = '.$query);
			$db->setQuery ( $query );
			try
			{
				$db->execute();
			}
			catch (RuntimeException $e)
			{
				$this->setError($e->getMessage());
				JFactory::getApplication()->enqueueMessage('Error = '.$e->getMessage());
				JFactory::getApplication()->enqueueMessage('execute failed');
				return false;
			}
		}
		// Go back to subspayment
		$this->setRedirect(JRoute::_('index.php?option=com_members&view=membersubspayment&memid='.$memid, false));
		return;
	}
	
	/*
	 * Function to function to mark all subs paid 
	 */
	public function markallpaid()
	{
	    require_once JPATH_ADMINISTRATOR. '/components/com_subs/helpers/subs.php';
	    $subsyear = SubsHelper::returnSubsYear();
	    
	    
	    // Access database
	    $db    = JFactory::getDbo();
	    $query = $db->getQuery(true);
	    
	       
	    // JFactory::getApplication()->enqueueMessage('Totalowing= '.$totalowing.':');
	    // JFactory::getApplication()->enqueueMessage('Total remain= '.$totalremain.':');
	    // build return URL
	    $jinput = JFactory::getApplication ()->input;
	    $memid = $jinput->get ( 'memid', 0 );
	    $memtype = "m";
	    
	    JFactory::getApplication()->enqueueMessage('In markallpaid');
	    
	    if ($memid == 0) { // error not set
	        JFactory::getApplication()->enqueueMessage('Error: invalid member id');
	        return false;
	    }
	    
	    
	    // Set subs paid for member
	   
	    SubsHelper::setCurrentSubsPaid($memid,"Yes",$memtype);
	    
	    
	    // Set subs paid for family members
	    $query->select ( '*' );
	    $query->from ( 'familymembers' );
	    $query->where ( 'MemberID = ' . $memid . ' AND FamilyMembershipType in (\'Spouse\',\'Child\',\'Buddy\') ' );
	    JFactory::getApplication()->enqueueMessage('query = '.$query);
	    $db->setQuery ( $query );
	    $db->execute ();
	    $num_rows = $db->getNumRows ();
	    JFactory::getApplication()->enqueueMessage('Num rows = '.$num_rows);
	    $familysubs = $db->loadObjectList ();
	    // cycle through and add subs
	    for($i = 0; $i < $num_rows; $i ++) {
	        // get membership type
	        $fammemid = $familysubs[$i]->FamilyMemberID;
	        $memtype = "f";
	        SubsHelper::setCurrentSubsPaid($fammemid,"Yes",$memtype);
	    }
	    
	    // Set subs paid for lockers
	    
	    $query = $db->getQuery ( true );
	    $query->select ( '*' );
	    $query->from ( 'lockers' );
	    $query->where ( 'MemberID = ' . $memid );
	    
	    $db->setQuery ( $query );
	    $db->execute ();
	    $num_rows = $db->getNumRows ();
	    $lockerinfo = $db->loadObjectList ();
	    
	    for($i = 0; $i < $num_rows; $i ++) {
	        $lockerid = $lockerinfo[$i]->id;
	        JFactory::getApplication()->enqueueMessage('lockerid = '.$lockerid);
	        $memtype="l";
	        SubsHelper::setCurrentSubsPaid($lockerid,"Yes",$memtype);
	    }
	    // Go back to subspayment
	    $this->setRedirect(JRoute::_('index.php?option=com_members&view=membersubspayment&memid='.$memid, false));
	    return;
	    
	}//function
	/*
	 * Function to email payment receipt to member
	 */
	public function emailmember()
	
	{
		
		$jinput = JFactory::getApplication ()->input;
		
		
		$memid = $jinput->get ( 'memid', 0 );
		
		
		
		//JFactory::getApplication()->enqueueMessage($memid);
		//echo "email member";
		// variables
		
		
		// Model calls.
		$model = $this->getModel();
		$memberdetails = $model->getMemberDetails();
		$subspayments = $model->getSubsPayments();
		$familysubs = $model->getFamilySubs();
		$lockersubs = $model->getLockerSubs();
		//JFactory::getApplication()->enqueueMessage('subs payments called');
		
		// create mailer object
		$mailer = JFactory::getMailer();
		
		// Set sender
		$config = JFactory::getConfig();
		$sender = array(
				$config->get( 'mailfrom' ),
				$config->get( 'fromname' )
		);
		
		$mailer->setSender($sender);
		// add general@ormondskiclub.com.au as BCC
		$bccemail = $config->get( 'mailfrom' );
		//JFactory::getApplication()->enqueueMessage('BCC'.$bccemail);
		$mailer->addBcc($bccemail);
		// Set recipient - hard code for now but will need to look up
		$recipient = $memberdetails[0]->MemberEmail;
		//JFactory::getApplication()->enqueueMessage('Recipient'.$recipient);
		if (empty($recipient))  // can't email if don't have a valid email.
		{
			JError::raiseError(500,"Invalid email for member.");
			return;
		}
			
		
		$mailer->addRecipient($recipient);
		
		// Create email
		
		$body = "<h2>Ormond Ski Club Subs Tax Receipt</h2>"; // need to substitute with payment
		$body .= "Date: ".date("d M Y")."</br></br>";
		$body .= "Dear ".$memberdetails[0]->MemberFirstname.",";
		$body .= "</br></br>Thank you for your subs payment received as follows:</br></br>";
		
		
		if (!empty($subspayments)) {
			//JFactory::getApplication()->enqueueMessage('Payments available to display');
							$body .= "<table>";
							$body .= "<tr><th><b>Date</b></th><th><b>Amount</b></th></tr>";
											 foreach ($subspayments as $i => $row) {
											 	$body .= "<tr>";
											 	$body .= "<td>".$row->Transdate." </td>";
											 	$body .= "<td align=\"right\">$".$row->Amount." </td>";
											$body .= "</tr>";
											} //
							$body .= "</table>";
		} // if
		$body .= "</br></br>If you have any questions about your subs payments, please reply to this email.</br></br>";
		$body .= "Membership Officer</br>Ormond Ski Club</br>ABN: 75004765753</br>";
		$body .= "<A href=\"http://www.ormondskiclub.com.au\">www.ormondskiclub.com.au</a>";
		$mailer->isHTML(true);
		$mailer->Encoding='base64';
		$mailer->setSubject('Ormond Ski Club Subs payment receipt');
		$mailer->setBody($body);
		
		$send = $mailer->Send();
		if ($send !== true){
			JFactory::getApplication()->enqueueMessage('Error: Member emailed');
		}
		else
		{
			JFactory::getApplication()->enqueueMessage('Member emailed');
		}
		
		// Go back to member
		$this->setRedirect(JRoute::_('index.php?option=com_members&view=membersubspayment&memid='.$memid, false));
		
		return;
	} // email member
	
	public function addFinanceEntry()
	{
	    $db    = JFactory::getDbo();
	    // Function to call class in Finance entry
	    $memid = JRequest::getVar('memid', null, 'post', 'string');
	    
	    JFactory::getApplication()->enqueueMessage('In Add Finance Entry, memid = '.$memid.':');
	    
	    $financeeditURL = 'index.php?option=com_subs&view=financeentry&layout=edit&memid='.$memid;
	    
	    
	    $this->setRedirect(JRoute::_($financeeditURL,false));
	    
	    //JRoute::($menuitem->link.'&Itemid='.$itemid, false)
	    
	    // Set return value
	    $returnstring = "index.php?option=com_members&view=membersubspayment&memid=".$memid;
	   
	   // $this->setRedirect(JRoute::_('index.php?option=com_members&view=membersubspayment&memid='.$memid, false));
	   
	    // access edit function in finance entry
	    
	   
	    
	    return;
	}
}