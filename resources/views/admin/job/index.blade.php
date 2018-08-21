@extends('public.list')
@section('content')
<div class="head container-fluid">
	<div class="row">
		<span class="title">{{ $title }}</span>
		@if( in_array('add',$key['auth_key']) )
		<button type="button"  class="btn btn-success btn-right" onclick="parent.adminObj.add('/job/add','添加职位')" >添加</button>
		@endif
	</div>	
</div>
<div class="content container-fluid">
	<div class="search-box">
		<form class="form-inline" id="search_form">
			<div class="row">
				<div class="form-group">
					<label for="exampleInputName2">请输入职位名</label>
					<input type="text" class="form-control" id="exampleInputName2" placeholder="请输入职位名" name="like:job_name">
				</div>
			</div>
		</form>
	</div>
	<div class="data-show">
		<table class="table table-bordered">
		   <thead>
		      	<tr class="active">
		         	<th>名称</th>
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
    <td><%= job_name %></td>
    <td>
    	<a href="javascript:parent.adminObj.edit('/job/edit/<%=id%>/browse','查看');" class="list-btn browse"></a>
    	@if( in_array('edit',$key['auth_key']) )
    	<a href="javascript:parent.adminObj.edit('/job/edit/<%=id%>/edit','编辑');" class="list-btn edit" ></a>
    	@endif
    	@if( in_array('delete',$key['auth_key']) )
    	<a href="javascript:parent.adminObj.deleteData('/job/deleteJob/<%=id%>');" class="list-btn del" ></a>
    	@endif
    	@if( in_array('edit',$key['auth_key']) )
    	<a href="javascript:parent.adminObj.edit('/job/set/<%=id%>','设置权限');" class="list-text" >设置权限</a>
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
	    url:'/job/pageData',
	    tpl:'data_tpl',
	});	
	pageObj=new managerPage($('.page_box'));
	dataObj.setPage(pageObj);
	dataObj.setSearch($('#search_form'),true);
    dataObj.get_data();
})
</script>
@endsection