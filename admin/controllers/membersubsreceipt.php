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
class MembersControllerMemberSubsReceipt extends JControllerAdmin
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
	public function getModel($name = 'MemberSubsReceipt', $prefix = 'MembersModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
 
		return $model;
	}
	
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
		$this->setRedirect(JRoute::_('index.php?option=com_members&view=membersubsreceipt&memid='.$memid, false));
		
		return;
	} // email member
	
	public function printreceipt()
	
	{
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
	
		JFactory::getApplication()->enqueueMessage('In printreceipt');
		
		return;
	} // email member
}