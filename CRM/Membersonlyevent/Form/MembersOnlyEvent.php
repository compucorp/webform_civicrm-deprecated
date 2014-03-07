<?php

require_once 'CRM/Core/Form.php';

/**
 * Form controller class
 *
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC43/QuickForm+Reference
 */
class CRM_Membersonlyevent_Form_MembersOnlyEvent extends CRM_Event_Form_ManageEvent {
  function buildQuickForm() {
   
      $data = new CRM_Membersonlyevent_DAO_MembersOnlyEvent();
      //print_r($data); die();
    // add form elements
    $this->add(
      'checkbox', // field type
      'is_members_only_event', // field name
      'Members only event?', // field label
      '',   // list of options
      true // is required
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
    $passed_values = $this->exportValues();
    $insert = new CRM_Membersonlyevent_BAO_MembersOnlyEvent();
    $params = array();
    // $params['id// this is members only event ID'] --> check if available, do a retrieve query when the event is edited and pass it as hidden value with post
    // if not available then insert, else edit
    
    //$params['is_members_only_event'] = $passed_values['is_members_only_event'];
    $params['event_id'] = $passed_values['id'];
    $params['contribution_page_id'] = NULL;
    
    $insert->create($params);
    
    parent::postProcess();
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
