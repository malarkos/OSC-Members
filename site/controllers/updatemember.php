<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_members
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Controller for single contact view
 *
 * @since  1.5.19
 */
class MembersControllerUpdateMember extends JControllerForm 
{
	/**
	 * Method to get a model object, loading it if required.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JModelLegacy  The model.
	 *
	 * @since   1.6.4
	 */
	public function getModel($name = 'UpdateMember', $prefix = 'MembersModel', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, array('ignore_request' => false));
	}
	
	public function submit()
	{
		// Check for request forgeries.
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
	
		// Initialise variables.
		$app	= JFactory::getApplication();
		$model	= $this->getModel('updatemember');
	
		// Get the data from the form POST
		$data = JRequest::getVar('jform', array(), 'post', 'array');
	
		// Now update the loaded data to the database via a function in the model
		$upditem	= $model->updItem($data);
	
		// check if ok and display appropriate message.  This can also have a redirect if desired.
		if ($upditem) {
			echo "<h2>Updated Member has been saved</h2>";
		} else {
			echo "<h2>Updated Member failed to be saved</h2>";
		}
	
		return true;
	}
	
	
}