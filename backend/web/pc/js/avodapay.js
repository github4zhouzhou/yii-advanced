$("#mycard_info").validate({
    //debug:true , //如果这个参数为true，那么表单不会提交，只进行检查，调试时十分方便
    rules:{
        cn_name:{required:true,minlength:2,maxlength:10},
        id_card:{required:true,minlength:6,maxlength:32},
        bc_number:{required:true,minlength:6,maxlength:32},
        phone_number:{required:true,minlength:6,maxlength:16},
        sms_code:{required:true,minlength:4,maxlength:10},
    },
    messages:{
        cn_name:{required:conf.lang["avoda_not_empty"],minlength:conf.lang["avoda_length_min"],maxlength:conf.lang["avoda_length_max"]},
        id_card:{required:conf.lang["avoda_not_empty"],minlength:conf.lang["avoda_length_min"],maxlength:conf.lang["avoda_length_max"]},
        bc_number:{required:conf.lang["avoda_not_empty"],minlength:conf.lang["avoda_length_min"],maxlength:conf.lang["avoda_length_max"]},
        phone_number:{required:conf.lang["avoda_not_empty"],minlength:conf.lang["avoda_length_min"],maxlength:conf.lang["avoda_length_max"]},
        sms_code:{required:conf.lang["avoda_not_empty"],minlength:conf.lang["avoda_length_min"],maxlength:conf.lang["avoda_length_max"]},
    },
    errorElement:"p",//用来创建错误提示信息标签(可自定义)
    onkeyup: false,
    ignore: ".ignore",
    focusCleanup:'true',
    validClass:"success",

    errorPlacement:function(error, element){//处理错误信息位置，在下面的复选框用到
        if(element.is(":radio")||element.is(":checkbox")){
            error.appendTo(element.parent());
        }else{
            // error.insertAfter(element);
            error.appendTo(element.parent());
        }
    },
    success : function(label,element){
        if($(element).is(":checkbox")){
            $(label).remove();
        }else{
            //验证成功后执行的回调函数，label指向上面那个错误提 示信息标签em
            label.text( ' ' ).addClass("success")  //添加上自定义的success类
        }
    },
    submitHandler: function (form) {
        $(".frame").show();
        // form.submit;
        return true;
    },
    invalidHandler: function(form, validator) {  //不通过回调
        return false;
    }
});
