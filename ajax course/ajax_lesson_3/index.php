<!DOCTYPE html>
<html>
<body>

<h2>The XMLHttpRequest request</h2>

<button type="button" onclick="firstAjax()">My first Ajax</button>

<button type="button" onclick="funcGet()">GET</button>

<button type="button" onclick="funcPost()">POST</button>

<button type="button" onclick="Sync()">Synchronous</button>

<button type="button" onclick="Async()">Asynchronous</button>


<script>

	function firstAjax() {
		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange=function() {
			if (this.readyState == 4 && this.status == 200) {
				console.log(this.responseText);
			}
		};
		xhr.open("GET", "text.txt", true);
		xhr.send();
	}

	function funcGet() {
		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange=function() {
			if (this.readyState == 4 && this.status == 200) {
				console.log(this.responseText);
			}
		};
		xhr.open("GET", "get.php?name=John&sname=Johns", true);
		xhr.send();
	}

	function funcPost() {
		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange=function() {
			if (this.readyState == 4 && this.status == 200) {
				console.log(this.responseText);
			}
		};
		xhr.open("POST", "post.php", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("name=John&sname=Johns");
	}

	function Sync() {
		for (var i = 0; i < 10; i++) {		
			var xhr = new XMLHttpRequest();
			xhr.open("GET", "sync.txt", false);
			xhr.send();
			console.log(xhr.responseText);
		}
	}

	function Async() {
		for (var i = 0; i < 10; i++) {		
			setTimeout( function () {
				var xhr = new XMLHttpRequest();
				xhr.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						console.log(this.responseText);
					}
				};
				xhr.open("GET", "async.txt", true);
				xhr.send();
			}, 5);
		}
	}
	
</script>

</body>
</html>
