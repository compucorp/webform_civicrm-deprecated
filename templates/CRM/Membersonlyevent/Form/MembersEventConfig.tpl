{* HEADER *}

<h3>{ts}Members Only Event Configuration{/ts}</h3>
<div class="crm-block crm-form-block crm-membersevent-system-config-form-block">

<fieldset><legend>{ts}Membership validation settings{/ts}</legend>
  <table class="form-layout-compressed">

    <tr class="crm-membersevent-system-config-form-block-validation_settings">
        <td class="label">{$form.check_duration.label}</td><td>{$form.check_duration.html}</td>
    </tr>
    
</table>
</fieldset>

{* FOOTER *}
<div class="crm-submit-buttons">
{include file="CRM/common/formButtons.tpl" location="bottom"}
</div>
</div>