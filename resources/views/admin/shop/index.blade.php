@extends('public.list')

@section('content')
<div class="head container-fluid">
	<div class="row">
		<span class="title">{{ $title }}</span>
		@if( in_array('add',$key['auth_key']) )		
		<button type="button"  class="btn btn-success btn-right" onclick="parent.parent.adminObj.add('/admin/shop/add','添加商家')" >添加</button>
		@endif
	</div>	
</div>
<div class="content container-fluid">
	<div class="search-box">
		<form class="form-inline" id="search_form">
			<div class="row">
				<div class="form-group">
					<label for="exampleInputName2">公司名称/电话</label>
					<input type="text" class="form-control" id="exampleInputName2" placeholder="请输入公司名称/电话" name="like:title,tel">
				</div>
			</div>
		</form>
	</div>
	<div class="data-show">
		<table class="table table-bordered">
		   <thead>
		      	<tr class="active">
		         	<th>名称</th>
		         	<th>联系人</th>
		        	<th>电话</th>
		        	<th>登录名</th>
		        	<th>操作</th>
		      	</tr>
		   </thead>
		   <tbody id="data_box">
		   </tbody>
		</table>
	</div>
	<div class="page_box container-fluid"></div>
	<script type="text/html" id="data_tpl">
	<tr>
	    <td><%= title %></td>
	    <td><%= contact %></td>
	    <td><%= tel %></td>
	    <td><%= login_name %></td>
	    <td>
	    	<a href="javascript:parent.adminObj.edit('/admin/shop/edit/<%=id%>/browse','查看');" class="list-btn browse"></a>
	    	@if( in_array('edit',$key['auth_key']) )
	    	<a href="javascript:parent.adminObj.edit('/admin/shop/edit/<%=id%>/edit','编辑商家');" class="list-btn edit" ></a>
	    	@endif
	    	@if( in_array('delete',$key['auth_key']) )
	    	<a href="javascript:parent.adminObj.deleteData('/admin/shop/deleteShop/<%=id%>');" class="list-btn del" ></a>
	    	@endif
	    </td>
	</tr>	
	</script>	
</div>
@endsection

@section('javascript')
@parent
<script type="text/javascript">
var dataObj=null;
var pageObj=null; 
$(function(){	
	dataObj=new adminGetData({
	    box:$('#data_box'),
	    url:'/admin/shop/pageData',
	    tpl:'data_tpl',
	});	
	pageObj=new managerPage($('.page_box'));
	dataObj.setPage(pageObj);
	dataObj.setSearch($('#search_form'),true);
    dataObj.get_data();
})	
</script>
@endsection

