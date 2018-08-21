<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>网站后台登录</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<link href="/media/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="/media/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
	<link href="/media/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	<link href="/media/css/style-metro.css" rel="stylesheet" type="text/css"/>
	<link href="/media/css/style.css" rel="stylesheet" type="text/css"/>
	<link href="/media/css/style-responsive.css" rel="stylesheet" type="text/css"/>
	<link href="/media/css/default.css" rel="stylesheet" type="text/css" id="style_color"/>
	<link href="/media/css/uniform.default.css" rel="stylesheet" type="text/css"/>
	<link href="/media/css/login-soft.css" rel="stylesheet" type="text/css"/>
	<style type="text/css" media="screen">
		.captcha{
			width:100px;
			height:34px;
			cursor:pointer;
		}
		.click{
			color:white;
		}	
	</style>
</head>
<body class="login">
	<div class="logo">
		<img src="/media/image/logo-big.png" alt="" /> 
	</div>
	<div class="content">
		<form class="form-vertical login-form">
			{{ csrf_field() }}
			<h3 class="form-title">Login to your account</h3>
			<div class="control-group">
				<label class="control-label visible-ie8 visible-ie9">Username</label>
				<div class="controls">
					<div class="input-icon left">
						<i class="icon-user"></i>
						<input class="m-wrap placeholder-no-fix" type="text" placeholder="Username" name="username"/>
					</div>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label visible-ie8 visible-ie9">Password</label>
				<div class="controls">
					<div class="input-icon left">
						<i class="icon-lock"></i>
						<input class="m-wrap placeholder-no-fix" type="password" placeholder="Password" name="password"/>
					</div>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label visible-ie8 visible-ie9">Captcha</label>
				<div class="controls">
					<div class="input-icon left">
						<i class="icon-lock"></i>
						<input class="m-wrap placeholder-no-fix" type="text" placeholder="Captcha" name="captcha"/>
					</div>
				</div>
			</div>
			<div class="form-actions">
				<img src="/captcha" class="captcha" onclick='this.src=this.src+"?c="+Math.random()' alt="点击图片刷新">
				<span class="click">点击图片刷新</span>
				<button type="button" class="btn blue pull-right">
				Login <i class="m-icon-swapright m-icon-white"></i>
				</button>            
			</div>
		</form>
	</div>
	<div class="copyright">
		2018 &copy; 广西小易科技
	</div>
	<script src="/media/js/jquery-1.10.1.min.js" type="text/javascript"></script>
	<script src="/media/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<script src="/media/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>      
	<script src="/media/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="/js/jq_notice.js" type="text/javascript"></script>
	<script src="/js/login.js" type="text/javascript" ></script>
	<!--[if lt IE 9]>
	<script src="/media/js/excanvas.min.js"></script>
	<script src="/media/js/respond.min.js"></script>  
	<![endif]-->   
</body>
</html>