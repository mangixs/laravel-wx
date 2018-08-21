class goods {
    constructor() {
        this.action = $("input[name='action']").val();
        this.editObj = new edit();
        this.editObj.checkForm = this.checkForm;
        this.editObj.saveurl = '/goods/edit/{id}/edit';
        this.editor = UE.getEditor('container');
        this.index = $(".attr-row").length;
        this.specsIndex = $(".specs-list").length;
        this.specsSubmit = false;
        this.specsInput = 0;
        this.uploadImg();
    }
    init(data) {
        this.editObj.setForm($("#edit_form"), data);
        this.editObj.setFormStatus(this.action);
        this.showImages(JSON.parse(this.editObj.saveData.images));
        this.showTags(JSON.parse(this.editObj.saveData.tags));
        this.showAttr(this.editObj.saveData.attr);
        this.showSpecs(this.editObj.saveData.sku);
    }
    showSpecs(data) {
        if (data.length < 1) {
            return;
        }
        for (let v in data) {
            this.specsHtml(data[v]);
        }
    }
    showAttr(data) {
        if (data.length < 1) {
            return;
        }
        for (let v in data) {
            this.addAttr(data[v]);
        }
    }
    showTags(data) {
        if (data.length < 1) {
            return;
        }
        for (let v in data) {
            $("[data-tag='" + data[v] + "']").attr('checked', true);
        }
    }
    showImages(data) {
        if (data.length < 1) {
            return;
        }
        let index = $(".img-box").length;
        let box = $(".img-list");
        for (let v in data) {
            let src = data[v];
            let name = 'images[' + index + ']';
            let html = `<div class="img-box">
                            <img src="${src}">
                            <input type="hidden" name="${name}" value="${src}">
                            <a href="javascript:;" class="img-a" onclick="$(this).parent().remove();" >
                                <div class="img-bg">
                                    <span>点击删除</span>
                                </div>
                            </a>
                        </div>`;
            box.append(html);
            index++;
        }
    }
    uploadImg() {
        $('#upload_btn').fileUpload(function(t, arg) {
            $('.first-img').html('<img src="' + arg[0].src + '" width="100px" height="100px" />');
            $("input[name='first_img']").val(arg[0].src);
        });
        $("#btn-img").fileUpload(function(t, arg) {
            let tmp = [];
            for (let i = 0; i < arg.length; i++) {
                tmp.push(arg[i].src);
            }
            this.showImages(tmp);
        }.bind(this))
    }
    addAttr(data = {}) {
        let attr_name = data.attr_name || '';
        let attr_val = data.attr_val || '';
        let html = `<div class="attr-row" data-index="${this.index}">
                        <div class="col-xs-5">
                            <input type="text" name="attr_name[${this.index}]" value="${attr_name}" placeholder="请输入商品属性名" maxlength="12" style="width:100%;">
                        </div>
                        <div class="col-xs-5">
                            <input type="text" name="attr_val[${this.index}]" value="${attr_val}" placeholder="请输入商品属性值" maxlength="12" style="width:100%;">
                        </div>
                        <div class="col-xs-2">
                            <button type="button" class="btn btn-danger" onclick="goodsObj.deleteAttr(${this.index})">删除</button>                        
                        </div>
                    </div>`;
        $("#attr").append(html);
        this.index++;
    }
    deleteAttr(id) {
        $("[data-index='" + id + "']").remove();
    }
    specsHide(self) {
        let box = $(".specs");
        if (box.is(':visible')) {
            box.hide();
            self.text('显示');
        } else {
            box.show();
            self.text('隐藏');
        }
    }
    specsCancel() {
        $(".specs input[type='checkbox']:checked").prop('checked', false);
    }
    addSpecs() {
        if (this.specsSubmit) {
            parent.$.warn("请先填写完毕当前规格");
            return;
        }
        this.specsHtml();
        this.specsSubmit = true;
    }
    specsHtml(data = {}) {
        let named = data.specs_name || '';
        let inventory = data.specs_inventory || '';
        let price = data.specs_price || '';
        let goods_id = data.goods_id || '';
        let html = `<div class="specs-list" data-spesc="${this.specsIndex}">
                <div class="col-xs-3">
                    <input type="text" name="specsName[${this.specsIndex}]" value="${named}" placeholder="请输入商品规格" maxlength="12" style="width:100%;">
                </div>
                <div class="col-xs-3">
                    <input type="text" name="specsInventory[${this.specsIndex}]" value="${inventory}" placeholder="请输入商品规格库存" maxlength="12" style="width:100%;">
                </div>
                <div class="col-xs-3">
                    <input type="text" name="specsPrice[${this.specsIndex}]" value="${price}" placeholder="请输入商品价格" data-allow="float" maxlength="12" style="width:70%">
                    <span class="red">单位:元</span>
                </div>
                <div class="col-xs-3">
                    ${this.specsBtn(goods_id)}                    
                    <button type="button" class="btn btn-danger" onclick="goodsObj.deleteSpecs(${this.specsIndex})">删除</button>                        
                </div>
            </div>`;
        $("#specs-box").append(html);
        this.specsIndex++;
    }
    specsBtn(id) {
        if (id == '') {
            return '<button type="button" class="btn btn-success" onclick="goodsObj.sureSpecs($(this))">确定</button>';
        }
        return '';
    }
    deleteSpecs(id) {
        this.specsCancel();
        this.specsSubmit = false;
        $("[data-spesc='" + id + "']").remove();
    }
    sureSpecs(self) {
        let index = this.specsIndex - 1;
        let specsName = $("input[name='specsName[" + index + "]']").val();
        let specsInventory = $("input[name='specsInventory[" + index + "]']").val();
        let specsPrice = $("input[name='specsPrice[" + index + "]']").val();
        if (specsName == '') {
            parent.$.warn("请输入规格名称");
            return;
        }
        let preg = /^[\d]+$/;
        if (!preg.test(specsInventory)) {
            parent.$.warn("请输入商品规格数量");
            return;
        }
        let preg_price = /^(-?\d+)(\.\d+)?$/;
        if (!preg_price.test(specsPrice)) {
            parent.$.warn("请输入商品价格");
            return;
        }
        self.hide();
        this.specsCancel();
        this.specsSubmit = false;
    }
    choiceSpecs(self) {
        if (!this.specsSubmit) {
            parent.$.warn("请先添加商品规格");
            self.prop('checked', false);
            return;
        }
        let tmp = this.specsInput + 1;
        let index;
        if (tmp == this.specsIndex) {
            index = this.specsInput;
        } else {
            this.specsInput = this.specsIndex - 1;
            index = this.specsInput;
        }
        let text = self.attr('data-specs-text');
        let specsVal = $("input[name='specsName[" + index + "]']").val();
        if (self.is(':checked')) {
            if (specsVal == '') {
                $("input[name='specsName[" + index + "]']").val(text);
            } else {
                $("input[name='specsName[" + index + "]']").val(specsVal + '/' + text);
            }
        } else {
            let res = specsVal.replace(text, '');
            $("input[name='specsName[" + index + "]']").val(res);
        }
    }
    checkForm() {
        let title = $("input[name='title']").val();
        if (title == '') {
            parent.$.warn('请输入商品名称');
            return false;
        }
        let shop_id = $("select[name='shop_id']").val();
        if (shop_id == -1) {
            parent.$.warn('请输入商品所属商家');
            return false;
        }
        let classify_id = $("select[name='classify_id']").val();
        if (classify_id == -1) {
            parent.$.warn('请输入所属分类');
            return false;
        }
        let serial_num = $("input[name='serial_num']").val();
        let preg_num = /^[\d]{5,}$/;
        if (!preg_num.test(serial_num)) {
            parent.$.warn("请输入商品编号");
            return false;
        }
        let first_img = $("input[name='first_img']").val();
        let preg_img = /^.+\.(jpg|png|jpeg|gif){1}$/;
        if (!preg_img.test(first_img)) {
            parent.$.warn("请上传商品首图");
            return false;
        }
        let unit = $("input[name='unit']").val();
        if (unit == '') {
            parent.$.warn("请输入商品单位");
            return false;
        }
        let buy_price = $("input[name='buy_price']").val();
        let num = /^[\d]+/;
        let sale_price = $("input[name='sale_price']").val();
        if (!num.test(buy_price) && !num.test(sale_price)) {
            parent.$.warn("请输入价格");
            return false;
        }
        let tag = [];
        $("input[name='tag']:checked").each(function() {
            let val = $(this).val();
            tag.push(val);
        })
        $("input[name='goods_tag']").val(JSON.stringify(tag));
        let ret = true;
        $(".attr-row").each(function() {
            let index = $(this).attr('data-index');
            let attr_name = $("input[name='attr_name[" + index + "]']").val();
            let attr_val = $("input[name='attr_val[" + index + "]']").val();
            if (attr_val == '' && attr_name == '') {
                ret = false;
                return false;
            }
        })
        if (!ret) {
            parent.$.warn("请填写完整的商品属性");
            return false;
        }
        let res = true;
        $(".specs-list").each(function() {
            let index = $(this).attr('data-spesc');
            let specs_name = $("input[name='specsName[" + index + "]']").val();
            if (specs_name == '') {
                res = false;
                return false;
            }
            let specs_num = $("input[name='specsInventory[" + index + "]']").val();
            let preg = /^[\d]+$/;
            if (!preg.test(specs_num)) {
                res = false;
                return false;
            }
            let price = $("input[name='specsPrice[" + index + "]']").val();
            let preg_price = /^(-?\d+)(\.\d+)?$/;
            if (!preg_price.test(price)) {
                res = false;
                return false;
            }
        })
        if (!res) {
            parent.$.warn("请填写完整的商品规格");
            return false;
        }
        return true;
    }
}