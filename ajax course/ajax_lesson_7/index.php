<!DOCTYPE html>
<html>
<body class="flex_box">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<style>
		.flex_box {
			display: flex;
			align-items: center;
			justify-content: center;
		}
		#sign_box {margin-top: 200px; width: 200px}
		#password {margin: 15px 0;}
	</style>
	<div id="sign_box">
		<h3>Register</h3>
		<input type="text" id="name" placeholder="name">
		<input type="password" id="password" placeholder="password">
		<button id="request">sign up</button>
		<div id="response"></div>
	</div>
	
	<script>

		$(document).ready(function () {
			var nameFree = false;

			$('#name').keyup(function () {   // second part
				var name = $('#name').val();
				$.post("request.php", {
					name: name
				}, function (data, status) {
					if (status=='success') {
						$('#response').html(data);
						if (data == "This name is free") nameFree = true;
						if (data == "This name is already in use") nameFree = false;
						// console.log(nameFree);
					}
				});
			});

			$('#request').click(function () {
				var name = $('#name').val();
				var pass = $('#password').val();
				if ((name != '')&&(pass != '')&&(nameFree == true)) {
					$.post("request.php", {
						name: name,
						pass: pass
					}, function (data, status) {
						if (status=='success') {
							$('#response').html(data);
						}
					});
				} else {
					alert("Insert data");
				}
			});
		});
	</script>

</body>
</html>