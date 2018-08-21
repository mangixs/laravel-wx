@extends('public.edit')
@section('content')
<div class="detail">
    <form id="edit_form">
    	<div class="detail-row">
    		<div class="row-label">
    			<span class="must">操作者:</span>
    		</div>
    		<div class="row-input">
    			<input type="text" name="true_name">
    		</div>
    	</div>
        <div class="detail-row">
    		<div class="row-label">
    			<span class="must">操作方法:</span>
    		</div>
    		<div class="row-input">
    			<input type="text" name="methods">
    		</div>
    	</div>
        <div class="detail-row">
    		<div class="row-label">
    			<span class="must">操作时间:</span>
    		</div>
    		<div class="row-input">
    			<input type="text" name="insert_at">
    		</div>
    	</div>
        <div class="detail-row">
            <div class="row-label">
                <span class="must">登录ip地址:</span>
            </div>
            <div class="row-input">
                <input type="text" name="client_ip">
            </div>
        </div>        
        <div class="detail-row">
    		<div class="row-label">
    			<span class="must">操作功能:</span>
    		</div>
    		<div class="row-input">
    			<input type="text" name="obj_name">
    		</div>
    	</div>
        <div class="detail-row">
    		<div class="row-label">
    			<span class="must">对象id:</span>
    		</div>
    		<div class="row-input">
    			<input type="text" name="obj_id">
    		</div>
    	</div>       
        <div class="detail-row">
    		<div class="row-label">
    			<span class="must">详情:</span>
    		</div>
    		<div class="row-input">
    			<textarea name="opt_content" style="width:95%;"></textarea>
    		</div>
    	</div>
    </form>
</div>
@endsection

@section('javascript')
@parent
<script type="text/javascript">
const editObj = new edit();
editObj.setForm($("#edit_form"),<?=json_encode($data)?>);
editObj.setFormStatus('{{$action}}');	
</script>
@endsection