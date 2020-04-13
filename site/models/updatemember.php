<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Include dependancy of the main model form
jimport('joomla.application.component.modelform');
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
// Include dependancy of the dispatcher
jimport('joomla.event.dispatcher');

/**
 * UpdHelloWorld Model
 */
class MembersModelUpdateMember extends JModelForm
{
	/**
	 * @var object item
	 */
	protected $_item = null;

	/**
	 * Get the data for a new qualification
	 */
	public function getForm($data = array(), $loadData = true)
	{

		//$app = JFactory::getApplication('site');

		// Get the form.
		$form = $this->loadForm('com_members.updatemember', 'updatemember', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}
		return $form;

	}
	
	public function getItem($pk = null)
	{
		//$pk = (!empty($pk)) ? $pk : (int) $this->getState('updatemember.id');
	
		//if ($this->_item === null)
		//{
		//	$this->_item = array();
			//}
			$user = JFactory::getUser();
			$useremail = $user->email;
	
	
			try
			{
				$db = $this->getDbo();
				$query = $db->getQuery(true);
				$query->select('id,MemberHomeAddress');
				$query->from('oscmembers');
				$query->where('memberemail = '.$db->quote($useremail));
	
				$db->setQuery($query);
				$rowdata = $db->loadObject();   //  loadObject();
				//print_r($rowdata);
				$this->_item = $rowdata;
				//print_r($this->_item);
				$this->_item->id = $rowdata['id'];
				//$testdata = $data['MemberHomeAddress'];
				$this->_item->MemberHomeAddress = $rowdata['MemberHomeAddress'];
				//$tstmsg = 'Test message';
				//JFactory::getApplication()->enqueueMessage('MemberHome:'.$tstmg.'::');
	
			} // try
			catch (Exception $e)
			{
				$this->setError($e);
					
				$this->_item = false;
			} // catch
	
			
			return $this->_item;
		} // function
		
		
	protected function loadFormData()
	{
		// Check the session for previously entered login form data.
		$app  = JFactory::getApplication();
		$loaddata = $this->getItem(); // $app->getUserState('com_members.updatemember.form.data', array());
	
		//$input = $app->input;
		//$method = $input->getMethod();
		
		//$app->setUserState('com_members.updatemember.form.data', $data);
		
		//$this->preprocessData('com_members.updatemember', $data);
		
		return $loaddata;
	}

	
	
	protected function populateState()
	{
		// Get the application object.
		$params	= JFactory::getApplication()->getParams('com_members');
	
		// Load the parameters.
		$this->setState('params', $params);
	}
	/**
	 * Get the message
	 * @return object The message to be displayed to the user
	 */
	

	public function updItem($data)
	{
		// set the variables from the passed data
		$id = $data['id'];
		$memberaddress = $data['MemberHomeAddress'];

		// set the data into a query to update the record
		// TODO: validate data
		// TODO: save all details
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		$query->clear();
		$query->update(' oscmembers ');
		$query->set(' MemberHomeAddress = '.$db->Quote($memberaddress) );
		$query->where(' id = ' . (int) $id );

		$db->setQuery((string)$query);

		if (!$db->query()) {
			JError::raiseError(500, $db->getErrorMsg());
			return false;
		} else {
			return true;
		}
	}
}