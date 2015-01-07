  <tr>
                          <td width="35%" align="left" valign="middle" class="padleft"><strong>{$formParams.feild_label}{if $formParams.is_required eq '1'} <em class="redalert">*</em>{/if}</strong></td>
                          <td width="65%" align="left" valign="middle"><label>
                              <input type="text" name="{$formParams.feild_code}" id="{$formParams.feild_code}" value="{$formParams.value}" {if $formParams.class}class="{$formParams.class}"{/if} {$formParams.feildValues}/>
                            </label><br />
                            <span id="error_{$formParams.feild_code}" {$formParams.errorClass} class="error">{$formParams.errorMessage}</span></td>
                        </tr>