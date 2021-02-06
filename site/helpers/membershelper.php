<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_memberadmin
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
class MembersHelper
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
     *  Function to return current subs year.
     */
    
    public function returnSubsYear()
    {
        $db = JFactory::getDbo ();
        $query = $db->getQuery ( true );
        $query->select ( 'subsyear' );
        $query->from ( 'oscreference' );
        $query->where ( 'id = 1 '  );  // Data only in the first row
        $db->setQuery ( $query );
        $subsyear = $db->loadResult();
        
        return ($subsyear);
    }
    
    // Function to return subs start date for the year
    
    public function returnSubsStartDate()
    {
        
        // get subs year
        $subsyear = $this->returnSubsYear();
        
        $db = JFactory::getDbo ();
        $query = $db->getQuery ( true );
        $query->select ( 'subsstartdate' );
        $query->from ( 'oscsubsreferencedates' );
        $query->where ( 'subsyear =  ' . $subsyear  );  // Data only in the first row
        $db->setQuery ( $query );
        $subsstartdate = $db->loadResult();
        
        return ($subsstartdate);
    }
    // Function to return subs end date
    
    public function returnSubsPaybyDate()
    {
        
        // get subs year
        $subsyear = $this->returnSubsYear();
        
        $db = JFactory::getDbo ();
        $query = $db->getQuery ( true );
        $query->select ( 'subpaybydate' );
        $query->from ( 'oscsubsreferencedates' );
        $query->where ( 'subsyear =  ' . $subsyear  );  // Data only in the first row
        $db->setQuery ( $query );
        $subsstartdate = $db->loadResult();
        
        return ($subsstartdate);
    }
    
	
}