<pre><?php 

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

include("dbconfig.php");

$selectIndexQuery="Select * from tbl_indxx";
$resIndxx=mysql_query($selectIndexQuery);
$datevalue=date("Y-m-d",strtotime(date("Y-m-d"))-86400);
$price_array=array();

$insert=0;
$update=0;

if (mysql_num_rows($resIndxx)>0)
{
while($row=mysql_fetch_assoc($resIndxx))
{
	$sharetotal=0;
	$investAmmount=$row['investmentammount'];
	//echo $query="SELECT  it.isin,(select price from tbl_final_price pf where pf.isin=it.isin and pf.date='".$datevalue."') as price FROM `tbl_indxx_ticker` it where it.indxx_id='".$row['id']."'";
	  $query="SELECT  fp.isin, fp.price,(select weight from tbl_indxx_ticker it where it.isin=fp.isin and it.indxx_id=fp.indxx_id) as calcweight from tbl_final_price fp where fp.date='".$datevalue."' and fp.indxx_id='".$row['id']."'";
	//$query="SELECT  fp.isin, fp.price,(select weight from tbl_indxx_ticker it where it.isin=fp.isin and it.indxx_id=fp.indxx_id) as calcweight from tbl_final_price fp where fp.date='2013-09-12' and fp.indxx_id='".$row['id']."'";

	$res=mysql_query($query);
	
	$share=array();
	
//	echo "Displaying ".mysql_num_rows($res)." records for id=".$row['id']."<br>";
	while($result=mysql_fetch_assoc($res))
	{
		
		$share[$row['id']][$result['isin']]=number_format((($investAmmount*$result['calcweight'])/$result['price']),50, '.', '');
			
			//$share[$row['id']][$result['isin']]['share']=number_format(($investAmmount*$result['calcweight'])/$result['price'] ,50, '.', '');
			
			//$share[$row['id']][$result['isin']]['price']=$result['price'];
	}
	
	//print_r($share);
	//exit;
	foreach($share as $key=>$value)
	{
		foreach($value as $key2=>$value2)
		{
		//	$value2;
		$check=Checkvalues($key2,$row['id'],$datevalue);
		if($check)
		{
			$updatesharequery="update tbl_share set indxx_id='".$row['id']."',isin='".$key2."',date='".$datevalue."')";
			
			mysql_query($updatesharequery);
			
			$update++;	
		}
		else
		{
		$inshareQuery="insert into tbl_share(indxx_id,isin,date,share) values('".$row['id']."','".$key2."','".$datevalue."','".$value2."')";
		//$inshareQuery="insert into tbl_share(indxx_id,isin,date,share) values('".$row['id']."','".$key2."','2013-09-12','".$value2."')";
		mysql_query($inshareQuery);
		$insert++;
		}
		}
	//	echo number_format($sharetotal ,50, '.', '')."<br>";
	}
}

if($update>0)
{
	echo "Updation done!!!!<br>";	
}
else if($insert>0)
{
	echo "Insertion Done!!!! <br>";	
}

}

function Checkvalues($isin,$indxxid,$dateval)
{
 	$matchfilequery="select * from tbl_share where isin='".$isin."' and date='".$dateval."' and indxx_id='".$indxxid."' ";
	$resmatchfile=mysql_query($matchfilequery);
	
	if(mysql_num_rows($resmatchfile)>0)	
	{
			return true;
	}
	else
	{
			return false;	
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