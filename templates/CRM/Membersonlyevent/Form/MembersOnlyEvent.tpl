{* Check if the online registration for this event is allowed, show notification message otherwise *}
{if $isOnlineRegistration == 1}
  {* HEADER *}

  <div class="crm-submit-buttons">
    {include file="CRM/common/formButtons.tpl" location="top"}
  </div>
    
  {* FIELDS: (AUTOMATIC LAYOUT) *}

  {foreach from=$elementNames item=elementName}
    <div class="crm-section">
      <div class="label">{$form.$elementName.label}</div>
      <div class="content">{$form.$elementName.html}</div>
      <div class="clear"></div>
    </div>
  {/foreach}

  {* FOOTER *}

  <div class="crm-submit-buttons">
    {include file="CRM/common/formButtons.tpl" location="bottom"}
  </div>
    
{else}
    <div id="help">{ts}Online registration tab needs to be enabled for this event to set the members only event settings.{/ts}</div>
{/if}