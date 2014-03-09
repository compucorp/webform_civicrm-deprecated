{* Check if the online registration for this event is allowed, show notification message otherwise *}
{if $isOnlineRegistration == 1}
  {* HEADER *}

  <div class="crm-submit-buttons">
    {include file="CRM/common/formButtons.tpl" location="top"}
  </div>
    
  {* FIELDS: (AUTOMATIC LAYOUT) *}

  {foreach from=$elementNames item=elementName}
    <div class="crm-section" id="{$form.$elementName.id}">
      <div class="label">{$form.$elementName.label}</div>
      <div class="content">{$form.$elementName.html}</div>
      <div class="clear"></div>
    </div>
  {/foreach}

  {* FOOTER *}

  <div class="crm-submit-buttons">
    {include file="CRM/common/formButtons.tpl" location="bottom"}
  </div>
  
  <script type="text/javascript">
  {literal}
    jQuery(document).ready(function(){
      jQuery("#is_members_only_event input[type=checkbox]").click(function(){
        
        if (jQuery(this).attr("checked") == true){
          jQuery("#contribution_page_id").show();
        }
        else {
          jQuery("#contribution_page_id").hide();
        }
      
      });
      
      if (jQuery("#is_members_only_event input[type=checkbox]").attr("checked") == false){
        jQuery("#contribution_page_id").hide();
      }
      
    });
  {/literal}
  </script>
    
{else}
    <div id="help">{ts}Online registration tab needs to be enabled for this event to set the members only event settings.{/ts}</div>
{/if}