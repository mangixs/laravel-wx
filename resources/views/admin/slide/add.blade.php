@extends('public.edit')
@section('content')
<div class="detail">
    <form id="edit_form" data-action="{{ url('slide/save') }}" >
        <input type="hidden" value="{{$action}}" name="action">
        <input type="hidden" value="" name="id">
    	<div class="detail-row">
    		<div class="row-label">
    			<span class="must">标题:</span>
    		</div>
    		<div class="row-input">
    			<input type="text" name="title" placeholder="请输入标题" maxlength="32">
    		</div>
    	</div>
        <div class="detail-row">
            <div class="row-label">
                <span class="must">类型</span>
            </div>
            <div class="row-input">
                <select name="type">
                    <option value="-1">请选择广告类型</option>
                    @foreach($slideType as $k => $v)
                    <option value="{{ $v->id }}">{{ $v->named }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="detail-row">
            <div class="row-label">
                <span class="must">是否显示</span>
            </div>
            <div class="row-input">
                <input type="radio" name="is_show" value="1" ><span class="choice" >显示</span>
                <input type="radio" name="is_show" value="2" ><span class="choice" >不显示</span>
            </div>
        </div>        
        <div class="detail-row">
            <div class="row-label">
                <span class="must">排序:</span>
            </div>
            <div class="row-input">
                <input type="text" name="sort" placeholder="请输入排序" maxlength="3" value="100">
            </div>
        </div>        
 		<div class="detail-row">
            <div class="row-label">
                <span class="must">链接:</span>
            </div>
            <div class="row-input">
                <input type="text" name="url" placeholder="请输入链接" maxlength="64">
            </div>
        </div>            
        <div class="detail-row">
            <div class="row-label">
                <span class="must">图片:</span>
            </div>
            <div class="row-input">
                <a href="javascript:;" class="file">选择文件
                    <input id="upload_btn" type="file" name="img" multiple>
                </a>  
            </div>
        </div>
        <div class="detail-row">
            <div class="row-label">
                <span>预览:</span>
            </div>
            <div class="row-input">
                <div class="img-box">
                    @if($action != 'add' and !empty( $data->img )  )
                        <img src="{{ $data->img }}">
                    @endif
                </div>
                <input type="hidden" name="img" id="img">
            </div>
        </div>        
        {{ csrf_field() }}
    </form>
</div>
@endsection

@section('javascript')
@parent
<script type="text/javascript">
$(function(){
    $('#upload_btn').fileupload({
        dataType: 'json',
        url: "{{url('UploadImage')}}",
        done: function(e, data) {
            if(data.result.result=="SUCCESS"){
                 $('.img-box').html( '<img src="'+data.result.path+'" />' );
                $("#img").val(data.result.path);
            }else{
                parent.$.warn(data.result.msg);
            }
           
        }
    });
}) 
const editObj = new edit();
@if($action !='add')
editObj.setForm($("#edit_form"),<?=json_encode($data)?>);
@endif
editObj.saveurl='/slide/edit/{id}/edit';
editObj.setFormStatus('{{$action}}');	
</script>
@endsection