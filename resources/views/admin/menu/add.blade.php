@extends('public.edit')

@section('css')
@parent
<link rel="stylesheet" type="text/css" href="/css/menu_add.css">
@endsection

@section('content')
<div class="detail">
    <form id="edit_form" data-action='/menu/save' >
        <input type="hidden" value="{{ $action }}" name="action">
        <input type="hidden" value="" name="id">
        <div class="detail-row">
        	<div class="row-label">父级菜单:</div>
        	<div class="row-input">
        		<select name="parent">
        			<option value="0">无父级菜单</option>
        			<?php foreach( $all as $v ): ?>
						<option value="<?= $v->id ?>">
							<?php if( $v->level>0 ): ?>
							|
							<?php for($i=0;$i<$v->level;$i++): ?>
							--
							<?php endfor; ?>
							<?php endif; ?>
							<?= $v->named ?>
						</option>
					<?php endforeach; ?>
        		</select>
        	</div>
        </div>
    	<div class="detail-row">
    		<div class="row-label">
    			<span class="must">名称:</span>
    		</div>
    		<div class="row-input">
    			<input type="text" name="named" placeholder="请输入名称" maxlength="12">
    		</div>
    	</div>
        <div class="detail-row">
            <div class="row-label">
                <span class="must">链接:</span>
            </div>
            <div class="row-input">
               	<input type="text" name="url" placeholder="请输入菜单链接" maxlength="24">
            </div>
        </div>
        <div class="detail-row">
        	<div class="row-label">
        		<span class="must">权限</span>
        	</div>
        	<div class="row-input">
        		<button type="button" class="file" id="auth" >设置权限</button>
        		<input type="hidden" name="screen_auth">
        	</div>
        </div>
        <div class="detail-row">
        	<div class="row-label">排序:</div>
        	<div class="row-input">
        		<input type="text" name="sort" placeholder="请输入菜单排序" maxlength="4" data-allow="number" value="100" >
        	</div>
        </div>
        <div class="detail-row">
        	<div class="row-label">图标</div>
        	<div class="row-input">
        		<a href="javascript:;" class="file">选择文件
					<input id="upload_btn" type="file" name="img" multiple>	
				</a>  
        	</div>
        </div>
        <div class="detail-row">
            <div class="row-label">
                <span>图标预览:</span>
            </div>
            <div class="row-input">
                <div class="img-box">
                    @if($action != 'add' and !empty( $data->icon )  )
                        <img src="{{ $data->icon }}" style="width:48px;height:48px;"  />
                    @endif
                </div>
                <input type="hidden" name="icon">
            </div>
        </div>
        {{ csrf_field() }}
    </form>
</div>
<div class="key_bg"></div>
<div class="key_box">
    <div class="detail_box">
        <div class="row">
            <div class="label">功能名称</div>
            <div class="content"><span>权限</span></div>
        </div>
        <form id="key">
	        <?php foreach( $func as $f ): ?>
		        <div class="list">
		            <div class="list_label"><?=$f->func_name?>:</div>
		            <div class="list_content">
		                <div class="list_box">
		                    <input type="checkbox" data-key="export" data-func="<?=$f->key?>" name="<?=$f->key?>:export" value="export" ><span>查看</span>
		                </div>
		                <?php foreach($f->auth as $a): ?>
		                    <div class="list_box">
		                        <input type="checkbox" data-key="<?=$a->key?>" data-func="<?=$f->key?>" name="<?=$f->key?>:<?=$a->key?>" value="<?=$a->key?>" ><span><?=$a->auth_name?></span>
		                    </div>
		                <?php endforeach; ?>    
		            </div>
		        </div>
	        <?php endforeach; ?>
        </form>
        <div class="list">
            <button type="button" class="blue" id="save">保存</button>
            <button type="button" class="blue" id="close">关闭</button>
        </div>
    </div>
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
                $('.img-box').html( '<img src="'+data.result.path+'" style="width:48px;height:48px;" />' );
                $("input[name='icon']").val(data.result.path);
            }else{
                parent.$.warn(data.result.msg);
            }
           
        }
    });
})
$(function(){
    $("#auth").click(function(){
    	$('.key_bg,.key_box').show();
    })
    $(".key_bg,#close").click(function(){
    	$('.key_bg,.key_box').hide();
    })
    $("#save").click(function(){
	    var data=$('#key').serializeArray();
	    if (data.length <= 0) {
	        parent.$.warn("请选择权限");
	        return;
	    }
	    var tmp={};
	    $.each( data,function(k,v){
	        var func=v.name.replace(':'+v.value,'');
	        if( !tmp[ func ] ){
	            tmp[ func ]=[];
	        }
	        tmp[ func ].push( v.value );
	    } )
	    var val=JSON.stringify( tmp );
	    $("input[name='screen_auth']").val(val);
 		$('.key_bg,.key_box').hide();
    })
    @if($action == 'add' )
    	$("select[name='parent']").val({{ $pid }}).trigger('change');
    @endif
})	
const editObj = new edit();
@if($action !='add')
editObj.setForm($("#edit_form"),<?=json_encode($data)?>);
editObj.choseBox=choseBox;
function choseBox(){
	$.each( JSON.parse( this.saveData.screen_auth ) ,function(k,v){
        $.each(v,function(s,d){
            $("input[name='"+k+":"+d+"']").attr('checked',true);
        })
    })
}
editObj.choseBox();
@endif
editObj.saveurl='/menu/edit/{id}/edit';
editObj.setFormStatus('{{$action}}');
</script>
@endsection