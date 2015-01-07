<?php
class Block_left extends Block
{
     function __construct($smarty)
	{
    parent::__construct($smarty);
	if($_GET['module']=="chart")
	{
		$menu=$this->getchartsubmenu($_GET['id']);
	}
	elseif ($_GET['module']=="contact" || ( $_GET['module']=="content" && $this->checkpagesection($_GET['id'],7)))
	{
		$menu=$this->getcontactsubmenu(7);
	}else if($_GET['module']=="content") 
	{
		$menu=$this->getpagesubmenu($_GET['id']);
	}elseif ($_GET['module']=="team" || $_GET['module']=="pressroom" || $_GET['module']=="publication")	
	{$menu=$this->getpagesubmenu(20);
	}
	$this->smarty->assign("leftmenu",$menu);
	
	
	}
function getpagesubmenu($id)
{
 if ($id)
		 {	
		
		 $pageData = $this->db->getResult("SELECT p.*,(select count(c.id) from tbl_pages c  where c.parent = p.id AND c.status='1') chlids   FROM `tbl_pages` p  where p.id = '".$id."'  ",true);
	//$this->pr($pageData);
		if (!empty($pageData)){
		if($pageData[0]['parent']!=0 && $submenu= $this->checkindicess($pageData[0]['id'])){
		$menu.=' <li><b>'.$pageData[0]["name"].'</b></li>';
		$menu.=$submenu;
		}
		elseif ($pageData[0]['chlids']==0){
		 $menuData = $this->db->getResult("SELECT id,name  FROM `tbl_pages`  where mainmenu = '".$pageData[0]['mainmenu']."' AND parent='".$pageData[0]['parent']."' ",true);
		if (!empty($menuData)){
		foreach ($menuData as $data)
		{
	if ($_GET['id']==$data['id'])
	{
	$activenext='class="active"';
	}else{
	$activenext='';
	}
$menu.=' <li><a '.$activenext.' href="index.php?module=content&event=view&id='.$data['id'].'">'.$data["name"].'</a></li>';

		}
		}
		}
		else{
		$menu.= "<li><b>".$pageData[0]['name']."</b></li>";
		 $menuData = $this->db->getResult("SELECT id,name  FROM `tbl_pages`  where mainmenu = '".$pageData[0]['mainmenu']."' AND parent='".$pageData[0]['id']."' ",true);
		if (!empty($menuData)){
		foreach ($menuData as $data)
		{
	if ($_GET['id']==$data['id'])
	{
	$activenext='class="active"';
	}else{
	$activenext='';
	}
$menu.=' <li><a '.$activenext.' href="index.php?module=content&event=view&id='.$data['id'].'">'.$data["name"].'</a></li>';

		}
		}
		
		}
		}
		 }
		 if($this->checkpagesection($id,6))
		 {
			 
	if ($_GET['module']=="team")
	{
	$activefirst='class="active"';
	}		 
	if ($_GET['module']=="pressroom")
	{
	$activesecond='class="active"';
	}	
	if ($_GET['module']=="publication")
	{
	$activethird='class="active"';
	}		 
$menu.='<li><a '.$activefirst.' href="index.php?module=team&event=index">Our Team</a></li>';
$menu.='<li><a '.$activesecond.' href="index.php?module=pressroom&event=index">Press Room</a></li>';
$menu.='<li><a '.$activethird.' href="index.php?module=publication&event=index">Publication</a></li>';

		} 
		 
		 return $menu;
}	
	
	function getcontactsubmenu($menuid){
	if ($_GET['module']=="contact")
	{
	$activefirst='class="active"';
	}
	
		$menu='<li><a '.$activefirst.' href="index.php?module=contact&event=index">Business Inquiry</a></li>';

$catArray	=	$this->db->getResult("select p.id, p.name  from tbl_pages p where p.parent = '0' AND p.mainmenu = '".$menuid."' and p.status='1' and p.onmenu='0' order by p.id ",true);

if(!empty($catArray)){
foreach($catArray as $key=>$data)
{
	if ($_REQUEST['id']==$data['id'])
	{
	$activenext='class="active"';
	}else{
	$activenext='';
	}
	
$menu.=' <li><a '.$activenext.' href="index.php?module=content&event=view&id='.$data['id'].'">'.$data["name"].'</a></li>';
}
}	
	return $menu;
	}
	
	function checkindicess($id)
	{
$catArray	=	$this->db->getResult("select *  from tbl_chart p where p.parent = '".$id."' AND p.status  = '1'",true);
if(!empty($catArray))
{
foreach($catArray as $data)
{
	
	if ($_GET['id']==$data['id'])
	{
	$activefirst='class="active"';
	}else{
		$activefirst='';
	}
$menu.='<li><a '.$activefirst.' href="index.php?module=chart&event=index&id='.$data['id'].'">'.$data['name'].'</a></li>';

	
	}
	return $menu;
}
return false;
	}
	
	function getchartsubmenu($id){
		
	$catArray	=	$this->db->getResult("select parent from tbl_chart p where p.id = '".$id."' AND p.status  = '1'",true);
	if ($catArray['0']['parent'])
	{
	$data	=	$this->db->getResult("select id,name from tbl_pages p where p.id = '".$catArray['0']['parent']."' AND p.status  = '1'",true);
	if(!empty($data)) 
	{$menu.=' <li><b>'.$data[0]["name"].'</b></li>';
	$menu.=$this->checkindicess($data[0]["id"]);
	}
	}
	
	//print_r($catArray);
return $menu;
	}
	
	function checkpagesection($id,$section)
	{
	$catArray	=	$this->db->getResult("select mainmenu from tbl_pages p where p.id = '".$id."' AND p.status  = '1'",true);
	if ($catArray[0]['mainmenu']==$section)
	return true;
	return false;
	}
	
}
?>