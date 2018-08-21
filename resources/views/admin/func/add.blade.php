@extends('public.edit')

@section('content')
<div class="detail">
    <form id="edit_form" data-action='/func/save' >
        <input type="hidden" value="{{ $action }}" name="action">
    	<div class="detail-row">
    		<div class="row-label">
    			<span class="must">功能键值:</span>
    		</div>
    		<div class="row-input">
    			<input type="text" name="keys" placeholder="请输入功能键值" maxlength="16" data-allow="en" >
    		</div>
    	</div>
        <div class="detail-row">
            <div class="row-label">
                <span>功能名称:</span>
            </div>
            <div class="row-input">
                <input type="text" name="func_name" max="12" placeholder="请输入功能名称">
            </div>
        </div>
        {{ csrf_field() }}
    </form>
</div>
@endsection

@section('javascript')
@parent
<script type="text/javascript">
const editObj = new edit();
@if($action !='add')
editObj.setForm($("#edit_form"),<?=json_encode($data)?>);
@endif
editObj.saveurl='/func/edit/{id}/edit';
editObj.setFormStatus('{{$action}}');	
</script>
@endsection