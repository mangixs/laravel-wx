@extends('public.list')

@section('content')
<div class="head container-fluid">
	<div class="row">
		<span class="title">{{ $title }}</span>
		@if( in_array('add',$key['auth_key']) )
		<button type="button"  class="btn btn-success btn-right" onclick="parent.adminObj.add('/func/add','添加功能')" >添加</button>
		@endif
	</div>	
</div>
<div class="content container-fluid">
	<div class="search-box">
		<form class="form-inline" id="search_form">
			<div class="row">
				<div class="form-group">
					<label for="exampleInputName2">请输入功能键值</label>
					<input type="text" class="form-control" id="exampleInputName2" placeholder="请输入键值/名称" name="like:key,func_name">
				</div>
			</div>
		</form>
	</div>
	<div class="data-show">
		<table class="table table-bordered">
		   <thead>
		      	<tr class="active">
		         	<th>功能键值</th>
		         	<th>功能名称</th>
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
    <td><%= keys %></td>
    <td><%= func_name %></td>
    <td>
    	<a href="javascript:parent.adminObj.edit('/func/edit/<%=keys%>/browse','查看功能');" class="list-btn browse"></a>
    	@if( in_array('edit',$key['auth_key']) )
    	<a href="javascript:parent.adminObj.edit('/func/edit/<%=keys%>/edit','编辑功能');" class="list-btn edit" ></a>
    	@endif
    	@if( in_array('delete',$key['auth_key']) )
    	<a href="javascript:parent.adminObj.deleteData('/func/deleteFunc/<%=keys%>');" class="list-btn del" ></a>
    	@endif
    	@if( in_array('edit',$key['auth_key']) )
    	<a href="javascript:parent.adminObj.edit('/func/set/<%=keys%>','设置权限')" class="list-text" >编辑权限</a>
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
	    url:'/func/pageData',
	    tpl:'data_tpl',
	});	
	pageObj=new managerPage($('.page_box'));
	dataObj.setPage(pageObj);
	dataObj.setSearch($('#search_form'),true);
    dataObj.get_data();
})
</script>
@endsection