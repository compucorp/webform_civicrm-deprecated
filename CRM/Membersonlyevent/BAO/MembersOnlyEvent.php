<?php

class CRM_Membersonlyevent_BAO_MembersOnlyEvent extends CRM_Membersonlyevent_DAO_MembersOnlyEvent {

  /**
   * Create a new MembersOnlyEvent based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Membersonlyevent_DAO_MembersOnlyEvent|NULL
   *
   */
  public static function create($params) {
    $className = 'CRM_Membersonlyevent_DAO_MembersOnlyEvent';
    $entityName = 'MembersOnlyEvent';
    $hook = empty($params['id']) ? 'create' : 'edit';

    CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
    $instance = new $className();
    $instance->copyValues($params);
    $instance->save();
    CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

    return $instance;
  }
  
  /**
   * Get a list of Members Only Events matching the params, where params keys are column
   * names of civicrm_membersonlyevent.
   *
   * @param array $params
   * @return array of CRM_Membersonlyevent_BAO_MembersOnlyEvent objects
   */
  public static function retrieve(array $params) {
    $result = array();

    $project = new CRM_Membersonlyevent_BAO_MembersOnlyEvent();
    $project->copyValues($params);
    $project->find();

    while ($project->fetch()) {
      $result[(int) $project->id] = clone $project;
    }

    $project->free();

    return $result;
  }
  
  /**
   * Return the MembersOnlyEvent object for the specified Event by Event ID
   * @param type $event_id
   * @return MembersOnlyEvent object, FALSE otherwise
   */
  public static function getMembersOnlyEvent($event_id = NULL) {
    if ($event_id == NULL) {
      return FALSE;
    }
    
    $params = array(
      'event_id' => $event_id,
    );
  
    $members_only_event = CRM_Membersonlyevent_BAO_MembersOnlyEvent::retrieve($params);
    $members_only_event = array_shift($members_only_event);
    
    return $members_only_event;
  }
}
