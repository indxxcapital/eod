
<link rel="stylesheet" href="{$BASE_URL}assets/css/ui-lightness/jquery.css">
	<script src="{$BASE_URL}assets/js/jquery-ui-1.8.8.custom.min.js"></script> 
	<script>
	{literal}
	jQuery(function() {
		var date = new Date();
		var currentMonth = date.getMonth();
		var currentDate = date.getDate();
		var currentYear = date.getFullYear();
		jQuery( {/literal}".date-pick{$Form_Params.name}"{literal} ).datepicker({
		dateFormat: "dd-MM-yy",
		
		changeMonth: true,
		changeYear: true
	 
		{/literal}
		
		{if $Form_Params.name=="dob"}
			,
			yearRange: "c-50",
		   	changeMonth: true,
			changeYear: true,
			maxDate: new Date(currentYear, currentMonth, currentDate)
				{/if}
		{literal}
		
		});
	});
	{/literal}
	</script>


<input type="text" name="{$Form_Params.name}" id="{$Form_Params.name}" value="{$Form_Params.value}" class="date-pick{$Form_Params.name}{if $Form_Params.class!=""} {$Form_Params.class}{/if}"/>
<span id="error_{$Form_Params.name}" {$Form_Params.errorClass}>{$Form_Params.errorMessage}</span>
