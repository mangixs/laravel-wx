@extends('public.list')
@section('content')
<div class="head container-fluid">
	<div class="row">
		<span class="title">{{ $title }}</span>
		@if( in_array('add',$key['auth_key']) )
		<button type="button"  class="btn btn-success btn-right" onclick="parent.adminObj.add('/article/add','添加文章')" >添加</button>
		<button type="button"  class="btn btn-success btn-right" onclick="parent.adminObj.add('/article/type','文章类型设置')" >类型</button>
		@endif
	</div>
</div>
<div class="content container-fluid">
	<div class="search-box">
		<form class="form-inline" id="search_form">
			<div class="row">
				<div class="form-group">
					<label for="exampleInputName2">请输入标题</label>
					<input type="text" class="form-control" id="exampleInputName2" placeholder="请输入标题" name="like:title">
				</div>
			</div>
		</form>
	</div>
	<div class="data-show">
		<table class="table table-bordered">
		   <thead>
		      	<tr class="active">
		         	<th>首图</th>
		        	<th>标题</th>
		        	<th>类型</th>
		        	<th>更新时间</th>
		        	<th>排序</th>
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
    <td><img src="<%= first_img  %>" width="100px" height="100px" /></td>
    <td><%= title  %></td>
    <td><%= type  %></td>
    <td><%= update_at %></td>
    <td><%= sort %></td>
    <td>
    	<a href="javascript:parent.adminObj.edit('/article/edit/<%=id%>/browse','查看');" class="list-btn browse"></a>
    	@if( in_array('edit',$key['auth_key']) )
    	<a href="javascript:parent.adminObj.edit('/article/edit/<%=id%>/edit','编辑文章');" class="list-btn edit" ></a>
    	@endif
    	@if( in_array('delete',$key['auth_key']) )
    	<a href="javascript:parent.adminObj.deleteData('/article/deleteArticle/<%=id%>');" class="list-btn del" ></a>
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
	    url:'/article/pageData',
	    tpl:'data_tpl',
	});
	pageObj=new managerPage($('.page_box'));
	dataObj.setPage(pageObj);
	dataObj.setSearch($('#search_form'),true);
    dataObj.get_data();
})
</script>
@endsection