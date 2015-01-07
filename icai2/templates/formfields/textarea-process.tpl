 <td width="35%" align="left" valign="middle" class="padleft"><strong>{$formParams.feild_label}{if $formParams.is_required eq '1'} <em class="redalert">*</em>{/if}</strong></td>
                          <td width="65%" align="left" valign="middle"><label><textarea name="{$formParams.feild_code}" id="{$formParams.feild_code}" {$formParams.option}   value="{$formParams.feild_label}" {if $formParams.class}class="{$formParams.class}"{/if}>{$formParams.feildValues}</textarea>
<span id="error_{$formParams.feild_code}" {$formParams.errorClass}>{$formParams.errorMessage}</span>
</label>