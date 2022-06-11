<?php 
$response = array("html"=>"","errorFill"=>"false","errorEmail"=>"false");

if(isset($_POST['submit'])) {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$gender = $_POST['gender'];
	$message = $_POST['message'];

	if (empty($name) || empty($email) || empty($message)) {
		$response['html'] = '<span id="form-error">Заповніть всі поля</span>';
		$response['errorFill'] = 'true';
	} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$response['html'] = '<span id="form-error">Введіть правильний email</span>';
		$response['errorEmail'] = 'true';
	} else {
		$response['html'] = '<span id="form-success">Повідомлення відправлено</span>';
	}

	echo json_encode($response);

} else {
	$response['html'] = '<span id="form-error">Виникла помилка</span>';
	echo json_encode($response);
}