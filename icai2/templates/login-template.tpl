<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
       
        
        {include file="extrahead.tpl"}
    </head>
    <body class="login-page">
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <!-- BEGIN Main Content -->
        <div class="login-wrapper">
            <!-- BEGIN Login Form -->
          
            <form id="form-login" action="" method="post"> 
                <h3>Login to your account</h3>
                 {include file="notice.tpl"}
                <hr/>
                <div class="control-group">
                    <div class="controls">
                        <input type="text" name="Username" placeholder="Email" class="input-block-level" />
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <input type="password" placeholder="Password" name="Password" class="input-block-level" />
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <label class="checkbox">
                            <input type="checkbox" value="remember" name="rememberme" /> Remember me
                        </label>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" name="submit" class="btn btn-primary input-block-level">Sign In</button>
                    </div>
                </div>
                <hr/>
                <p class="clearfix">
                    <a href="index.php?module=dblogin" class="goto-forgot pull-left">Database User? Login Here</a><br>
                          <a href="index.php?module=itlogin" class="goto-forgot pull-left">IT User? Login Here</a>
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
