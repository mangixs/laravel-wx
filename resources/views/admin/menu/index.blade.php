@extends('public.list')

@section('content')
<div class="head container-fluid">
	<div class="row">
		<span class="title">{{ $title }}</span>
		@if( in_array('add',$key['auth_key']) )
		<button type="button"  class="btn btn-success btn-right" onclick="parent.adminObj.add('/menu/add/0','添加菜单')" >添加</button>
		@endif
	</div>	
</div>
<div class="content container-fluid">
	<div class="search-box">
		<form class="form-inline" id="search_form">
			<div class="row">
				<div class="form-group">
					<label for="exampleInputName2">名称/链接</label>
					<input type="text" class="form-control" id="exampleInputName2" placeholder="请输入名称/链接" name="like:named,url">
				</div>
			</div>
		</form>
		{{ csrf_field() }}
	</div>
	<div class="table-title">
		<div class="table-th">名称</div>
		<div class="table-th">链接</div>
		<div class="table-th">层级</div>
		<div class="table-th">排序</div>
		<div class="table-th">操作</div>
	</div>
	<div class="table-box">
		
	</div>
</div>
<div class="page_box container-fluid"></div>
<script type="text/html" id='menu_tpl'>
<div class="table-tr" data-class="<%=id%>" >
	<div class="table-td child" title="显示子菜单" onclick="showChild(<%= id %>)" ><%= named %></div>
	<div class="table-td"><%= url %></div>
	<div class="table-td"><%= level %></div>
	<div class="table-td"><%= sort %></div>
	<div class="table-td">
		<a href="javascript:parent.adminObj.edit('/menu/edit/<%=id%>/browse','查看菜单');" class="list-btn browse"></a>
		@if( in_array('edit',$key['auth_key']) )
    	<a href="javascript:parent.adminObj.edit('/menu/edit/<%=id%>/edit','编辑菜单');" class="list-btn edit" ></a>
    	@endif
    	@if( in_array('delete',$key['auth_key']) )
    	<a href="javascript:parent.adminObj.deleteData('/menu/deleteMenu/<%=id%>');" class="list-btn del" ></a>
    	@endif
    	@if( in_array('edit',$key['auth_key']) )
    	<a href="javascript:parent.adminObj.edit('/menu/add/<%=id%>','添加子菜单');" class="list-text" >子菜单</a>
    	@endif
	</div>
</div>	
</script>
@endsection

@section('javascript')
@parent
<script type="text/javascript">
var dataObj=null;
var pageObj=null;	
$(function(){
	dataObj=new adminGetData({
	    box:$('.table-box'),
	    url:'/menu/pageData',
	    tpl:'menu_tpl',
	});	
	pageObj=new managerPage($('.page_box'));
	dataObj.setPage(pageObj);
	dataObj.setSearch($('#search_form'),true);
    dataObj.get_data();
})
function showChild(pid){
	var box=$("[data-class='"+pid+"'");
	if( box.is('.empty_child') ){
		return;
	}
	if( box.next().is('.child_box') ){
		box.next().slideToggle();
		return;
	}
	var config={
		url:'/menu/childMenu',
		data:'pid='+pid+'&_token='+$("input[name='_token']").val(),
		type:'post',
		success:showChildCallback,
		error:function(){
			parent.$.err('获取出现错误!');
		},
	}
	$.ajax(config);
}
function showChildCallback(res){
	switch(res.result){
		case 'EMPTY':
		$("[data-class='"+res.pid+"'").addClass('empty_child');
		break;
		case 'SUCCESS':
		var box=$('<div class="child_box"></div>');
		$.each(res.data,function(k,v){
			v.nameScreen='';
			if( v.level>0 ){
				v.nameScreen+='|';
				for( i=0;i<v.level;i++ ){
					v.nameScreen+='--';
				}
			}
			v.named = v.nameScreen+v.named;
			box.append( template.render('menu_tpl',v) );
		});
		box.css('display','none');
		$("[data-class='"+res.pid+"'").after( box );
		box.slideToggle();
		break;
		default:
		$.err( res.msg );
		break;
	}
}
</script>
@endsection