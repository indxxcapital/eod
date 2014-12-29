<span id="feildHtml_{$Form_Params.name}">
{html_monthyear
valueSelected = $Form_Params.value
prefix=$Form_Params.feild_code time=$time start_year='-100' end_year='-1'
month_empty='Month' year_empty='Year' style='width:100px' reverse_years='true'}</span>
<span id="error_{$Form_Params.name}" {$Form_Params.errorClass}>{$Form_Params.errorMessage}</span>	


