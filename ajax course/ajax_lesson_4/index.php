<!DOCTYPE html>
<html>
<body>

	<h1>The DOM lesson</h1>

	<button type="button" onclick="textUpdate()">Update by readyText</button>

	<button type="button" onclick="xmlUpdate()">Update by readyXML</button>
	
	<button type="button" onclick="domUpdate('text.txt', text)">Update by callback func readyText</button>

	<button type="button" onclick="domUpdate('food.xml', xml)">Update by callback func readyXML</button>

	<div id="myDiv"></div>

	<script>
		function textUpdate() {
			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("myDiv").innerHTML =
					this.responseText;
				} else if (this.status == 404) {
					alert("something went wrong");
				}
			};
			xhr.open("GET", "text.txt", true);
			xhr.send(); 
		}

		function xmlUpdate() {
			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					var xmlDoc = this.responseXML;
					var xmlText = "";
					var x = xmlDoc.getElementsByTagName("food");
					for (i = 0; i < x.length; i++) {
						xmlText += x[i].childNodes[1].childNodes[0].nodeValue + "<br>";
					}
					document.getElementById("myDiv").innerHTML = xmlText;
				}
			};
			xhr.open("GET", "food.xml", true);
			xhr.send();  
		}




		function domUpdate(url, func) {
			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					func(this);
				}
			};
			xhr.open("GET", url, true);
			xhr.send();  
		}
		
		function xml(xhr) {
			var xmlDoc = xhr.responseXML;
			var xmlText = "";
			var x = xmlDoc.getElementsByTagName("name");
			for (i = 0; i < x.length; i++) {
				xmlText += x[i].childNodes[0].nodeValue + "<br>";
			}
			document.getElementById("myDiv").innerHTML = xmlText;
		}

		function text(xhr) {
			document.getElementById("myDiv").innerHTML = xhr.responseText;
		}

	</script>

</body>
</html>