<?php

require_once 'membersonlyevent.civix.php';

/**
 * Implementation of hook_civicrm_config
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function membersonlyevent_civicrm_config(&$config) {
  _membersonlyevent_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function membersonlyevent_civicrm_xmlMenu(&$files) {
  _membersonlyevent_civix_civicrm_xmlMenu($files);
}

/**
 * Implementation of hook_civicrm_install
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function membersonlyevent_civicrm_install() {
  return _membersonlyevent_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_uninstall
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function membersonlyevent_civicrm_uninstall() {
  return _membersonlyevent_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function membersonlyevent_civicrm_enable() {
  return _membersonlyevent_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function membersonlyevent_civicrm_disable() {
  return _membersonlyevent_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_upgrade
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function membersonlyevent_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _membersonlyevent_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function membersonlyevent_civicrm_managed(&$entities) {
  return _membersonlyevent_civix_civicrm_managed($entities);
}

/**
 * Implementation of hook_civicrm_caseTypes
 *
 * Generate a list of case-types
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function membersonlyevent_civicrm_caseTypes(&$caseTypes) {
  _membersonlyevent_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implementation of hook_civicrm_alterSettingsFolders
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function membersonlyevent_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _membersonlyevent_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * hook_civicrm_permission(&$permissions)
 * This hook is called to allow custom permissions to be defined. Available in 4.3 or 4.4.
 */
function membersonlyevent_civicrm_permission(&$permissions) {
    
  $prefix = ts('CiviEvent') . ': '; // name of extension or module
  $permissions = array(
    'members only event registration' => $prefix . ts('Can register for Members only events'),
  );
  
}

/**
 * Alter the event registration and check for the correct permissions.
 */
function membersonlyevent_civicrm_alterContent(&$content, $context, $tplName, &$object) {

  if($tplName == "CRM\Event\Form\Registration\Register.tpl" && $context == "form") {
      
    global $user;
  
    require_once 'CRM/Core/BAO/CustomField.php';
    require_once 'CRM/Core/BAO/CustomValueTable.php';
    
    // Get the custom field ID
    $customFieldID = CRM_Core_BAO_CustomField::getCustomFieldID('Members_only_Event', 'Private_Members_settings');
    
    // Check for the custom field value
    $values = CRM_Core_BAO_CustomValueTable::getEntityValues($_GET['id'], '', array($customFieldID));
    
    // This value equals 1 -> if the EVENT is for "private members only"
    $private_event = (string) array_shift($values);
    
    if ($private_event == TRUE) {
        
      if (!user_access('members only event registration')) {
        $content = "<p>You are not allowed to register for this event!</p>";      
      }
      
    }
    
  }
}