@extends('public.edit')

@section('css')
<link rel="stylesheet" type="text/css" href="/css/job.css">
@endsection

@section('content')
<div class="box">
	<div class="row">
		<div class="label"><span>功能名称</span></div>
		<div class="content">权限</div>
	</div>
</div>
<div class="detail_box">
	<?php  foreach( $func as $f ): ?>
	<?php $own=isset($has[$f->key])?$has[$f->key]:[]; ?>
	<div class="list">
		<div class="list_label"><?=$f->func_name?>:</div>
		<div class="list_content">
			<div class="key_box">
				<input type="checkbox" data-key="export" data-func="<?=$f->key?>" <?=in_array('export',$own)?'checked="checked"':''?> ><span>查看</span>
			</div>
			<?php foreach($f->auth as $a): ?>
				<div class="key_box">
					<input type="checkbox" data-key="<?=$a->key?>" data-func="<?=$f->key?>" <?=in_array($a->key,$own)?'checked="checked"':''?> ><span><?=$a->auth_name?></span>
				</div>
			<?php endforeach; ?>	
		</div>
	</div>
	<?php endforeach; ?>
	{{ csrf_field() }}
</div>
@endsection

@section('btn')

@endsection

@section('javascript')
@parent
<script type="text/javascript">
var jobId=<?=$admin_job_id?>;
$(function(){
	$("input[type='checkbox']").click(setAuth);
})
function setAuth(){
	var self=$(this);
	var key=self.attr('data-key');
	var func=self.attr('data-func');
	var data='admin_job_id='+jobId+'&auth_key='+key+'&func_key='+func+'&_token='+$("input[name='_token']").val();
	var config={
		url:'/job/setSave',
		data:data,
		type:'post',
		success:function(res){
			parent.$.suc(res.msg);
		},
		error:function(){
			parent.$.err('出现错误!');
		}
	}
	$.ajax(config);
}
</script>
@endsection