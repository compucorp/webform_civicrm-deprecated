<?php

require_once 'CRM/Core/Form.php';

/**
 * Form controller class
 *
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC43/QuickForm+Reference
 */
class CRM_Membersonlyevent_Form_ManageEvent_MembersOnlyEvent extends CRM_Event_Form_ManageEvent {
  
  public $_priceValueSet = array();
  
  function buildQuickForm() {
     
    // add form elements
    $this->add(
      'checkbox', // field type
      'is_members_only_event', // field name
      ts('Is members only event?'), // field label
      '',   // list of attributes
      FALSE // is required
    );
    
	$priceFields = $this->getMemberPriceFields();
	
    // add form elements
    if(!$priceFields){
      $this->add(
      	'static', // field type
      	'price_field_id', // field name
      	ts('Price field used for membership signup'), // field label
      	'To enable this, choose a price set in the event "Fees" tab.'
      );
    }else{
      $this->add(
      	'select', // field type
      	'price_field_id', // field name
      	ts('Price field used for membership signup'), // field label
      	$priceFields, // list of attributes
      	TRUE
      );
      
      $priceValues = $this->getMemberPriceValues($priceFields);
      $membershipTypes = $this->getMembershipTypes();
      $count = 0;
      
      foreach ($priceValues as $key => $value) {
        $this->add(
          'text', // field type
          'price_value_selectitem_'.$count, // field name
          ts($value['label']), // field label
          array('readonly' => 'readonly')
        );
        $count++;
        $this->add(
          'select', // field type
          'membership_type_selectitem_'.$count, // field name
          ts('Price field used for membership signup'), // field label
          array('' => ts('- Select membership type -')) + $membershipTypes
        );
        $count++;
      }
    }
    
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
  
  /**
   * This function sets the default values for the form.
   *
   * @access public
   */
  function setDefaultValues() {
      
    $defaults = array();
    
    // Search for the Members Only Event object by the Event ID
    $members_only_event = CRM_Membersonlyevent_BAO_MembersOnlyEvent::getMembersOnlyEvent($this->_id);
    
    if(is_object($members_only_event)) {
    
      $defaults['is_members_only_event'] = $members_only_event->is_members_only_event;
		
      if(!is_null($members_only_event->price_field_id)){
      	$defaults['price_field_id'] = $members_only_event->price_field_id;
        
        $priceFieldValues = $this->_priceValueSet[$defaults['price_field_id']];
        
        $event_member_prices = CRM_Membersonlyevent_BAO_EventMemberPrice::retrieve(array('event_id' => $this->_id));
        foreach ($event_member_prices as $key => $value) {
          foreach ($priceFieldValues as $order => $item) {
            if($value->price_value_id==$item['id']){
              $element = $order*2+1;
              $defaults['membership_type_selectitem_'.$element] = $value->membership_type_id;
            }
          }
        }
      }
	    
    }
    
    return $defaults;
  }
  
  function getMemberPriceFields() {
  	
  	$eventId  = $this->_id;
	  $return_array = array();
		
  	if (isset($eventId)) {
      $price_set_id = CRM_Price_BAO_PriceSet::getFor('civicrm_event', $eventId, NULL, 1);

      if ($price_set_id) {
		    $results = civicrm_api3('PriceField', 'get', array('price_set_id' => $price_set_id, 'is_active' => 1));
    	  $price_fields = $results['values'];
		
		    foreach ($price_fields as $key => $price_field) {
      		$return_array[$key] = $price_field['label'];
    	  }
      }else {
      	return FALSE;
      }
	  }else{
		  return FALSE;
	  }
    
    return $return_array;
  }
  
  function getMemberPriceValues($fields) {
    
    if(count($fields)>0){
      $count = 0;
      $priceValueList = array();
      $return_array = NULL;
      
      foreach ($fields as $id => $field) {
        $result = civicrm_api3('PriceFieldValue', 'get', array('price_field_id' => $id, 'sequential' => 1));
        $priceValueList[$id] = $result['values'];
        if($result['count']>$count){
          $count = $result['count'];
          $return_array = $result['values'];
        }
      }
      
      $this->assign('priceValueList', $priceValueList);
      $this->_priceValueSet = $priceValueList;
      return $return_array;
    }
    
  }
  
  function getMembershipTypes() {
    
    $result = civicrm_api3('MembershipType', 'get');
    $membership_types = $result['values'];
    
    foreach ($membership_types as $key => $membership_type) {
      $return_array[$key] = $membership_type['name'];
    }
    
    return $return_array;
  }

  function postProcess() {
    $passed_values = $this->exportValues();
    
    // Search for the Members Only Event object by the Event ID
    $members_only_event = CRM_Membersonlyevent_BAO_MembersOnlyEvent::getMembersOnlyEvent($this->_id);
    
    if(is_object($members_only_event)) {
      // If we have the ID, edit operation will fire
      $params['id'] = $members_only_event->id;
    }
    
    $params['event_id'] = $this->_id;
  	if(is_numeric($passed_values['price_field_id'])){
  		$params['price_field_id'] = $passed_values['price_field_id'];
  	}else{
  		$params['price_field_id'] = NULL;
  	}
    
    $params['is_members_only_event'] = isset($passed_values['is_members_only_event']) ? $passed_values['is_members_only_event'] : 0;
    
    if($params['is_members_only_event']==1){
      // Create or edit the values
      CRM_Membersonlyevent_BAO_MembersOnlyEvent::create($params); 
    }else{
      if(isset($params['id'])){
        civicrm_api3('MembersOnlyEvent', 'delete', array('id' => $params['id']));
      }
    }
    
    //reset params for creating event member prices
    $params = array('event_id' => $this->_id);
    $priceValues = $this->preg_grep_keys_replace('/^price_value_selectitem_/', $passed_values);
    $memberTypes = $this->preg_grep_keys_replace('/^membership_type_selectitem_/', $passed_values);
    $result = civicrm_api3('EventMemberPrice', 'get', array('event_id' => $params['event_id'], 'sequential' => 1));
    $memberPriceIds = $result['values'];
    $count = 0;
    
    foreach ($priceValues as $key => $value) {
      if(is_numeric($value)){
        if(is_numeric($memberTypes[$key+1])){
          $params['id'] = $memberPriceIds[$count]['id'];
          $params['price_value_id'] = $value;
          $params['membership_type_id'] = $memberTypes[$key+1];
          CRM_Membersonlyevent_BAO_EventMemberPrice::create($params);
          $count++;
        }
      }
    }
    
    $deleteRecords = sizeof($memberPriceIds)-$count;
    if($deleteRecords>0){
      for ($i=0; $i < $deleteRecords; $i++) { 
        civicrm_api3('EventMemberPrice', 'delete', array('id' => $memberPriceIds[$count+$i]['id']));
      }
    }
    
    //need recheck
    parent::endPostProcess();
  }

  function preg_grep_keys_replace($pattern, $input, $flags = 0) {
      $origin = array_intersect_key($input, array_flip(preg_grep( $pattern, array_keys($input))));
      $dropped = preg_replace( $pattern, '', array_flip($origin));
      return array_flip($dropped);
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
