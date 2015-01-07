<?php
class Block_ic7daysvalues2 extends Block
{
     function __construct($smarty)
	{
    parent::__construct($smarty);
	$indxxvals=array();
	//$_SESSION
	//$this->pr($_SESSION,true);
	
	
/*	
	$indxxs=$this->db->getResult("SELECT id , code FROM tbl_indxx WHERE status='1' order by id desc",true);
	//$this->pr($indxxs);
	
	$indxxvalues=$this->db->getResult("SELECT indxx_id,date,indxx_value FROM tbl_indxx_value  order by date desc",true,7*count($indxxs));
	if(!empty($indxxvalues))
	{
	foreach($indxxvalues as $indxxvalue)
	{
		$indxxvals[$indxxvalue['date']][$indxxvalue['indxx_id']]=$indxxvalue['indxx_value'];
	}
	}
	//$this->pr($indxxvals);
	if(!empty($indxxvals)){
	foreach($indxxvals as $date=> $indxxval)
	{
		foreach ($indxxs as $indxx)
		{
		//$this->pr($indxx);
		
		if(!$indxxvals[$date][$indxx['id']])
		{$indxxvals[$date][$indxx['id']]=0;
		krsort($indxxvals[$date]);
		}
		}
	
	}
	}
	*/
//$this->pr($indxxvals);
	
	
/*	
	$dataarray=array();
	if(!empty($indxxvals)){
	foreach($indxxvals as $date=> $indxxval)
	{
		//echo $indxxval['date'];
 $substr='[new Date('.date("Y",strtotime($date)).', '.(date("m",strtotime($date))-1).' ,'.date("d",strtotime($date)).'),';
	$VALARRAY=array();
	
	foreach($indxxval as $indxxk)
	{
	$VALARRAY[]=number_format($indxxk,2,'.',"");
	}
$dataarray[]=	 $substr.implode(',',$VALARRAY)."]";
	//echo "<br>";
	}
	}
	
	$str='';
	$str='';
	if(!empty($indxxs))
	{
	$str="data.addColumn('date', 'Date');";
	foreach($indxxs as $indxx)
	{
    $str.="data.addColumn('number', '".$indxx['code']."');";
	
	}
	
	
	}
	
	$this->smarty->assign("columns",$str);
	//echo implode(',',$dataarray);
	//exit;
	
		$this->smarty->assign("datastr",implode(',',$dataarray));*/

//	$this->pr($indxxvals);
	/*$block_main_menu=$this->db->getResult("SELECT id,title  FROM tbl_publications WHERE status='1' order by id desc",true,10);
   // $this->pr($block_main_menu);
	$menu=array();
	if (!empty($block_main_menu))
	{
		foreach ($block_main_menu as $key=>$value)
		{
		$menu[$value['id']]=$value['title'];
		}
		//$this->pr($menu);
		//exit;
	}*/
	//$this->smarty->assign("blogs",$menu);
	//echo "deepak";
	
	
	if($_SESSION['User']['type']==2 && !empty($_SESSION['Index']))
	{
	$subQuery=" AND id in (".implode(',',$_SESSION['Index']).")";
	
	
	}
	
	
	
	$liveindexes=$this->db->getResult("SELECT id  FROM tbl_indxx WHERE status='1' and usersignoff='1' and dbusersignoff='1' and submitted='1'" .$subQuery,true);
	//$this->pr($liveindexes,true);
	if(!empty($liveindexes)){
	foreach($liveindexes as $key=>$value)
	{
		$liveindexvalues=$this->db->getResult("SELECT tbl_indxx_value.indxx_id,tbl_indxx_value.date,tbl_indxx_value.indxx_value,tbl_indxx.code,tbl_indxx.name FROM tbl_indxx left join tbl_indxx_value on tbl_indxx_value.indxx_id=tbl_indxx.id where tbl_indxx.id='".$value['id']."'order by date desc limit 0,2",true);
		$indxxvaluesarray[]=$liveindexvalues;
		
	}}
	//$this->pr($indxxvaluesarray,true);
	
	
	$this->smarty->assign("indxxvaluesarray",$indxxvaluesarray);
	
	}
	
}
?>