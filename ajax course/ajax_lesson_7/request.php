<?php 
$servername = "localhost";
$username = "root";
$password = "";
$database = "lesson_ajax";
$conn = new mysqli($servername, $username, $password, $database);


if(isset($_POST['name'], $_POST['pass'])) {
	$name = $_POST['name'];
	$pass = $_POST['pass'];


	$sql = "INSERT INTO `ajax_lesson_7` (`name`, `pass`) VALUES ('$name', '$pass')";
	if (mysqli_query($conn, $sql) == TRUE) {
		echo "New user created successfully<br>";
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}

	$sql = "SELECT * FROM `ajax_lesson_7` WHERE `name` = '$name'";
	$result = mysqli_query($conn, $sql);
	while($row = mysqli_fetch_assoc($result)) {
        echo "id: ".$row["id"]."<br>";
        echo "Name: ".$row["name"]."<br>";
        echo "Password: ".$row["pass"]."<br>";
    }

}  elseif (isset($_POST['name'])) {  // second part
	$name = $_POST['name'];

	$sql = "SELECT * FROM `ajax_lesson_7` WHERE `name` = '$name'";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) == 0) {
		echo "This name is free";
	} else {
		echo "This name is already in use";
	}
}