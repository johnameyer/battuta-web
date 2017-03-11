<!DOCTYPE html>
<html>
<head>
	<title>Battuta</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<!-- ITouch settings -->
	<link rel="apple-touch-icon" href="img/icon.png" />
	<link rel="apple-touch-startup-image" href="img/splash.png" />
	<meta name="apple-mobile-web-app-title" content="Battuta" />
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">

	<link href="styles/bootstrap.min.css" rel="stylesheet" />
	<style>
		#map {
			height: 93vh;
			width:100vw;
			position:absolute;
			bottom:1vh;
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

		#popup {
			z-index: 2000;
			position: absolute;
			top: 0px;
			margin: 0;
			height: 100vh;
			width: 100vw;
		}
		@media screen and (min-width: 480px) {
			#overlay {
				z-index:1000;
				background-color: #333;
				opacity:.4;
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
		}
		.close {
			margin-left: 95%;
		}
	</style>
	<script src="https://use.fontawesome.com/763405a8db.js"></script>
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">
					<img alt="Brand" src="img/icon.png" style="height: 120%"/>
				</a>
			</div>
		</div>
	</nav>
	<div id="map"></div>
	<div id="overlay">
	</div>
	<div id="popup" class="panel">
	</div>
	<script>
		var map;
		function initMap() {
			map = new google.maps.Map($('#map')[0], {
				zoom: 15,
				streetViewControl: false,
			});
			var markers = [
			marker("Notre Dame Main Building",{lat:41.702626,lng:-86.238964},"https://c1.staticflickr.com/5/4071/4460902921_16433d8a60_b.jpg")
			];
			var markerCluster = new MarkerClusterer(map, markers,{imagePath: 'img/m'});
			google.maps.event.addListener(markerCluster, 'clusterclick', function(cluster) {
				console.log('Test');
				map.setCenter(cluster.getCenter());
				cluster.getMarkers();
				cluster.getSize();
				// combine results somehow?
			});
		}
		function marker(name,loc,img){
			var marker = new google.maps.Marker({
				position: loc,
				map: map,
				title: name
			});
			content = '<div class="close" onclick="popup()"><i class="fa fa-times fa-lg"></i></div><br/><div class="text-center">';
			content += "<h1>"+name+'</h1><br/><img style="height:20vh;display:block;margin-left:auto;margin-right:auto;" src=\"'+img+"\"></img><br/>";
			content += '<div class="col-md-5 col-md-offset-1></div><div class="col-md-5></div>"'
			content += '</div>';
			google.maps.event.addListener(marker, 'click', function() {
				popup(content,"80vh");
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
		init(true);
		function pos(position) {
			map.setCenter({lat: position.coords.latitude, lng: position.coords.longitude});
		}
		function init(login){
			if(login){
				popup('<br/><div class="text-center"><form class="form-horizontal" onsubmit="return false;"><fieldset><legend>Login</legend><div class="form-group"><label class="col-md-4 control-label" for="username">Username</label>  <div class="col-md-4"><input id="username" name="username" type="text" placeholder="user" class="form-control input-md" required="">    </div></div><div class="form-group"><label class="col-md-4 control-label" for="password">Password</label><div class="col-md-4"><input id="password" name="password" type="password" placeholder="password" class="form-control input-md" required=""></div></div><div class="form-group"><div class="col-md-1 col-md-offset-7"><button id="login" name="login" class="btn btn-default">Submit</button></div></div></fieldset></form></div>',-1);
				$("#login").click(function(){
					//set cookies?
					//load config?
					popup();
				});
			} else
			popup();
		}
		function popup(content,height) {
			if(content == undefined || content == ""){
				$("#popup").hide();
				$("#overlay").hide();
			} else {
				$("#popup").show();
				$("#overlay").show();
				$("#popup").html(content);
				if(height == undefined || height == -1){
					$("#popup").height("auto");
				} else {
					$("#popup").height(height);
				}
			}

		}
	</script>
</body>
</html>