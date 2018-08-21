@extends('public.edit')
@section('content')
<div class="detail">
    <form id="edit_form" data-action="{{ url('job/save') }}" >
        <input type="hidden" value="{{$action}}" name="action">
        <input type="hidden" value="" name="id">
    	<div class="detail-row">
    		<div class="row-label">
    			<span class="must">职位名:</span>
    		</div>
    		<div class="row-input">
    			<input type="text" name="job_name" placeholder="请输入职位名" maxlength="12">
    		</div>
    	</div>
        <div class="detail-row">
            <div class="row-label">
                <span>职位描述:</span>
            </div>
            <div class="row-input">
                <textarea name="explain" placeholder="请输入职位描述"></textarea>
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
editObj.saveurl='/job/edit/{id}/edit';
editObj.setFormStatus('{{$action}}');	
</script>
@endsection