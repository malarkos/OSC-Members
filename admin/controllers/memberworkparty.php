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
use Joomla\CMS\Uri\Uri;
use Joomla\Utilities\ArrayHelper;

/**
 * HelloWorld Controller
 *
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 * @since       0.0.9
 */
class MembersControllerMemberWorkParty extends JControllerForm
{
    public function delete()
    {
        // Debug message
        $uri = Uri::getInstance();
        $url = $uri->toString();
        
        //JFactory::getApplication()->enqueueMessage('URL='.$url);
        $returnurl = $_SERVER['HTTP_REFERER'];
        //JFactory::getApplication()->enqueueMessage('URL='.$returnurl);
        // Check for request forgeries.
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
        
        // Get all selected items
        $ids = $this->input->get('cid', array(), 'array');
        
        // Get the model
        $model = $this->getModel();
        
        if(!empty($ids))
        {
            
            $ids = ArrayHelper::toInteger($ids);
            foreach ($ids as $id) {
                //JFactory::getApplication()->enqueueMessage('ID to delete is  = '.$id.":");
                //JFactory::getApplication()->enqueueMessage('In Controller delete()');
                
                // Call model delete function
                $model->delete($id);
            } // for
            
            // Call delete funct
        } // if
        
        // Set the re-direct
        $this->setRedirect($returnurl);
    }
    
    public function cancel($key = null, $urlVar = null) {
        JFactory::getApplication()->enqueueMessage('In Controller cancel()');
        $app    = JFactory::getApplication();
        $jinput = $app->input;
        $wpid = $jinput->get('WorkPartyID','','text');
        JFactory::getApplication()->enqueueMessage('wpid = '.$wpid);
        $db = JFactory::getDbo();
        $query->select ( 'MemberID' );
        $query->from ( 'workparty' );
        $query->where ( 'WorkPartyID = ' . $wpid );
        $db->setQuery ( $query );
        
        $memid = $db->loadResult();
        $returnurl = 'index.php?option=com_members&view=memberworkparties&memid='.$memid;
        
        $this->setRedirect($returnurl);
        
        JFactory::getApplication()->enqueueMessage('URL='.$returnurl);
        
        $return = parent::cancel($key, $urlVar);
       // $returnurl = 'index.php?option=com_bookingadmin&view=booking&bookingref='.$bookingref;
        
        $this->setRedirect($returnurl);
        return $return;
    
    }
}