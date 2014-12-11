<?php

class CRM_Membersonlyevent_BAO_EventMemberPrice extends CRM_Membersonlyevent_DAO_EventMemberPrice {

  /**
   * Create a new EventMemberPrice based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Membersonlyevent_DAO_EventMemberPrice|NULL
   *
   */
  public static function create($params) {
    $className = 'CRM_Membersonlyevent_DAO_EventMemberPrice';
    $entityName = 'EventMemberPrice';
    $hook = empty($params['id']) ? 'create' : 'edit';

    CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
    $instance = new $className();
    $instance->copyValues($params);
    $instance->save();
    CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

    return $instance;
  }
  
  /**
   * Get a list of Event Member Price matching the params, where params keys are column
   * names of civicrm_membersonlyevent_memberprice.
   *
   * @param array $params
   * @return array of CRM_Membersonlyevent_BAO_EventMemberPrice objects
   */
  public static function retrieve(array $params) {
    $result = array();

    $project = new CRM_Membersonlyevent_BAO_EventMemberPrice();
    $project->copyValues($params);
    $project->find();

    while ($project->fetch()) {
      $result[(int) $project->id] = clone $project;
    }

    $project->free();

    return $result;
  }
}
