@extends('public.list')

@section('content')
<div class="head container-fluid">
	<div class="row">
		<span class="title">{{ $title }}</span>
		@if( in_array('add',$key['auth_key']) )		
		<button type="button"  class="btn btn-success btn-right" onclick="parent.adminObj.add('/staff/add','添加管理员')" >添加</button>
		@endif
	</div>	
</div>
<div class="content container-fluid">
	<div class="search-box">
		<form class="form-inline" id="search_form">
			<div class="row">				
				<div class="form-group">
					<label for="exampleInputName2">登录名/员工编号</label>
					<input type="text" class="form-control" id="exampleInputName2" placeholder="请输入登录名/员工编号" name="like:login_name,staff_num">
				</div>
			</div>
		</form>
	</div>
	<div class="data-show">
		<table class="table table-bordered">
		   <thead>
		      	<tr class="active">
		         	<th>登录名</th>
		         	<th>员工编号</th>
		        	<th>姓名</th>
		        	<th>性别</th>
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
	    <td><%= login_name %></td>
	    <td><%= staff_num %></td>
	    <td><%= true_name %></td>
	    <td><% if(sex ==1 ){ %>男<%}else{%>女<%}%></td>
	    <td>
	    	<a href="javascript:parent.adminObj.edit('/staff/edit/<%=id%>/browse','查看');" class="list-btn browse"></a>
	    	@if( in_array('edit',$key['auth_key']) )
	    	<a href="javascript:parent.adminObj.edit('/staff/edit/<%=id%>/edit','编辑管理员');" class="list-btn edit" ></a>
	    	@endif
	    	@if( in_array('delete',$key['auth_key']) )
	    	<a href="javascript:parent.adminObj.deleteData('/staff/deleteStaff/<%=id%>');" class="list-btn del" ></a>
	    	@endif
	    	@if( in_array('edit',$key['auth_key']) )
	    	<a href="javascript:parent.adminObj.edit('/staff/setJob/<%=id%>','设置职位');" class="list-text" >职位</a>
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
	    url:'/staff/pageData',
	    tpl:'data_tpl',
	});	
	pageObj=new managerPage($('.page_box'));
	dataObj.setPage(pageObj);
	dataObj.setSearch($('#search_form'),true);
    dataObj.get_data();
})	
</script>
@endsection

