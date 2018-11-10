<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_bookingadmin
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Users component helper.
 *
 * @since  1.6
 */
class BookingsHelper
{
    protected  $debugVal = 1;  // default debug value
    /*
     * 
     */
    
    public function displayMessage($str)
    {
        if ($debugVal == 1)
            JFactory::getApplication()->enqueueMessage($str);
    }
    
    /*
     *  Function to calculate work party discount for members and family members
     */
    
    public  function workpartyDiscount($memtype,$memid) 
    {
        JFactory::getApplication()->enqueueMessage('WorkParty discount  = '.$memtype.$memid);
        $db = JFactory::getDbo ();
        
        $wpdays = 0;
        if ($memtype == "b" || $memtype == "g")  // buddy or guest, doesn't qualify for discount
        {
            return 0;
        }
        if ($memtype == "m")
        {
            $query = $db->getQuery ( true );
           
            $query->select ( 'sum(WorkPartyDats) as wpdays' );
            $query->from ( 'workparty' );
            $query->where ( 'memberid = ' . $memid );
            $db->setQuery ( $query );
            $wpdays = $db->loadResult();
        }
        if ($memtype == "f")
        {
            $query = $db->getQuery ( true );
            $query->select ( 'sum(WorkPartyDays) as wpdays' );
            $query->from ( 'familyworkparty' );
            $query->where ( 'familymemberid = ' . $memid );
            $db->setQuery ( $query );
            $wpdays = $db->loadResult();
        }
        
        JFactory::getApplication()->enqueueMessage('WorkParty discount  = '.$wpdays);
        if ($wpdays < 20) $wpdisc = 0;
        else if ($wpdays < 40) $wpdisc = 20;
        else if ($wpdays < 60) $wpdisc = 30;
        else if ($wpdays < 80) $wpdisc = 40;
        else if ($wpdays < 100) $wpdisc = 50;
        else if ($wpdays < 120) $wpdisc = 60;
        else if ($wpdays < 140) $wpdisc = 70;
        else $wpdisc = 80;
        
        return $wpdisc;
        
    } // function
	/*
	 * Function to take the datein, dateout and age to calculate booking cost
	 */
	public static function bookingCost($datein, $dateout, $age, $memguest,$memberval,$fammemberval)
	{
	    //return '250';
	    
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		JFactory::getApplication()->enqueueMessage('Values  = '.$datein->format('Y-m-d H:i:s').$dateout->format('Y-m-d H:i:s'));
		// Calculate work party discount
		$bookingcost = 0;
		$wpdisc = 1;
		$year = '2018'; // update to select current year
		// get rates
		$query->select ( '*' );
		$query->from ( 'oscwinterrates' );
		$query->where ( 'Year = ' . $year );
		$db->setQuery ( $query );
		$result = $db->loadObject();
		$start_peak = $result->start_peak;
		$stop_peak = $result->stop_peak;
		//$start_peakval  = DateTime::createFromFormat('Y-m-d', $start_peak);
		//$stop_peakval  = DateTime::createFromFormat('Y-m-d', $stop_peak);
		//$start_peakval= date('Y-m-d',strtotime($start_peak));
		//$stop_peakval = date('Y-m-d', strtotime($stop_peak));
		$start_peakval  = DateTime::createFromFormat('Y-m-d', $start_peak);
		$stop_peakval  = DateTime::createFromFormat('Y-m-d', $stop_peak);
		$mwp0 = $result->mwp0;$mwp1 = $result->mwp1;$mwp2 = $result->mwp2;$mwp3 = $result->mwp3;
		$mwo0 = $result->mwo0;$mwo1 = $result->mwo1;$mwo2 = $result->mwo2;$mwo3 = $result->mwo3;
		$mep0 = $result->mep0;$mep1 = $result->mep1;$mep2 = $result->mep2;$mep3 = $result->mep3;
		$meo0 = $result->meo0;$meo1 = $result->meo1;$meo2 = $result->meo2;$meo3 = $result->meo3;
		$gwp0 = $result->gwp0;$gwp1 = $result->gwp1;$gwp2 = $result->gwp2;$gwp3 = $result->gwp3;
		$gwo0 = $result->gwo0;$gwo1 = $result->gwo1;$gwo2 = $result->gwo2;$gwo3 = $result->gwo3;
		$gep0 = $result->gep0;$gep1 = $result->gep1;$gep2 = $result->gep2;$gep3 = $result->gep3;
		$geo0 = $result->geo0;$geo1 = $result->geo1;$geo2 = $result->geo2;$geo3 = $result->geo3;
		// set buddy or guest
		$memberguest = 'm'; // default to member if not set
		if ($memguest == 'm' || $memguest == 'f' || $memguest == 'b') {
			$memberguest = 'm';
		} else if ($memguest == 'g'){
			$memberguest = 'g';
		}
		// set ageval
		$guestage = '3'; // default to 26+ if not set properly
		if ($age == '26+') {
			$guestage = '3';
		} else if ($age == '18-25') 
		{
			$guestage = '2';
		} else if ($age == '3-17') {
			$guestage = '1';
		} else if ($age == '0-2') {
			$guestage = '0';
		}
		JFactory::getApplication()->enqueueMessage('Start and stop peak dates = '.$start_peakval->format('Y-m-d').' '.$stop_peakval->format('Y-m-d'));
		$dateval = $datein;
		//JFactory::getApplication()->enqueueMessage('dateval  = '.$dateval->format('Y-m-d'));
		$i=0;
		$interval = DateInterval::createfromdatestring('+1 day');
		while ($dateval < $dateout) {
		    JFactory::getApplication()->enqueueMessage('dateval  = '.$dateval->format('Y-m-d'));
			// need to create lookup value  format is $memberguest.$week.$peak.$guestage
			
			// get day of $dateval  Sun->Thu is week w, Fri, Sat is weekend -e 
			$dayofweek = date_format($dateval,"D");
			
			$weekday = 'w'; // default to week
			if ($dayofweek == 'Fri' || $dayofweek == 'Sat') {
				$weekday = 'e';
			}
			// is in peak?
			$peak='p'; // default to peak
			if ($dateval < $start_peakval || $dateval > $stop_peakval) {
				$peak='o'; // if outside peak, then is offpeak
			}
			
			
			// construct key
			$rateskey = $memberguest.$weekday.$peak.$guestage;
			$daycost = $result->$rateskey;
			
			// TODO: need to calc work party discount
			JFactory::getApplication()->enqueueMessage('dateval  = '.$dateval->format('Y-m-d H:i:s').'dayofweek  = '.$dayofweek.'rateskey  = '.$rateskey.'daycost = '.$daycost);
			JFactory::getApplication()->enqueueMessage('daycost = '.$daycost);
			$bookingcost += $daycost;
			// Increment date by one date
			$dateval->add($interval);
		}
		
		//$wpdisc = BookingsHelper::workpartyDiscount($memguest, $memberval);
		
		// cycle through the dates
		$session = JFactory::getSession();
		$session->set('guestcost',$bookingcost);
		return $bookingcost;
	}
}