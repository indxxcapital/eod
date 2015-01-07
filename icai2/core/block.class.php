<?php

class Block extends Functions{ 
 
	var  $db;

	function __construct($smarty)
	{
		$this->siteconfig = $smarty->siteconfig;
		 
		$dbData['host']=$this->siteconfig->db_host;
		$dbData['user']=$this->siteconfig->db_user;
		$dbData['password']=$this->siteconfig->db_password;
		$dbData['name']=$this->siteconfig->db_name;
		$this->db = new Db($dbData,$this);
		$this->smarty = $smarty;
		$this->smarty->lang = $this->lang = $this->setLang($_SESSION['lang']);
		
		
		$this->_js=array();
		$this->_css=array();
	
			 
	
	}
	
  	function initBlock()
	{
		 
	 	if($_GET)
		{
			$_GET= $this->stripslashes_deep($_GET);
		}
		if($_POST)
		{
		
			$_POST= $this->stripslashes_deep($_POST);	 
			 
		}
		
		if(is_callable(array($this, 'index')))
		{
			
			$this->index();
			
		}
				
				
		$html = "";
	
		if (count($this->_js) > 0){		
			foreach ($this->_js as $data)
			{
				$html.='<script type="text/javascript" src="'.$this->siteconfig->base_url.'assets/'.$this->smarty->tempFolder.'js/'.$data.'"></script>';
			}
		}
		if (count($this->_css) > 0){		
			foreach ($this->_css as $data)
			{
				$html.='<script type="text/javascript" src="'.$this->siteconfig->base_url.'assets/'.$this->smarty->tempFolder.'css/'.$data.'"></script>';
			}
		}
		
		if (count($this->_extraHead) > 0){		
			foreach ($this->_extraHead as $data)
			{
				$html.=$data;
			}
		}
 
 		return $html;
	}
	
	
	public function Redirect($url,$msg="",$type="")
		{

			if($url=="")
			{
				$url='index.php';
			
			}
			 $this->setMessage($msg,$type);
		 
			header("location:".$this->makeUrl($url));	
			exit;
		
		}
		
		
		protected function setMessage($msg="",$type="")
		{
			unset($_SESSION['Message']);
			
			if($msg=="")
			{
				return false;
			}
			
			if($type=="")
			{
				$type = "success";
			}
			
			$_SESSION['Message']['type']=$type;
			$_SESSION['Message']['msg']=$msg;
			return true;
		}
	
	protected function makeUrl($url)
		{
			  $url = str_replace($this->siteconfig->base_url,"",$url);
		 	
 			if($this->siteconfig->rewrite==1)
			{
				if(preg_match("/index.php/",$url,$match))
				{
					$tempUrl = str_replace("index.php?","",$url);
					$tempUrl = str_replace("&amp;","&",$tempUrl);
					$tempUrl = explode("&",$tempUrl);
					
					$queryString="";
					$extraString="";
					foreach($tempUrl as $uri)
					{
					 
						$uriTemp = explode("=",$uri);
						$key= strtolower($uriTemp[0]);
						$queryString[$key]=$uriTemp[1];
						if($key!="module" && $key!="event")
						{
							$extraString.="/".$uriTemp[1];
						}
		  			}
					$url = $queryString['module']."/".$queryString['event'].$extraString; 
				}
				
			} 	
		 	  	$url = $this->siteconfig->base_url.$url;
			 
			return $url;
		
		}

}

?>