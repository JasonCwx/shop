/*页面 全屏-添加*/
function o2o_edit(title,url){
    var index = layer.open({
        type: 2,
        title: title,
        content: url
    });
    layer.full(index);
}

/*添加或者编辑缩小的屏幕*/
function o2o_s_edit(title,url,w,h){
    layer_show(title,url,w,h);
}
/*-删除*/
function o2o_del(url){

    layer.confirm('确认要删除吗？',function(index){
        window.location.href=url;
    });
}

$('.listorder input').blur(function(){
    //AJAX编写失去焦点后发送数据请求
    //获取主键id
    var id = $(this).attr('attr-id');
    var listorder = $(this).val();
    var postData = {
        'id': id,
        'listorder': listorder
    };
    var url = SCOPE.listorder_url;
    $.post(url, postData, function(result){
        if(result.code == 1){
            location.href=result.data;
        }
    }, 'json');
});

//城市相关二级内容获取
$('.cityId').change(function(){
    var city_id = $(this).val();
    //发送请求
    var url = SCOPE.city_url;
    var data = {
        'id': city_id
    };
    $.post(url, data, function(result){
        if(result.status == 1){
            //将信息填充到页面中
            var data = result.data;
            var city_html = '';
            $(data).each(function(i){
                city_html += "<option value='" + this.id + "'>" + this.name + "</option>";
            });
            $('.se_city_id').html(city_html);
        }else if(result.status == 0){
            $('.se_city_id').html('');
        }
    }, 'json');
});

//分类相关二级内容获取
$('.categoryId').change(function(){
    var category_id = $(this).val();
    //发送请求
    var url = SCOPE.category_url;
    var data = {
        'id': category_id
    };
    $.post(url, data, function(result){
        if(result.status == 1){
            //
            var data = result.data;
            var category_html = '';
            $(data).each(function(i){
                category_html += "<input name='se_category_id[]' type='checkbox' id='checkbox-moban' value='" + this.id + "'>" + this.name;
                category_html += "<label for='checkbox-moban'>&nbsp;</label>";
            });
            $('.se_category_id').html(category_html);
        }else if(result.status == 0){
            $('.se_category_id').html('');
        }
    }, 'json');
});

function selecttime(flag){
    if(flag == 1){
        var endTime = $('#countTimeend').val();
        if(endTime != ''){
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss', maxDate:endTime});
        }else{
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'});
        }
    }else{
        var startTime = $('#countTimestart').val();
        if(startTime != ''){
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss', maxDate:startTime});
        }else{
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'});
        }
    }
}

