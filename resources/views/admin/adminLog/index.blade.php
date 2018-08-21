@extends('public.list')
@section('content')
<div class="head container-fluid">
	<div class="row">
		<span class="title">{{ $title }}</span>
	</div>	
</div>
<div class="content container-fluid">
	<div class="search-box">
		<form class="form-inline" id="search_form">
			<div class="row">
				<div class="col-xs-4">
					<div class="form-group">
						<label for="exampleInputName2">功能名称:</label>
						<input type="text" class="form-control" id="exampleInputName2" placeholder="功能名称" name="like:staff_log.obj_name">
					</div>
				</div>
				<div class="col-xs-4">
					<div class="col-xs-4 search-left">管理员:</div>
					<div class="col-xs-8 search-right">
						<select name="equal:staff_log.staff_id" class="form-control" style="width:90%">
							<option value="-1">请选择管理员</option>
							<?php foreach( $staff as $v ): ?>
								<option value="{{ $v->id }}">{{ $v->true_name }}</option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			</div>
		</form>
		<div class="row">
			<form class="form-inline">
				<div class="col-xs-4">
					<div class="form-group">
						<label for="exampleInputName2">开始时间:</label>
						<input type="datetime-local" class="form-control" name="start">
					</div>
				</div>
				<div class="col-xs-4">				
					<div class="col-xs-4 search-left">结束时间:</div>
					<div class="col-xs-8 search-right">
						<input type="datetime-local" class="form-control" name="end">
					</div>				
				</div>
				<div class="col-xs-4">
					<button class="btn-success btn" type="button">搜索</button>
				</div>
			</form>
		</div>		
	</div>
	<div class="data-show">
		<table class="table table-bordered">
		   <thead>
		      	<tr class="active">
		         	<th>管理员名称</th>
		         	<th>操作方法</th>
		         	<th>操作功能</th>
		         	<th>登录ip地址</th>
		         	<th>操作时间</th>
		        	<th>操作</th>
		      	</tr>
		   </thead>
		   <tbody id="data_box">
		      	
		   </tbody>
		</table>
	</div>
	<div class="page_box container-fluid"></div>	
</div>
<script type="text/html" id="data_tpl">
<tr>
    <td><%= true_name %></td>
    <td><%= methods %></td>
    <td><%= obj_name %></td>
    <td><%= client_ip %></td>
    <td><%= obj_time %></td>
    <td>
    	<a href="javascript:parent.adminObj.edit('/admin/adminLog/edit/<%= staff_id %>/<%= insert_at %>','查看');" class="list-btn browse"></a>
    	@if( in_array('delete',$key['auth_key']) )
    	<a href="javascript:parent.adminObj.deleteData('/admin/adminLog/deleteLog/<%= staff_id %>/<%= insert_at %>');" class="list-btn del" ></a>
    	@endif
    </td>
</tr>	
</script>
@endsection

@section('javascript')
@parent
<script type="text/javascript">
var dataObj=null;
var pageObj=null; 
$(function(){	
	dataObj=new adminGetData({
	    box:$('#data_box'),
	    url:'/admin/adminLog/pageData',
	    tpl:'data_tpl',
	});	
	pageObj=new managerPage($('.page_box'));
	dataObj.setPage(pageObj);
	dataObj.setSearch($('#search_form'),true);
    dataObj.get_data();
    $(".btn").click(function(){
    	let start = $("input[name='start']").val();
    	let end = $("input[name='end']").val();
    	dataObj.setBaseCondition({'start':start});
    	dataObj.setBaseCondition({'end':end});
    	dataObj.get_data();
    })
})
</script>
@endsection