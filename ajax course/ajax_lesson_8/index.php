<!DOCTYPE html>
<html>
<header>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</header>
<body class="flex-box">
	<form action="request.php" method="POST" id="form-box">
		<input type="text" id="form-name" placeholder="Ваше ім'я">
		<br>
		<input type="text" id="form-email" placeholder="Ваш імейл">
		<br>
		<select id="form-gender" >
			<option value="male" selected>Чоловік</option>
			<option value="female">Жінка</option>
		</select>
		<br>
		<textarea id="form-message" cols="30" rows="5" placeholder="Повідомлення"></textarea>
		<br>
		<button type="submit" id="form-submit">Відправити</button>
		<br>
		<div id="form-response">
			<!-- <span id="form-error">Помилка</span>
			<span id="form-success">Відправлено</span> -->
		</div>
	</form>

	<script>

		$(document).ready(function () {
			$('#form-box').submit(function (event) {
				event.preventDefault();
				var name = $('#form-name').val();
				var email = $('#form-email').val();
				var gender = $('#form-gender').val();
				var message = $('#form-message').val();
				var submit = $('#form-submit').val();
				$.post('request.php', {
					name: name,
					email: email,
					gender: gender,
					message: message,
					submit: submit
				}, function (data) {
					var response = JSON.parse(data);
					$('#form-response').html(response.html);
					if (response.errorFill == 'true') {
						$('#form-name, #form-email, #form-message').addClass('error');
					} else if (response.errorEmail == 'true') {
						$('#form-name, #form-email, #form-message').removeClass('error');
						$('#form-email').addClass('error');
					} else if ((response.errorEmail == 'false') && (response.errorFill == 'false')) {
						$('#form-name').val("");
						$('#form-email').val("");
						$('#form-message').val("");	
						$('#form-gender').val("male");			
						$('#form-name, #form-email, #form-message').removeClass('error');		
					}
				});

			});
			
		});
	</script>

</body>
</html>
