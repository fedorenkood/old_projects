<?php 
$response = array("html"=>"","errorFill"=>"false","errorEmail"=>"false", "errorThird"=>"false", "errorFour"=>"false", "errorFile"=>"false");


// isset($_POST['submit']) && !empty($_FILES['file']['name'])
if(isset($_POST['submit'])) {
	/*$servername = "localhost"; // uashared12.twinservers.net
	$username = "root"; // ietccomu_root
	$password = ""; // ietccomu
	$database = "ietc"; // ietccomu_ietc*/
	$servername = "uashared12.twinservers.net"; // https://uashared12.twinservers.net
	$username = "ietccomu_root"; // ietccomu_root
	$password = "ietccomu"; // ietccomu
	$database = "ietccomu_ietc"; // ietccomu_ietc
	$table = "registration";
	$conn = new mysqli($servername, $username, $password, $database);

/*	$target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES["file"]["name"]);
	$uploadOk = 1;
	$imageFileType = mb_strtolower(pathinfo($target_file,PATHINFO_EXTENSION), 'UTF-8');*/

	$lead = $_POST['lead'];
	$school = $_POST['school'];
	$grade = $_POST['grade'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$task = $_POST['task'];
	$first = $_POST['first'];
	$second = $_POST['second'];
	$third = $_POST['third'];
	$fourth = $_POST['fourth'];

	$lead = NameChanger($lead);
	$first = NameChanger($first);
	$second = NameChanger($second);
	$third = NameChanger($third);
	$fourth = NameChanger($fourth);

	
// !NameChecker($lead) || !NameChecker($first) || !NameChecker($second) || empty($school) || empty($email) || empty($phone)
	if (	!NameChecker($lead) 
		|| 	!NameChecker($first) 
		|| 	!NameChecker($second) 
		|| 	empty($school) 
		|| 	empty($email) 
		|| 	empty($task) 
		|| 	empty($phone)) 
	{	
		$response['html'] = '<span id="form-error">Заповніть всі поля</span><br>';
		$response['errorFill'] = 'true';
	} if (!NameAdditional($third)) {
		$response['html'] .= '<span id="form-error">Якщо почали заповнювати 3 учасника, вказуйте повне ПІБ</span><br>';
		$response['errorThird'] = 'true';
	} if (!NameAdditional($fourth)) {
		$response['html'] .= '<span id="form-error">Якщо почали заповнювати 4 учасника, вказуйте повне ПІБ</span><br>';
		$response['errorFour'] = 'true';
	} if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$response['html'] .= '<span id="form-error">Введіть правильний email</span><br>';
		$response['errorEmail'] = 'true';
	} /*if (file_exists($target_file)) {
    	$response['html'] .= '<span id="form-error">Sorry, file already exists.</span><br>';
    	$response['errorFile'] = 'true';
	} if ($_FILES["file"]["size"] > 25000000) {
		$response['html'] .= '<span id="form-error">Sorry, your file is too large.</span><br>';
		$response['errorFile'] = 'true';
	} if (	($_FILES["file"]["type"] != "application/zip") 
		|| 	($_FILES["file"]["type"] != "application/x-zip") 
		|| 	($_FILES["file"]["type"] != "application/x-zip-compressed")) {
		$response['html'] .= '<span id="form-error">Виберіть файл формату zip</span><br>';
		$response['errorFile'] = 'true';
	}*/ if (	$response['errorFill'] == 'false' 
		&& 	$response['errorEmail'] == 'false' 
		&& 	$response['errorThird'] == 'false' 
		&& 	$response['errorFour'] == 'false'
		&& 	$response['errorFile'] == 'false') {

		/*if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
	        $response['html'] .= "<span id='form-error'>"."The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded."."</span><br>";
	    } else {
	        $response['html'] .= "<span id='form-error'>Sorry, there was an error uploading your file.</span><br>";
	    }*/

	    mysqli_query($conn, "ALTER TABLE `ietc`.`$table` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;");
	    
		$lead = 	NameChangerExp($_POST['lead']);
		$first = 	NameChangerExp($_POST['first']);
		$second = 	NameChangerExp($_POST['second']);
		$third = 	NameChangerExp($_POST['third']);
		$fourth = 	NameChangerExp($_POST['fourth']);

		$sql = "SELECT * FROM `$table` WHERE `email` = '$email'";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);

		if (empty($row['email']) && mysqli_set_charset($conn, "utf8")) {
			$sql = "INSERT INTO `$table` 
			(`lead`, `school`, `grade`, `phone`, `email`, `task`, `first_par`, `second_par`, `third_par`, `fourth_par` ) 
			VALUES ('$lead', '$school', '$grade', '$phone', '$email', '$task', '$first', '$second', '$third', '$fourth')";

			if (mysqli_query($conn, $sql) == TRUE) {
				$response['html'] .= '<span id="form-success">Вас зареєстровано. Для внесення корективів у дані, заповніть форму заново, зіставлення даних відбувається через адрес електронної пошти.</span><br>';
			} else {
				$response['html'] .= "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
		} else {
			$sql = "UPDATE `$table` 
			SET `lead`='$lead', `school`='$school', `grade`='$grade', `phone`='$phone', `email`='$email', `task`='$task', `first_par`='$first', `second_par`='$second', `third_par`='$third', `fourth_par`='$fourth'
			WHERE `email` = '$email'";
			if (mysqli_query($conn, $sql) == TRUE) {
				// Ну вы молодец, мы обновили ваши данные, грузите наш сервер
				$response['html'] .= '<span id="form-success">Вас вже було зареєстровано, тому ваші дані було оновлено.</span><br>';
			} else {
				$response['html'] .= "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
		}
	}

	echo json_encode($response);

} else {
	/*$str = "  ksjdfk  щвоащмтывш   фщыва   пмвлщф   вая";
	var_dump(NameChanger($str));*/
	$response['html'] .= '<span id="form-error">Виникла помилка</span><br>';
	echo json_encode($response);
}

function NameChanger($str='')
{
	$str = trim($str);
	$str = preg_replace('/\s+/', ' ', $str);
	$str = mb_convert_case(mb_strtolower($str, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
	$arr = explode(" ", $str);
	return $arr;
}
function NameChangerExp($str='')
{
	$str = trim($str);
	$str = preg_replace('/\s+/', ' ', $str);
	$str = mb_convert_case(mb_strtolower($str, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
	return $str;
}

function NameChecker($arr)
{
	if ( !empty($arr[0]) && !empty($arr[1]) && !empty($arr[2])) {
		return true;
	} else {
		return false;
	}
}
function NameAdditional($arr)
{
	if ( !empty($arr[0]) && !empty($arr[1]) && !empty($arr[2])) {
		return true;
	} elseif (empty($arr[0]) && empty($arr[1]) && empty($arr[2])) {
		return true;
	} else {
		return false;
	}
}