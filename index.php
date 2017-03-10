<!DOCTYPE html>
<html>
<head>
	<title>Battuta</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link href="styles/bootstrap.min.css" rel="stylesheet">
	<style>
	  #map {
	  	height: 93vh;
	  }
	  html, body {
	  	height: 100vh;
	  	margin: 0;
	  	padding: 0;
	  	background-color: #333;
	  }
	  .navbar {
	  	margin-bottom: 0px;
	  }
	  #overlay {
	  	z-index:1000;
	  	background-color: #333;
	  	opacity:.2;
	  	width:100%;
	  	height:100%;
	  	position: absolute;
	  	top:0px;
	  }
	  #popup {
	  	z-index: 2000;
	  	position: absolute;
	  	top: 0px;
	  	margin: 10vh 20vw;
	  	height: 80vh;
	  	width: 60vw;
	  }
	</style>
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">
					<img alt="Brand" src="img/icon.png" style="height: 100%"/>
				</a>
			</div>
		</div>
	</nav>
	<div id="map"></div>
	<div id="overlay">
	</div>
	<div id="popup" class="jumbotron">
	</div>
	<script>
		var map;
		function initMap() {
			map = new google.maps.Map($('#map')[0], {
				zoom: 15
			});
			var markers = [
			marker("Notre Dame Main Building",{lat:41.702626,lng:-86.238964},"https://c1.staticflickr.com/5/4071/4460902921_16433d8a60_b.jpg"),
			];
			var markerCluster = new MarkerClusterer(map, markers,{imagePath: 'img/m'});
		}
		function marker(name,loc,img){
			var marker = new google.maps.Marker({
				position: loc,
				map: map,
				title: name
			});
			var infowindow = new google.maps.InfoWindow({
				content: "<h1>"+name+'</h1><br/><img style="height:100px;display:block;margin-left:auto;margin-right:auto;" src=\"'+img+"\"></img>"
			});
			google.maps.event.addListener(marker, 'click', function() {
				infowindow.open(map,marker);
			});
			return marker;
		}
	</script>
	<script type="text/javascript" src="lib/jquery-3.1.0.min.js"></script>
	<script type="text/javascript" src="lib/bootstrap.min.js"></script>
	<script src="lib/markerclusterer.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0m8B_Vwfn3FRIBkQk4gQWeTfjlxmRB6A&callback=initMap"
	async defer></script>
	<script type="text/javascript">
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(pos);
		} else {
			console.log("Geolocation is not supported by this browser.");
		}
		init();
		function pos(position) {
			map.setCenter({lat: position.coords.latitude, lng: position.coords.longitude});
		}
		function init(){
			login = false;
			if(login)
				popup("Hello");
			else
				popup();
		}
		function popup(content) {
			if(content == undefined || content == ""){
				$("#popup").hide();
				$("#overlay").hide();
			} else {
				$("#popup").show();
				$("#overlay").show();
				$("#popup").html(content);
			}

		}
	</script>
</body>
</html>