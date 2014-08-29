<?php

require_once 'CRM/Core/Form.php';

/**
 * Form controller class
 *
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC43/QuickForm+Reference
 */
class CRM_Membersonlyevent_Form_EventMemberSelect extends CRM_Event_Form_Registration {

  //protected $_eventId = NULL;
  
  function preProcess() {
    parent::preProcess();
	$session = CRM_Core_Session::singleton();
	$this->_eventId = $session->get('member_event_id');
  }
  
  function buildQuickForm() {
  	CRM_Utils_System::setTitle(ts('Become a Member'));
	
  	$relationshipList = array(
  		'1' => 'test1',
  		'2' => 'test2'
	);
  	
	// add form elements
    $this->add(
      'select', // field type
      'membership_types', // field name
      ts('Membership Types'), // field label
      array( '' => ts('-- Select --')) + $relationshipList,// list of attributes
      TRUE // is required
    );
	
	$this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => ts('Submit'),
        'isDefault' => TRUE,
      ),
    ));
	
    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  function postProcess() {
  	CRM_Utils_System::flushCache();
	
    $values = $this->exportValues();
	if(isset($values['membership_types'])){
	  $params['membership_types'] = $values['membership_types'];
	}else{
	  $params['membership_types'] = 0;
	}
	
	$url = CRM_Utils_System::url('civicrm/event/register',
      "reset=1&id={$this->_eventId}&mid={$params['membership_types']}"
    );
	CRM_Utils_System::redirect($url);
  }
  
  /**
   * Get the fields/elements defined in this form.
   *
   * @return array (string)
   */
  function getRenderableElementNames() {
    // The _elements list includes some items which should not be
    // auto-rendered in the loop -- such as "qfKey" and "buttons".  These
    // items don't have labels.  We'll identify renderable by filtering on
    // the 'label'.
    $elementNames = array();
    foreach ($this->_elements as $element) {
      $label = $element->getLabel();
      if (!empty($label)) {
        $elementNames[] = $element->getName();
      }
    }
    return $elementNames;
  }

}
