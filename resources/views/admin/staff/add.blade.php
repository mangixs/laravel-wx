@extends('public.edit')
@section('content')
<div class="detail">
    <form id="edit_form" data-action="{{ url('/staff/save') }}" >
        <input type="hidden" value="{{$action}}" name="action">
        <input type="hidden" value="" name="id">
    	<div class="detail-row">
    		<div class="row-label">
    			<span class="must">登录名:</span>
    		</div>
    		<div class="row-input">
    			<input type="text" data-allow="login" name="login_name" placeholder="请输入用户登录名" maxlength="12">
    		</div>
    	</div>
        @if($action == 'add')
        <div class="detail-row">
            <div class="row-label">
                <span>初始密码:</span>
            </div>
            <div class="row-input">
                <span class="notice">初始密码为:&nbsp&nbsp<span class="red">xykj2018</span></span>
            </div>
        </div>
        @endif
        @if($action !='add')
        <div class="detail-row">
            <div class="row-label">新密码</div>
            <div class="row-input">
                <input type="text" data-allow="login" name="newpwd" placeholder="请输入新密码" maxlength="16">
            </div>
        </div>
        @endif
        <div class="detail-row">
            <div class="row-label">
                <span>姓名:</span>
            </div>
            <div class="row-input">
                <input type="text" data-allow="ch" name="true_name" placeholder="请输入用户姓名" maxlength="12">
            </div>
        </div>
        <div class="detail-row">
            <div class="row-label">
                <span>用户编号:</span>
            </div>
            <div class="row-input">
                <input type="text" data-allow="number" name="staff_num" placeholder="请输入用户编号" maxlength="5">
            </div>
        </div>
        <div class="detail-row">
            <div class="row-label">
                <span>用户性别:</span>
            </div>
            <div class="row-input">
                <select name="sex">
                    <option value="-1">请选择用户性别</option>
                    <option value="1">男</option>
                    <option value="2">女</option>
                </select>
            </div>
        </div>
        {{ csrf_field() }}
        <div class="detail-row">
            <div class="row-label">
                <span>用户头像:</span>
            </div>
            <div class="row-input">
                <a href="javascript:;" class="file" id="upload_btn">选择文件 </a>  
            </div>
        </div>
        <div class="detail-row">
            <div class="row-label">
                <span>头像预览:</span>
            </div>
            <div class="row-input">
                <div class="img-box">
                    @if($action != 'add' and !empty( $data->header_img )  )
                        <img src="{{ $data->header_img }}">
                    @endif
                </div>
                <input type="hidden" name="header_img">
            </div>
        </div>
    </form>   
</div>
@endsection

@section('javascript')
@parent
<script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" charset="utf-8" src="/ueditor/file_upload_v2.js"></script>
<script type="text/javascript">
$(function(){
    $('#upload_btn').fileUpload(function(t,arg){
        $('.img-box').html( '<img src="'+arg[0].src+'" />' );
        $("input[name='header_img']").val(arg[0].src);
    });
})      
const editObj = new edit();
@if($action !='add')
editObj.setForm($("#edit_form"),<?=json_encode($data)?>);
@endif
editObj.saveurl='/staff/edit/{id}/edit';
editObj.setFormStatus('{{$action}}');
</script>
@endsection