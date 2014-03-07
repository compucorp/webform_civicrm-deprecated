<?php

class CRM_Membersonlyevent_BAO_MembersOnlyEvent extends CRM_Membersonlyevent_DAO_MembersOnlyEvent {

  /**
   * Create a new MembersOnlyEvent based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Membersonlyevent_DAO_MembersOnlyEvent|NULL
   *
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
  } */
}
