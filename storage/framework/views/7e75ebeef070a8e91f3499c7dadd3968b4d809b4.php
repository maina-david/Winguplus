
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>WinguPlus | 404 Error Page</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="<?php echo asset('/assets/fonts/main/bundled.fonts.css'); ?>" rel="stylesheet">
	<link href="<?php echo asset('/assets/plugins/jquery-ui/jquery-ui.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo asset('/assets/plugins/bootstrap/4.1.0/css/bootstrap.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo asset('/assets/fonts/fontawesome-5.8/css/all.css'); ?>" rel="stylesheet" />
	<link href="<?php echo asset('/assets/css/default/style.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo asset('/assets/css/default/style-responsive.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo asset('/assets/css/theme/default.css'); ?>" rel="stylesheet" id="theme" />
	<!-- ================== END BASE CSS STYLE ================== -->
</head>
<body class="pace-top">
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade show"><span class="spinner"></span></div>
	<!-- end #page-loader -->
	
	<!-- begin #page-container -->
	<div id="page-container" class="fade">
		<!-- begin error -->
		<div class="error">
			<div class="error-code m-b-10">404</div>
			<div class="error-content">
				<div class="error-message">
               The page you tried to visit doesn't exist.<br>This is usually caused by an incorrect or outdated link.
            </div>
				<div class="error-desc m-b-30">
               <p>Use your browser's back button and try again, or try one of the following:</p>
               <ul style="list-style: none;">
                  <li><a href="<?php echo url('/'); ?>">WinguPlus home page</a></li>
                  <li><a href="<?php echo url('/'); ?>">Sign up for a free account</a></li>
                  <li><a href="<?php echo url('/'); ?>">Sign in</a></li>
                  <li><a href="<?php echo url('/'); ?>">Help Center</a></li>
               </ul>
            </div>            
            <div>
               <a href="<?php echo url('/'); ?>" class="btn btn-success p-l-20 p-r-20">Go Home</a>
            </div>
         </div>
		</div>
		<!-- end error -->
	</div>

	
	<!-- end page container -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?php echo asset('/assets/plugins/jquery/jquery-3.2.1.min.js'); ?>"></script>
	<script src="<?php echo asset('/assets/plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>
   <script src="<?php echo asset('/assets/plugins/bootstrap/4.1.0/js/bootstrap.bundle.min.js'); ?>"></script>
	<!--[if lt IE 9]>
		<script src="<?php echo asset('/assets/crossbrowserjs/html5shiv.js'); ?>"></script>
		<script src="<?php echo asset('/assets/crossbrowserjs/respond.min.js'); ?>"></script>
		<script src="<?php echo asset('/assets/crossbrowserjs/excanvas.min.js'); ?>"></script>
	<![endif]-->
	<script src="<?php echo asset('/assets/plugins/slimscroll/jquery.slimscroll.min.js'); ?>"></script>
	<script src="<?php echo asset('/assets/plugins/js-cookie/js.cookie.js'); ?>"></script>
	<script src="<?php echo asset('/assets/js/theme/default.min.js'); ?>"></script>
	<script src="<?php echo asset('/assets/js/apps.min.js'); ?>"></script>
	<!-- ================== END BASE JS ================== -->
	
	<script>
		$(document).ready(function() {
			App.init();
		});
	</script>
</body>
</html><?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/errors/404.blade.php ENDPATH**/ ?>