@extends('public.edit')

@section('css')
@parent
<style type="text/css">
.line{
	width:100%;
	height:40px;
	box-sizing:border-box;
	border-top:1px solid #b2b2b2;
	font-size:16px;
}
.th{
	width:24.5%;
	height:inherit;
	display:inline-block;
	text-align:center;
	line-height:40px;
	color:black;
}
h1{
	text-align:center;
	font-size:20px;
	color:#0b78e3;
	font-weight:normal;
	line-height:50px;
}
.th a{
	color:#0b78e3;
	text-decoration:none;
}
.list-data{
	box-sizing:border-box;
	border-bottom:1px solid #b2b2b2;
	margin-bottom:50px;
}
.th-bg{
	background:#ebebeb;
}
.text{
	font-size:14px;
}
.row{
	position:relative;
}
.add-action{
	position:absolute;
	padding:5px 15px;
	color:white;
	text-align:center;
	background:green;
	top:15px;
	border:none;
	right:50px;
	cursor:pointer;
}
.detail{
	display:none;
	margin-top:30px;
}
.blue{
	padding:5px 15px;
	color:white;
	text-align:center;
	background:green;
	border:none;
	cursor:pointer;	
}
</style>
@endsection
@section('content')
<div class="detail_box">
	<div class="row">
		<h1>分类管理</h1>
		<button type="button" class="add-action">添加</button>
	</div>
	<div class="line th-bg">
		<div class="th">序号</div>
		<div class="th">名称</div>
		<div class="th">添加时间</div>
		<div class="th">操作</div> 
	</div>
	<div class="list-data">
		
	</div>
	<div class="detail">
		<div class="detail-row">
			<div class="row-label" style="width:40%;" >
    			<span class="must">名称:</span>
    		</div>
    		<div class="row-input" style="width:60%;" >
    			<form id="add">
	    			<input type="text" name="named" placeholder="请输入广告类型名称" maxlength="12">
	    			{{ csrf_field() }}
	    		</form>
    		</div>			
		</div>
		<div class="row" style="text-align:center;margin-top:20px;">
	        <button type="button" class="btn btn-success" >保存</button>
	    </div>
	</div>
</div>
@section('btn')
@endsection
@endsection
@section('javascript')
@parent
<script type="text/javascript" src="/js/template.min.js"></script> 
<script type="text/javascript">
class active{
	constructor(){
		$(".btn").bind('click',this.save.bind(this));
		$(".add-action").bind('click',this.add);
		this.getData();
	}
	add(){
		let addBox=$(".detail");
		if ( addBox.is(':visible') ) {
			$(".add-action").html('添加');
			addBox.hide();
		}else{
			$(".add-action").html('关闭');
			addBox.show();			
		}
	}
	save(){
		let named = $("input[name='named']").val();
		if ( named  == '') {
			parent.$.warn("请输入活动名称");
			return;
		}
		$.ajax({
			url:'/slide/typeSave',
			type:'post',
			data:$("#add").serialize(),
			error:()=>{
				parent.$.warn('服务器忙');
			},
			success:function(res){
				if (res.result == 'SUCCESS') {
					$("input[name='named']").val('');
					parent.$.suc(res.msg);
					this.getData();
				}else{
					parent.$.warn(res.msg);
				}
			}.bind(this)
		})
	}
	getData(){
		$.ajax({
			url:'/slide/typeData',
			type:'get',
			error:()=>{
				parent.$.warn("服务器忙");
			},
			success:(res)=>{
				if ( res.result == 'SUCCESS' ) {
					let box=$(".list-data");
					let tpl='list';
					box.html('');
					$.each(res.data,(k,v)=>{
						box.append( template.render(tpl,v) );
					})
				}else{
					parent.$.warn(res.msg);
				}
			}
		})
	}
	deleteActive(id){
		if ( !confirm('确定删除该广告类型吗？') ) {
			return;
		}
		$.ajax({
			url:'/slide/deleteSlideType/'+id,
			type:'get',
			error:()=>{
				parent.$.warn('服务器忙');
			},
			success:function(res){
				if ( res.result == 'SUCCESS' ) {
					parent.$.suc(res.msg);
					this.getData();
				}else{
					parent.$.warn(res.msg);
				}
			}.bind(this)
		})
	}
}
const activeObj = new active();
</script>
<script type="text/heml" id="list">
<div class="line">
	<div class="th text"><%= id %></div>
	<div class="th text"><%= named %></div>
	<div class="th text"><%= insert_at %></div>
	<div class="th text"><a href="javascript:activeObj.deleteActive(<%= id %>);">删除</a></div>
</div>	
</script>
@endsection