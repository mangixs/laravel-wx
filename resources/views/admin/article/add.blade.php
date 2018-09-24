@extends('public.edit')
@section('content')
<div class="detail">
    <form id="edit_form" data-action="{{ url('article/save') }}" >
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
                <span class="must">文章类型</span>
            </div>
            <div class="row-input">
                <select name="type">
                    <option value="-1">请选择文章类型</option>
                    @foreach($articleType as $k => $v)
                    <option value="{{ $v->id }}">{{ $v->named }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="detail-row">
            <div class="row-label">
                <span class="must">展示位置</span>
            </div>
            <div class="row-input">
                <input type="radio" name="show_place" value="1" ><span class="choice" >PC</span>
                <input type="radio" name="show_place" value="2" ><span class="choice" >MOBLIE</span>
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
                <span class="must">文章首图:</span>
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
                    @if($action != 'add' and !empty( $data->first_img )  )
                        <img src="{{ $data->first_img }}">
                    @endif
                </div>
                <input type="hidden" name="first_img">
            </div>
        </div>
        <div class="detail-row">
            <div class="row-label">
                <span>文章简介:</span>
            </div>
            <div class="row-input">
                <textarea name="summary" placeholder="请输入文章简介"></textarea>
            </div>
        </div>
        <div class="detail-row">
            <div class="row-label">
                <span class="must">内容详情</span>
            </div>
            <div class="row-input"></div>
        </div>
        <div class="detail-row">
            <script id="container" name="content" style="width:100%;height:360px" type="text/plain">
                @if($action != 'add' and !empty( $data->content )  )
                    <?=$data->content?>
                @endif
            </script>
        </div>
        {{ csrf_field() }}
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
var editor;
$(function(){
    editor = UE.getEditor('container');
    $('#upload_btn').fileupload({
        dataType: 'json',
        url: "{{url('UploadImage')}}",
        done: function(e, data) {
            if(data.result.result=="SUCCESS"){
                 $('.img-box').html( '<img src="'+data.result.path+'" />' );
                $("input[name='first_img']").val(data.result.path);
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
editObj.saveurl='/article/edit/{id}/edit';
editObj.setFormStatus('{{$action}}');
</script>
@endsection