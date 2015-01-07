<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
     
       {include file="extrahead.tpl"}
        <!--basic scripts-->
        <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>-->
        <script>window.jQuery || document.write('<script src="{$BASE_URL}assets/assets/jquery/jquery-1.10.1.min.js"><\/script>')</script>
        {include file="extrafooter.tpl"}
        
       
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

       
        {include file="theme-setting.tpl"}
       
       {include file="header.tpl"}

        <!-- BEGIN Container -->
        <div class="container-fluid" id="main-container">
           
            {include file="sidebar.tpl"} 
            
  <div id="main-content">
                <!-- BEGIN Page Title -->
                <div class="page-title">
                    <div>
                        <h1><i class="icon-file-alt"></i>{$pagetitle}</h1>
                        
                    </div>
                </div>
                <!-- END Page Title -->

                <!-- BEGIN Breadcrumb -->
                <div id="breadcrumbs">
                    <ul class="breadcrumb">
                        <li>
                            <i class="icon-home"></i>
                            <a href="index.php?module=home">{$breadcrumbs.0.name}</a>
                            <span class="divider"><i class="icon-angle-right"></i></span>
                        </li>
                        <li class="active"  style="width:85%">{$bredcrumssubtitle}</li>
                        <li style="text-align:right !important;"><a href="#" onClick="history.go(-1)">Back</a></li>
                    
                    
                    </ul>
                </div>
                <!-- END Breadcrumb -->

            <!-- BEGIN Content -->
   {$body}
     <!-- END Content -->
                   {include file="footer.tpl"}
            </div>

        </div>
        <!-- END Container -->


   
    </body>
</html>
