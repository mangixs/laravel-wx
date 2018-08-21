<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    @section('css')
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="/css/edit.css">
    @show
</head>
<body>
@section('content')

@show
@section('btn')
<div class="btn_box">
	<button type="button" class="btn btn-success" data-btn="submit">保存</button>
</div>
@show
@section('javascript')
<script src="/js/jquery-3.0.0.min.js" type="text/javascript"></script>
<script src="/js/input_allow.js" type="text/javascript"></script>
<script src="/js/edit.js" type="text/javascript"></script>
@show
</body>
</html>