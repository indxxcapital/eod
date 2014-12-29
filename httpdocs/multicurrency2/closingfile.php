<pre>
<?php

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

if(date("D")!='Sun' && date("D")!='Sat'){


include("dbconfig.php");


$selectIndexQuery="Select * from tbl_indxx ";
$resIndxx=mysql_query($selectIndexQuery);
$datevalue=date("Y-m-d",strtotime(date("Y-m-d"))-86400);
$price_array=array();
$divisor=100;
$entry1='';$entry2='';$entry3='';$entry4='';
if (mysql_num_rows($resIndxx)>0)
{
while($row=mysql_fetch_assoc($resIndxx))
{
	$marketvalue=0;
$indxxvalue=0;
$query="SELECT  it.name,it.isin,it.ticker,(select price from tbl_final_price fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as calcprice,(select localprice from tbl_final_price fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as localprice,(select currencyfactor from tbl_final_price fp where fp.isin=it.isin  and fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."') as currencyfactor,(select share from tbl_share sh where sh.isin=it.isin  and sh.indxx_id='".$row['id']."') as calcshare FROM `tbl_indxx_ticker` it where it.indxx_id='".$row['id']."'";
	$res=mysql_query($query);

	$file="../files/closing/closing-".$row['code']."-".$datevalue.".txt";

$open=fopen($file,"w+");


$entry1='Date'.",";
$entry1.=$datevalue.",\n";
$entry1.='INDEX VALUE'.",";
$entry3='EFFECTIVE DATE'.",";
$entry3.='TICKER'.",";
$entry3.='NAME'.",";
$entry3.='ISIN'.",";
$entry3.='INDEX SHARES'.",";
$entry3.='PRICE'.",";
$entry3.='CURRENCY FACTOR'.",";
$entry4='';

	while($result=mysql_fetch_assoc($res))
	{
		//print_r($result);
	
		$marketvalue+=number_format($result['calcshare']*$result['calcprice'],50, '.', '');


	$entry4.= "\n".$datevalue.",";
            $entry4.=  $result['ticker'].",";
           $entry4.= $result['name'].",";
          $entry4.=$result['isin'].",";
        $entry4.=$result['calcshare'].",";
       $entry4.=$result['localprice'].",";
	     $entry4.=$result['currencyfactor'].",";


	}
	
	$olddivisor=$divisor;
	//echo $marketvalue;

$indxxvalue=number_format($marketvalue/$divisor,50, '.', '');
	
	 $insertquery="insert into tbl_indxx_value(indxx_id,market_value,indxx_value,date,olddivisor,newdivisor) values('".$row['id']."','".number_format($marketvalue,50, '.', '')."','".$indxxvalue."','".$datevalue."','".$olddivisor."','".$divisor."')";
	mysql_query($insertquery);



	//echo "Yes";
//	exit;
$entry2=$indxxvalue.",\n";




if($open){        
 if(   fwrite($open,$entry1.$entry2.$entry3.$entry4))
{        fclose($open);
echo "file Writ for ".$row['code']."<br>";

}
}  	

}
}
}

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
mysql_close();
echo 'Page generated in '.$total_time.' seconds.';



?>