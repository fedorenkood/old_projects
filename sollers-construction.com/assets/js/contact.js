var ContactForm=function(){return{initContactForm:function(){$("#sky-form3").validate({rules:{name:{required:true},email:{required:true,email:true},message:{required:true,minlength:10},captcha:{required:true,remote:'assets/plugins/sky-forms/version-2.0.1/captcha/process.php'}},messages:{name:{required:'Please enter your name',},email:{required:'Please enter your email address',email:'Please enter a VALID email address'},message:{required:'Please enter your message'},captcha:{required:'Please enter characters',remote:'Correct captcha is required'}},submitHandler:function(form){$(form).ajaxSubmit({beforeSend:function(){$('#sky-form3 button[type="submit"]').attr('disabled',true);},success:function(){$("#sky-form3").addClass('submited');}});},errorPlacement:function(error,element){error.insertAfter(element.parent());}});}};}();