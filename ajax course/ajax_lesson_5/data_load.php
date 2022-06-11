<?php

if (isset($_POST['commentcount'], $_POST['somerequest'])) {
	$servername = "localhost";
	$username = "root";
	$password = "";
	$database = "lesson_ajax";
	$conn = new mysqli($servername, $username, $password, $database);
	$commentcount = $_POST['commentcount'];

	$sql = "SELECT name, description FROM first_ajax_table LIMIT $commentcount";
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		echo "<div class='text_block'><h3>".$row['name']."<h3/><p>".$row['description']."<p/></div>";
	}
}