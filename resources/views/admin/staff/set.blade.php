@extends('public.edit')

@section('css')
<style type="text/css">
*{
	font-family:"Microsoft YaHei";
	margin:0;
	padding:0;
}
.box{
	padding-top:20px;
}
.row{
	width:100%;
	height:30px;
	line-height:30px;
	font-size:14px;
}
.label{
	width:40%;
	text-align:right;
	float:left;
	position:relative;
	height:inherit;
}
.label input{
	position:absolute;
	top:8px;
	right:15px;
	width:15px;
	height:15px;
	cursor:pointer;
}
.content{
	float:left;
	height:inherit;
	width:59%;
}	
</style>
@endsection

@section('content')
	<div class="box">
		@foreach($data as $v)
			<div class="row">
				<div class="label">
					<input type="checkbox" class="job" value="{{ $v->id }}" @if(in_array($v->id,$has))   checked="checked" @endif >
				</div>
				<div class="content">
					<span>{{  $v->job_name }}</span>
				</div>
			</div>
		@endforeach
	</div>
	{{ csrf_field() }}
@endsection
@section('btn')

@endsection
@section('javascript')
@parent
<script type="text/javascript">
$(function(){
	let staff_id={{  $staff_id }};
	$(".job").click(function(){
		let self = $(this);
		let val = self.val();
		let set = self.is(':checked');
		let data='staff_id='+staff_id+'&job_id='+val+'&set='+set+'&_token='+$("input[name='_token']").val();
		let config={
			url:"{{ url('staff/setSave') }}",
			data:data,
			type:'post',
			success:function(res){
				parent.$.suc(res.msg);
			},
		}
		$.ajax(config);
	})
})
</script>
@endsection