{if $head_js|@count > 0}{foreach from=$head_js item=js}
<script type="text/javascript" src="{$BASE_URL}assets/{$js}"></script>
{/foreach}
{/if}
{if $head_css|@count > 0}{foreach from=$head_css item=css}
<link href="{$BASE_URL}assets/{$css}" rel="stylesheet" type="text/css" />
{/foreach} 
{/if} 
{if $extraHead|@count > 0}{foreach from=$extraHead item=script}{$script}
{/foreach}
{/if}