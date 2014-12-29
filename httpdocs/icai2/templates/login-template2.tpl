<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="{$BASE_URL}assets/New/css/signin.css">
        {include file="extrahead2.tpl"}
    </head>
    <body class="login-page">
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <!-- BEGIN Main Content -->
        <div class="container">
            <!-- BEGIN Login Form -->
          
            <form id="form-login" class="form-signin" action="" method="post"> 
                <h2 class="form-signin-heading" style="text-transform:none !important; color:#5f8196 !important;font: bold 28px/28px Arial,Helvetica Neue, Helvetica, Arial, sans-serif !important;"> Login to your account</h2>
                
                 {include file="notice.tpl"}
               
                        <input type="text" name="Username" placeholder="Email" class="form-control" required autofocus/>
                    
              
                        <input type="password" placeholder="Password" name="Password" class="form-control" required/>
                    
               
                        <label class="checkbox" style="font-size:14px !important;">
                            <input type="checkbox" value="remember-me" name="rememberme" /> Remember me
                        </label>
                    
               
                        <button type="submit" name="submit" class="btn btn-lg btn-primary btn-block">Sign In</button>
                  
                <p class="clearfix">
                    <a href="index.php?module=dblogin" class="goto-forgot pull-left" style="font-size:14px !important;">Database User? Login Here</a>
                    <!--<a href="#" class="goto-register pull-right">Sign up now</a>
-->                </p>
                
            </form>
           
        </div>
        <!-- END Main Content -->

        <!--basic scripts-->
        <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>-->
        <script>window.jQuery || document.write('<script src="{$BASE_URL}assets/assets/jquery/jquery-1.10.1.min.js"><\/script>')</script>
              {include file="extrafooter.tpl"}
			
       {literal} <script type="text/javascript">
            function goToForm(form)
            {
                $('.login-wrapper > form:visible').fadeOut(500, function(){
                    $('#form-' + form).fadeIn(500);
                });
            }
            
        </script>
        {/literal}
    </body>
</html>
