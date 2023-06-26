(function($){
    /**
     * target : '选择器'
     * size : number // MB
     * wh : 宽高
     * fn : function
     * test : 正则 图片格式
     */
    $.fn.addImg = function(setting){
        if(!setting) {
            return;
        }

        var init = function(ele) {
            ele.onchange = function (evt) {
                var file = evt.target.files[0];
                    if(setting.size){
                        //文件大小
                        var size = file.size/(1024*1024);
                        var defaultSize = setting.size;
                        if(size > defaultSize ){
                            layer.msg('请选择大小小于'+defaultSize+'MB的文件', {icon:2,anim:6});
                            ele.value = "";
                            document.querySelector(setting.target).innerHTML = '';
                            return;
                        }
                    }
                    if(setting.test){
                        //文件格式
                        var test = setting.test;
                        if(!test.test(file.type)){
                            layer.msg('请选择正确的格式', {icon:2,anim:6});
                            ele.value = "";
                            document.querySelector(setting.target).innerHTML = '';
                            return;
                        }
                    }    
                        
                    var reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = (function(theFile){
                        return function(e){
                            var img = new Image();
                            img.src = e.target.result;
                            setTimeout(function(){
                                if(setting.wh && img.width && (img.width != setting.wh.w || img.height != setting.wh.h)){
                                    layer.msg('请选择符合尺寸的图片', {icon:2,anim:6});
                                    ele.value = "";
                                    document.querySelector(setting.target).innerHTML = '';
                                } else {
                                    document.querySelector(setting.target).innerHTML = '';
                                    document.querySelector(setting.target).appendChild(img); 
                                }
                            },200)
                        }
                    })(file);
                if(setting.fn) {
                    setting.fn(ele);
                }
            }
        }
        init($(this)[0]);
        return this;
    }


})(jQuery);
(function($){
    
    $.fn.addGoodsImg = function(setting){
        var init = function(ele) {
            ele.onchange = function (evt) {
                var target = $(ele).next().next();
                var file = evt.target.files[0];
                    var reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = (function(theFile){
                        return function(e){
                            var img = new Image();
                            img.src = e.target.result;
                            target.html('');
                            target.append(img).append('<i class="layui-icon">&#x1006;</i>'); 
                        }
                    })(file);
                if(setting && setting.fn) {
                    setting.fn(ele,target);
                }
            }
        }
        init($(this)[0]);
        return this;
    }


})(jQuery);


function listenSelect(form,$data,suffix){
    var $next = $($data.elem).parent().next();
    var id = $data.value;
    var t_prefix = parseInt($($data.elem).find('option:selected').attr('phone_prefix'));
    if(!t_prefix) {
        t_prefix = parseInt($($data.elem).parent().prev().find('option:selected').attr('phone_prefix'));
    }
    $('[name="t_prefix"]').val(t_prefix?t_prefix:'');
    
    var selectTxt = $($data.elem).find('option:selected').text();
    var spec_city = ['北京','Beijing','香港','Hongkong SAR','澳门','Macao SAR','天津','Tianjin','上海','Shanghai','重庆','Chongqing'];

    if($.inArray(selectTxt,spec_city)>=0) {
        $next.html('');
        $next.next().html('');
        return
    };
    var suffix = suffix || 'zh';
    id = id.split('-')[0];
    $.ajax({
        type:'get',
        url:'/address/show',
        data:{id:id,suffix:suffix},
        dataType:'json',
        success:function(mes){
            var mes = mes.data;
            var str = mes['data'],level = mes['level'],name = '',filter = 'country';
            if(str.length==0){
                $next.html('');
                $next.next().html('');
                return;
            }
            if($next.next().length>0){
                $next.next().html('');
            }
            if( level == 2 ){
                name = 'host_province';
            }else if( level == 3 ){
                name = 'host_city';
                filter = '';
            }
            var opt = '<select name="'+name+'" lay-verify="required" lay-filter="'+filter+'"><option value="">请选择</option>';
            for( var i = 0;i<str.length;i++ ){
                opt += '<option value="'+str[i].id+'-'+str[i].code+'-'+str[i].level+'" phone_prefix="'+str[i].phone_prefix+'">'+str[i].name+'</option>'
            }
            opt += '</select>'
            $next.html('');
            $next.append(opt);
            form.render();
        }
    })
}