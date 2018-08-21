@extends('public.edit')
@section('content')
<div class="detail">
    <form id="edit_form" data-action="{{ url('/admin/shop/save') }}" >
        <input type="hidden" value="{{$action}}" name="action">
        <input type="hidden" value="" name="id">
    	<div class="detail-row">
    		<div class="row-label">
    			<span class="must">商家名称:</span>
    		</div>
    		<div class="row-input">
    			<input type="text" name="title" placeholder="请输入商家名称" maxlength="24">
    		</div>
    	</div>
        <div class="detail-row">
            <div class="row-label">
                <span class="must">登录名:</span>
            </div>
            <div class="row-input">
                <input type="text" name="login_name" placeholder="请输入商家后台登录名" data-allow="login" maxlength="12" >
            </div>
        </div>
        @if($action == 'add')
        <div class="detail-row">
            <div class="row-label">
                <span>初始密码:</span>
            </div>
            <div class="row-input">
                <span class="notice">初始密码为:&nbsp&nbsp<span class="red">shop2018</span></span>
            </div>
        </div>
        @endif
        @if($action !='add')
        <div class="detail-row">
            <div class="row-label">新密码:</div>
            <div class="row-input">
                <input type="text" data-allow="login" name="newpwd" placeholder="请输入新密码" maxlength="16">
            </div>
        </div>
        @endif
        <div class="detail-row">
            <div class="row-label">
                <span class="must">联系人:</span>
            </div>
            <div class="row-input">
                <input type="text"  name="contact" placeholder="请输入联系人" maxlength="12">
            </div>
        </div>
        <div class="detail-row">
            <div class="row-label">
                <span class="must">联系电话:</span>
            </div>
            <div class="row-input">
                <input type="text" data-allow="tel" name="tel" placeholder="请输入联系电话号码" maxlength="12" >
            </div>
        </div>
        <div class="detail-row">
            <div class="row-label">
                <span>编号:</span>
            </div>
            <div class="row-input">
                <input type="text" data-allow="number" name="numbered" placeholder="请输入编号" maxlength="5">
            </div>
        </div>
        <div class="detail-row">
            <div class="row-label">
                <span>地址:</span>
            </div>
            <div class="row-input">
              <input type="text" name="address" placeholder="请输入地址" maxlength="5">
            </div>
        </div>
        {{ csrf_field() }}
        <div class="detail-row">
            <div class="row-label">
                <span class="must">logo:</span>
            </div>
            <div class="row-input">
                <a href="javascript:;" class="file" id="upload_btn">选择文件 </a>  
            </div>
        </div>
        <div class="detail-row">
            <div class="row-label">
                <span>logo预览:</span>
            </div>
            <div class="row-input">
                <div class="img-box">
                    @if($action != 'add' and !empty( $data->logo )  )
                        <img src="{{ $data->logo }}">
                    @endif
                </div>
                <input type="hidden" name="logo">
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
        $("input[name='logo']").val(arg[0].src);
    });
})      
const editObj = new edit();
@if($action !='add')
editObj.setForm($("#edit_form"),<?=json_encode($data)?>);
@endif
editObj.saveurl='/admin/shop/edit/{id}/edit';
editObj.setFormStatus('{{$action}}');
</script>
@endsection