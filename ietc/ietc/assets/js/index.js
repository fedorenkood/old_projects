$('.form').find('input, textarea').on('keyup blur focus', function (e) {
  
  var $this = $(this),
      label = $this.prev('label');

	  if (e.type === 'keyup') {
			if ($this.val() === '') {
          label.removeClass('active highlight');
        } else {
          label.addClass('active highlight');
        }
    } else if (e.type === 'blur') {
    	if( $this.val() === '' ) {
    		label.removeClass('active highlight'); 
			} else {
		    label.removeClass('highlight');   
			}   
    } else if (e.type === 'focus') {
      
      if( $this.val() === '' ) {
    		label.removeClass('highlight'); 
			} 
      else if( $this.val() !== '' ) {
		    label.addClass('highlight');
			}
    }

});

$('.tab a').on('click', function (e) {
  
  e.preventDefault();
  
  $(this).parent().addClass('active');
  $(this).parent().siblings().removeClass('active');
  
  target = $(this).attr('href');

  $('.tab-content > div').not(target).hide();
  
  $(target).fadeIn(600);
  
});

$(":input").inputmask();
$("#reg-phone").inputmask({'mask': '+38 (999) 999-9999'});


$('#form-box').on('submit', function (event) {
  event.preventDefault();
  
  var lead = $('#reg-lead').val();
  var school = $('#reg-school').val();
  var grade = $('#reg-grade').val();
  var phone = $('#reg-phone').val();
  var email = $('#reg-email').val();
  var task = $('#reg-task').val();
  var first = $('#reg-first').val();
  var second = $('#reg-second').val();
  var third = $('#reg-third').val();
  var fourth = $('#reg-fourth').val();
  var submit = $('#reg-submit').val();

  // var file = $('#reg-file')[0].files[0];
  var form_data = new FormData();
  form_data.append('lead', lead);
  form_data.append('school', school);
  form_data.append('grade', grade);
  form_data.append('phone', phone);
  form_data.append('email', email);
  form_data.append('task', task);
  form_data.append('first', first);
  form_data.append('second', second);
  form_data.append('third', third);
  form_data.append('fourth', fourth);
  form_data.append('submit', submit);
  // form_data.append('file', file);


  $.ajax({
      url: 'reg.php',
      type: 'POST',
      contentType: false,
      processData: false,
      dataType:  'json',
      async: true,
      cache: false,
      data: form_data,
      success: function(response)
      {
        // var response = JSON.parse(data);
        $('#reg-response').html(response.html);
        if (response.errorFill == 'true') {
          $('#reg-lead, #reg-school, #reg-phone, #reg-task, #reg-email, #reg-first, #reg-second').addClass('error');
        } else if (response.errorEmail == 'true') {
          $('#reg-lead, #reg-school, #reg-phone, #reg-task, #reg-email, #reg-first, #reg-second, #reg-third, #reg-fourth').removeClass('error');
          $('#reg-email').addClass('error');
        } else {
          $('#reg-lead, #reg-school, #reg-phone, #reg-task, #reg-email, #reg-first, #reg-second').removeClass('error');
        }

        if (response.errorThird == 'true') {
          $('#reg-third').addClass('error');
        } else {
          $('#reg-third').removeClass('error');
        }

        if (response.errorFour == 'true') {
          $('#reg-fourth').addClass('error');
        } else {
          $('#reg-fourth').removeClass('error');
        }
        if ((response.errorEmail == 'false') && (response.errorFill == 'false') && (response.errorFour == 'false') && (response.errorThird == 'false')) {
          $('#reg-lead').val("");
          $('#reg-school').val("");
          $('#reg-phone').val("");
          $('#reg-email').val("");
          $('#reg-task').val("");
          $('#reg-first').val("");
          $('#reg-second').val("");
          $('#reg-third').val("");
          $('#reg-fourth').val("");
          $('#reg-submit').val("");
          $('.form label').removeClass('active highlight');
          $('#reg-lead, #reg-school, #reg-phone, #reg-email, #reg-first, #reg-second, #reg-third, #reg-fourth').removeClass('error');   
        }
      }
    });

});
      