<!DOCTYPE html>
<html>
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<style>
		#text_area {
			max-height: 400px;
			overflow-y: scroll;
			overflow-x: hidden;
		}
		h3, p {
			margin: 2px !important;
		}
		.text_block {
			margin: 10px;
		}
	</style>

	<h1>jQuery load() lesson</h1>

	<button type="button" id="text_load">Add more comments from Database</button>
	
	<div id="text_area">
		<div class="text_block">
			<h3>Name</h3>
			<p>here is a huge comment</p>
		</div>
	</div>

	<script>
	$(document).ready(function(){	
		var commentcount = 1;
		$("#text_load").click(function(){
			commentcount++;
			$("#text_area").load(
				"data_load.php",
				{commentcount: commentcount,
				somerequest: 'something'}, 
				function (result, status, xhr) {
					if (status=='success') {
						console.log(status);
						console.log(xhr.status);
					}
				}
			);
		});
	});


	</script>

	

</body>
</html>