<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="renderer" content="webkit" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<title>后台登陆</title>
	<style type="text/css">
	*{
		padding:0;
		margin:0;
	}
	body{
		background-color:#666;
	}
	.middle{
		display: -webkit-box;
	    display: -ms-flexbox;
	    display: -webkit-flex;
	    display: flex;
	    -webkit-box-pack: center;
	    -ms-flex-pack: center;
	    -webkit-justify-content: center;
	    justify-content: center;
	    -webkit-box-align: center;
	    -ms-flex-align: center;
	    -webkit-align-items: center;
	    align-items: center;
	}
	.login{
		width:300px;
		margin:0 auto;
		margin-top:60px;
		text-align:center;
		height:40px;
	}
	.main{
		width:300px;
		margin:0 auto;
	}
	.main h1{
		font-size:24px;
		color:white;
		font-weight:normal;
	}
	.input{
		height:35px;
		background-color:white;
		margin-top:20px;
	}
	.left{
		width:35px;
		float:left;
		height:inherit;
	}
	.username{
		background:url('../images/username.png') center no-repeat;
		background-size:16px 16px;
	}
	.pwd{
		background:url('../images/password.png') center no-repeat;
		background-size:16px 16px;
	}
	.right{
		width:265px;
		float:left;
		height:inherit;
	}
	.right input{
		width:100%;
		height:100%;
		border:none;
		font-size:14px;
		line-height: 35px;
	}
	.right input:focus{
		outline: none;
	}
	.input .captcha{
		width:200px;
		height:inherit;
		float:left;
	}
	.input:last-child{
		background-color:transparent;
	}
	.input .captcha img{
		width:100px;
		height: 35px;
		cursor:pointer;
	}
	.input .login-btn{
		float:right;
		width: 100px;
		height:inherit;
		background-color:#4d90fe;
		text-align:center;
		line-height:35px;
		color:white;
		cursor:pointer;
	}
	</style>
</head>
<body>
	<div class="login">
		<img src="/images/logo-big.png" alt="">
	</div>
	<div class="main">
		<form class="login-form">
			<h1>Login to your account</h1>
			<div class="input">
				<div class="left username"></div>
				<div class="right">
					<input type="text" placeholder="请输入用户名" name="username">
				</div>
			</div>
			<div class="input">
				<div class="left pwd"></div>
				<div class="right">
					<input type="password" placeholder="请输入密码" name="password">
				</div>
			</div>
			<div class="input">
				<div class="left pwd"></div>
				<div class="right">
					<input type="text" name="captcha" placeholder="请输入验证码">
				</div>
			</div>
			{{ csrf_field() }}
			<div class="input">
				<div class="captcha">
					<img src="/captcha" onclick='this.src=this.src+"?c="+Math.random()' alt="点击图片刷新">
				</div>
				<div class="login-btn btn">
					Login
				</div>
			</div>
		</form>
	</div>
	<script src="/js/jquery-3.0.0.min.js" type="text/javascript"></script>
	<script src="/js/jq_notice.js" type="text/javascript"></script>
	<script src="/js/login.js" type="text/javascript" ></script>
</body>
</html>
