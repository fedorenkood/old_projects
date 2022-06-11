<!DOCTYPE html>
<html>
<body class="flex_box">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<style>

		.flex_box {
			display: flex;
			align-items: baseline;
			justify-content: center;
		}

		#search {
			width: 400px;
			height: 30px;
			border-radius: 15px;
			text-align: center;
			font-size: 15px;
			outline: 0;
		}

		h2 {margin: 15px 30px;}

		#search_area {
			margin-top: 50px;
			display: flex;
			align-items: center;
		}
		
		#result_area .result_box{
			padding-bottom: 10px;
			border-bottom: 1px solid;
		}

		.result_box:last-child {border-bottom: none !important;}

		.result_box div {
			display: flex;
			align-items: baseline;
			justify-content: flex-start;
		}

		.result_box p {margin: 7px 0;}
		.name {margin: 10px 20px 0 0;}
		.price {font-size: 12px;}
	</style>
	<div>
		<div id="search_area">
			<h2>My search</h2>
			<input type="search" id="search" placeholder="name or description of the dish">
		</div>

		<div id="result_area">
			<!-- <div class="result_box">
				<div>
					<h3 class="name">Belgian Waffles</h3>
					<span class="price">$5.95</span>
				</div>
				<p class="description">Two of our famous Belgian Waffles with plenty of real maple syrup</p>
			</div> -->
		</div>
	</div>
	
	<script>
		$(document).ready(function () {
			$('#search').keyup(function () {
				var searchVal = $('#search').val();
				var Exp = new RegExp(searchVal, "i");
				$.getJSON('food.json', function (values) {
					var htmlVal = '';
					$.each(values, function (key, val) {
						if ((val.name.search(Exp) != -1) || (val.description.search(Exp) != -1)) {
							htmlVal += '<div class="result_box"><div><h3 class="name">';
							htmlVal += val.name+'</h3><span class="price">'+val.price+'</span></div><p class="description">';
							htmlVal += val.description+'</p></div>';
						}
					});
					$('#result_area').html(htmlVal);
				});
			});
		});
	</script>

</body>
</html>