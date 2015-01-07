<?php

class Pager{
  /*********************************************************************************** 
   * int findStart (int limit) 
   * Returns the start offset based on $_GET['page'] and $limit 
   ***********************************************************************************/ 
   function findStart($limit){
	 if ((!isset($_GET['page'])) || ($_GET['page'] == "1")) 
      { 
       $start = 0;
       $_GET['page'] = 1;
      }
     else
      { 
       $start = ($_GET['page']-1) * $limit; 
      } 
     return $start; 
    } 
  /*********************************************************************************** 
   * int findPages (int count, int limit) 
   * Returns the number of pages needed based on a count and a limit 
   ***********************************************************************************/ 
   function findPages($count, $limit){
     $pages = (($count % $limit) == 0) ? $count / $limit : floor($count / $limit) + 1; 
     return $pages; 
    } 
  /*********************************************************************************** 
   * string pageList (int curpage, int pages) 
   * Returns a list of pages in the format of "« < [pages] > »" 
   ***********************************************************************************/ 
   function pageList($curpage, $pages){
    $page_list  = "";
	 $str = "";
	 foreach( $_GET as $key=>$value)
	 {
	    if ($key=="message" || $key=="page" || $key=="pagegroup"){}
		else
		{
			if(is_array($_GET[$key]))
			{
					foreach($_GET[$key] as $keys => $values)
					{
					
					$str = $str."&".$key."[".$keys."]=".$values;	
					
					}
			}
			else
			{
		 		$str = $str."&".$key."=".$value;
			}
		 
		 }
	 }	  
	foreach( $_POST as $key=>$value)
	{
		if ($key=="message" || $key=="page" || $key=="pagegroup"){}
		else
		{
			if(is_array($_POST[$key]))
			{
					foreach($_POST[$key] as $keys => $values)
					{
					
					$str = $str."&".$key."[".$keys."]=".$values;	
					
					}
			}
			else
			{
		 		$str = $str."&".$key."=".$value;
			}
		
		}
		
	}	  

  $pagegroup = $_REQUEST['pagegroup'];
$limitset = 10;
if ($pagegroup== ""){
	    $pagegroup = 1;
		}
      //Print the first and previous page links if necessary  
  /*  if (($curpage != 1) && ($curpage)) 
      { 
	    $str1 = $str . "&pagegroup=1";
       $page_list .= "  <a href=\"".$_SERVER['PHP_SELF']."?page=1".$str1."\" title=\"First Page\">&laquo;Previous</a> "; 
      } */
	  $page_list .= " <ul id=\"pagination-digg\">";
  	 $prevgrouppage = ($pagegroup - 1) * ($limitset);
	if (($prevgrouppage) > 0) 
    { 
	   $str1 = $str . "&pagegroup=" . ($pagegroup-1);
	   $spage = ($limitset*($pagegroup-1)) + 1 - $limitset;
       $page_list .= "<li class=\"previous\"><a href=\"".$_SERVER['PHP_SELF']."?page=".($spage).$str1."\" title=\"Previous Page\" > &laquo;Previous</a></li>";
    } 	else
	{
	//$page_list .= '<li class="previous-off">&laquo;Previous</li>';
	} 
  	$startpage = (($pagegroup - 1) * $limitset);
     /* Print the numeric page list; make the current page unlinked and bold */ 
	  
     for ($i=$startpage+1; $i<=$pages; $i++) 
     { 
	    $str1 = $str . "&pagegroup=" . $pagegroup;
	  if ($i > ($startpage + $limitset))
		      break;
       if ($i == $curpage) 
       { 
	        // c h a n g e   l i n k s   c l a s s    h e r e
           $page_list .= ""."<li class=\"active\">".$i."</li>"; 
       } 
       else 
       { 
         $page_list .= "<li><a href=\"".$_SERVER['PHP_SELF']."?page=".$i.$str1."\" title=\"Page ".$i."\">".$i."</a></li>";
       } 
       $page_list .= " "; 
     } 
	 
    $nextgrouppage = $pagegroup * $limitset;
     /* Print the Next and Last page links if necessary */ 
     if (($nextgrouppage+1) <= $pages) 
     { 
	   $str1 = $str . "&pagegroup=" . ($pagegroup+1);
	   $spage = ($limitset*$pagegroup) + 1;
	   $page_list .= "<li class=\"nextpage\"><a href=\"".$_SERVER['PHP_SELF']."?page=".($spage).$str1."\"  title=\"next PageSet\">Next </a></li>";
     } else
	{
 //  $page_list .= '<li class="next-off">Next &raquo;</li>';
	} 
      $page_list .= "</ul>";
	 
     return $page_list; 
    } 
  /*********************************************************************************** 
   * string nextPrev (int curpage, int pages) 
   * Returns "Previous | Next" string for individual pagination (it's a word!) 
   ***********************************************************************************/ 
   function nextPrev($curpage, $pages) 
   { 
     $next_prev  = ""; 
     $page_list  = "";
	 $str = "";
	 foreach( $_GET as $key=>$value)
	 {
	    if ($key=="message" || $key=="page"){}
		else
		 $str = $str."&".$key."=".$value;
	 }
	 foreach( $_POST as $key=>$value)
	 {
	    if ($key=="message" || $key=="page"){}
		else
		 $str = $str."&".$key."=".$value;
	   }	  	  
     if (($curpage-1) <= 0) 
      { 
       $next_prev .= "<span class=normaltextnotbold>"._PREVIOUS_."</span>"; 
      } 
     else 
      { 
       $next_prev .= "<li><a href=\"".$_SERVER['PHP_SELF']."?page=".($curpage-1).$str."\" class=smalla1>"._PREVIOUS_."</a></li>"; 
      } 
     $next_prev .= " <font color=#000000>|</font> "; 
     if (($curpage+1) > $pages) 
      { 
       $next_prev .= "<span class=smalla1>"._NEXT_."</span>"; 
      } 
     else 
      { 
       $next_prev .= "<li><a href=\"".$_SERVER['PHP_SELF']."?page=".($curpage+1).$str."\" class=smalla1>"._NEXT_."</a></li>"; 
      } 
     $next_prev .= "\n";
     return $next_prev; 
    } 
  } 
  
