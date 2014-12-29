<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        {include file="extrahead.tpl"}

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <!--base css styles-->
       
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

            <!-- BEGIN Content -->
            <div id="main-content">
                <!-- BEGIN Page Title -->
                <div class="page-title">
                    <div>
                        <h1><i class="icon-file-alt"></i> Dashboard</h1>
                        <h4>Overview, stats and more</h4>
                    </div>
                </div>
                <!-- END Page Title -->

                <!-- BEGIN Breadcrumb -->
                <div id="breadcrumbs">
                    <ul class="breadcrumb">
                        <li class="active"><i class="icon-home"></i> Home</li>
                    </ul>
                </div>
                <!-- END Breadcrumb -->

                <!-- BEGIN Main Content -->
                <div class="row-fluid">
                    {block file="ic7daysvalues_new" class="block_ic7daysvalues"}{/block}
                     {block file="indxxstatics" class="block_indxxstatics"}{/block}
                   
                </div>

                <div class="row-fluid">
                     {block file="thingstodo" class="block_thingstodo"}{/block}
                      {block file="weeklychanges" class="block_weeklychanges"}{/block}
                    
                </div>

                <div class="row-fluid">
                    
                    <div class="span7">
                        <div class="box box-red">
                            <div class="box-title">
                                <h3><i class="icon-tasks"></i> Tasks In Progress</h3>
                                <div class="box-tool">
                                    <a data-action="collapse" href="#"><i class="icon-chevron-up"></i></a>
                                    <a data-action="close" href="#"><i class="icon-remove"></i></a>
                                </div>
                            </div>
                            <div class="box-content">
                                <ul class="tasks-in-progress">
                                    <li>
                                        <p>
                                            Currency File Read
                                            <span>45%</span>
                                        </p>
                                        <div class="progress progress-mini progress-warning">
                                            <div class="bar" style="width:45%"></div>
                                        </div>
                                    </li>
                                    <li>
                                        <p>
                                            Price Sheet Read
                                            <span>63%</span>
                                        </p>
                                        <div class="progress progress-mini">
                                            <div class="bar" style="width:63%"></div>
                                        </div>
                                    </li>
                                    <li>
                                        <p>
                                            Price Conversion
                                            <span>30%</span>
                                        </p>
                                        <div class="progress progress-mini progress-danger">
                                            <div class="bar" style="width:30%"></div>
                                        </div>
                                    </li>
                                    <li>
                                        <p>
                                            New Divisor calculation for closing file
                                            <span>80%</span>
                                        </p>
                                        <div class="progress progress-mini progress-success">
                                            <div class="bar" style="width:80%"></div>
                                        </div>
                                    </li>
                                    <li>
                                        <p>
                                            Closing File with corporate actions
                                            <span>35%</span>
                                        </p>
                                        <div class="progress progress-mini progress-striped">
                                            <div class="bar" style="width:35%"></div>
                                        </div>
                                    </li>
                                    <li>
                                        <p>
                                            Opening File with corporate actions
                                            <span>55%</span>
                                        </p>
                                        <div class="progress progress-mini progress-warning progress-striped">
                                            <div class="bar" style="width:55%"></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                
                <!-- END Main Content -->
                
               {include file="footer.tpl"}
            </div>
            <!-- END Content -->
        </div>
        <!-- END Container -->


        <!--basic scripts-->
        <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>-->
        <script>window.jQuery || document.write('<script src="{$BASE_URL}assets/assets/jquery/jquery-1.10.1.min.js"><\/script>')</script>
        {include file="extrafooter.tpl"}

    </body>
</html>
