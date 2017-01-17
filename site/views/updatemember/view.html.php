<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');


/**
 * HTML View class for the UpdHelloWorld Component
 */
class MembersViewUpdateMember extends JViewLegacy
{
	
	
	
	protected $item;
	
	protected $form;
	
	protected $params;
	
	protected $state;
	
	// Overwriting JView display method
	function display($tpl = null)
	{
		$app		= JFactory::getApplication();
		$params		= $app->getParams();
		$user = JFactory::getUser();
		$dispatcher = JDispatcher::getInstance();

		// Get some data from the models
		$state		= $this->get('State');
		$item		= $this->get('Item');
		$form		= $this->get('Form');
		
		//print_r($item);
		
		$this->state = $state;
		$this->item = $item;
		$this->form = $form;
		
		
		//$this->params	= $this->state->get('params');
		//$this->MemberHomeAddress = $item->MemberHomeAddress;
		
		//JFactory::getApplication()->enqueueMessage('Item home'.$item->MemberHomeAddress.'"');
		

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		$this->form->bind($this->item);
		$this->params = $params;
		$this->user = $user;
		
		// Display the view
		parent::display($tpl);
	}
}