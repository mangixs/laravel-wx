<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta name="renderer" content="webkit">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">	
	<title>后台主页</title>
	<link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/css/home.css">
</head>
<body>
<header class="container-fluid">
	<a class="brand" href="{{ url('/') }}">
		<img src="/media/image/logo.png" alt="logo"/>
	</a>	       
	<ul class="nav pull-right">
		<li class="dropdown user">
			<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" id="userinfo">
			@if( !empty($img) )	
				<img class="head_img" src="{{ $img }}" />
			@endif
			<span class="username">{{ $named }}</span>
			<i class="icon-angle-down"></i>
			</a>
			<ul class="dropdown-menu" style="min-width:120px;">
				<li><a href="javascript:adminObj.edit('/home/pwd','修改密码');"><i class="icon-user"></i>修改密码</a></li>
				<li><a href="{{ url('/loginOut') }}"><i class="icon-key"></i>退出登录</a></li>
			</ul>
		</li>
	</ul>	
</header>
<main>
	<div class="left">
		<?=$menu?>
	</div>
	<div class="content">
		<iframe src="{{ url('/login/welcome') }}" id="list" name="list"></iframe>
	</div>
</main>
@section('javascript')
<script src="/js/jquery-3.0.0.min.js" type="text/javascript"></script>  
<script src="/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/layer/layer.js" type="text/javascript"></script>
<script src="/js/jq_notice.js" type="text/javascript"></script>
<script src="/js/admin.js" type="text/javascript"></script>
@show
</body>
</html>