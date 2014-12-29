<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
       {include file="extrahead.tpl"}
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
                        <h1><i class="icon-file-alt"></i>Corporate Actions Index</h1>
                    </div>
                </div>
                <!-- END Page Title -->

                <!-- BEGIN Breadcrumb -->
                <div id="breadcrumbs">
                    <ul class="breadcrumb">
                        <li>
                            <i class="icon-home"></i>
                            <a href="index.html">Home</a>
                            <span class="divider"><i class="icon-angle-right"></i></span>
                        </li>
                        <li class="active">Corporate Actions Index</li>
                    </ul>
                </div>
                <!-- END Breadcrumb -->

                <!-- BEGIN Main Content -->
               
                

                

                

                <div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-table"></i> Big one</h3>
                                <div class="box-tool">
                                    <a data-action="collapse" href="#"><i class="icon-chevron-up"></i></a>
                                    <a data-action="close" href="#"><i class="icon-remove"></i></a>
                                </div>
                            </div>
                            <div class="box-content">
                                <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Username</th>
                                            <th style="width: 150px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Mark</td>
                                            <td>Otto<span class="label label-info pull-right"><i class="icon-twitter"></i> New Twitte</span></td>
                                            <td>@mdo<span class="badge badge-info pull-right">+10</span></td>
                                            <td>
                                                <a class="btn btn-primary btn-small" href="#"><i class="icon-edit"></i> Edit</a>
                                                <a class="btn btn-danger btn-small" href="#"><i class="icon-trash"></i> Delete</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Jacob</td>
                                            <td>Thornton</td>
                                            <td>@fat</td>
                                            <td>
                                                <a class="btn btn-primary btn-small" href="#"><i class="icon-edit"></i> Edit</a>
                                                <a class="btn btn-danger btn-small" href="#"><i class="icon-trash"></i> Delete</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Larry <span class="label label-success label-small pull-right">New User</span></td>
                                            <td>the Bird</td>
                                            <td>@twitter</td>
                                            <td>
                                                <a class="btn btn-primary btn-small" href="#"><i class="icon-edit"></i> Edit</a>
                                                <a class="btn btn-danger btn-small" href="#"><i class="icon-trash"></i> Delete</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
