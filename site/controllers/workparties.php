<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once JPATH_COMPONENT . '/controller.php';

/**
 * Profile controller class for Users.
 *
 * @since  1.6
 */
class MembersControllerWorkparties extends MembersController 
{
	/**
	 * Method to check out a user for editing and redirect to the edit form.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 * 
	 */
	  public function edit()
	{
		$app         = JFactory::getApplication();
		$user        = JFactory::getUser();
		$loginUserId = (int) $user->get('id');
		
		// Get the model.
		$model = $this->getModel('WorkParties', 'MembersModel');
		
		// Redirect to the edit screen.
		$this->setRedirect(JRoute::_('index.php?option=com_members&view=workparties&layout=edit', false));
		
		return true;
	 } // edit
	 
	 /**
	  * Method to save a user's profile data.
	  *
	  * @return  void
	  *
	  * @since   1.6
	  */
	 public function save()
	 {
	     
	    // JFactory::getApplication()->enqueueMessage('In save:');
	     
	 	// Check for request forgeries.
	 	JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
	 
	 	$app    = JFactory::getApplication();
	 	$model = $this->getModel('WorkParties', 'MembersModel');
	 	
	 	// Get the user data.
	 	$data = $app->input->post->get('jform', array(), 'array');
	 	//JFactory::getApplication()->enqueueMessage('form data'.$data);
	 	
	 	// Validate the posted data.
	 	$form = $model->getForm();
	 	
	 	if (!$form)
	 	{
	 		JError::raiseError(500, $model->getError());
	 	
	 		return false;
	 	}
	 	
	 	// Validate the posted data.
	 	$data = $model->validate($form, $data);
	 	
	 	/*// Check for errors.
	 	if ($data === false)
	 	{
	 		// Get the validation messages.
	 		$errors = $model->getErrors();
	 	
	 		// Push up to three validation messages out to the user.
	 		for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++)
	 		{
	 			if ($errors[$i] instanceof Exception)
	 			{
	 				$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
	 			}
	 			else
	 			{
	 				$app->enqueueMessage($errors[$i], 'warning');
	 			}
	 		}
	 	
	 		// Save the data in the session.
	 		$app->setUserState('com_members.edit.members.data', $data);
	 	
	 		// Redirect back to the edit screen.
	 		$userId = (int) $app->getUserState('com_members.edit.members.id');
	 		$this->setRedirect(JRoute::_('index.php?option=com_members&view=members&layout=edit', false));
	 	
	 		return false;
	 	}*/
	 	
	 	// Attempt to save the data.
	 	$return = $model->save($data);
	 	
	 	
	 	// Check for errors.
	 	if ($return === false)
	 	{
	 		// Save the data in the session.
	 		$app->setUserState('com_members.edit.workparties.data', $data);
	 	
	 		// Redirect back to the edit screen.
	 		$this->setMessage(JText::sprintf('COM_MEMBERS_MEMBERS_SAVE_FAILED', $model->getError()), 'warning');
	 		$this->setRedirect(JRoute::_('index.php?option=com_members&view=workparties&layout=edit', false));
	 	
	 		return false;
	 	}
	 	
	 	// Flush the data from the session.
	 	$app->setUserState('com_members.edit.workparties.data', null);
	 	
	 	// Set return path
	 	$this->setRedirect(JRoute::_('index.php?option=com_members&view=finances', false));
	 	
	 } // save
} // class