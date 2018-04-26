<!DOCTYPE html>
<html>
	<head>
		<title>Link Grabber</title>
		<link rel="stylesheet" type="text/css" href="css/index.css">
	</head>
	<body>
		<div class="wrapper">
			<form class="shadow" method="POST" id="form">
				<input placeholder="http://example.com/" name="url" id="url" />
				<a onclick="send()" id="send">Go!</a>
				<div style="clear:both;"></div>
			</form>
			<div class="response shadow">
				<div class="panel">
					<div id="copy">Copy</div>
					<div id="upload">Upload</div>
					<div style="clear: both;"></div>
				</div>
				<div id="for-link"></div>
			</div>
		</div>
		<script>
		var form = document.getElementById("form");
		var url = document.getElementById("url");
		var send_button = document.getElementById("send");

		function send() {
			var request = new XMLHttpRequest();
				request.open('GET', '/links_grabber_class.php?url=' + url.value, false);
				request.send();

				if (request.status != 200) {
				  alert( request.status + ': ' + request.statusText );
				} else {
		  			var response = document.getElementById("for-link");
		  				response.innerHTML = "";

		  			for (var i = 0; i < JSON.parse(request.responseText).length; i++) {
		  				response.innerHTML += JSON.parse(request.responseText)[i] + "<br>";
		  			}
				}
		}

		form.onkeypress = function(event) {
		  var key = event.charCode || event.keyCode || 0;     
		  if (key == 13) {
		    event.preventDefault();
		    send_button.click();
		  }
		}

		send_button.addEventListener("click", send, false);
		</script>
	</body>
</html>