{* HEADER *}

<div class="crm-submit-buttons">
  {include file="CRM/common/formButtons.tpl" location="top"}
</div>

{* Check if the online registration for this event is allowed, show notification message otherwise *}
{if $isOnlineRegistration == 1}
  <div id="help">{ts}Ok.{/ts}{help id="id-membersonlyevent-init"}</div>
{else}
    <div id="help">{ts}Online registration tab needs to be enabled for this event to set the members only event settings.{/ts}</div>
{/if}


{$isOnlineRegistration}


{* FOOTER *}

<div class="crm-submit-buttons">
  {include file="CRM/common/formButtons.tpl" location="bottom"}
</div>
