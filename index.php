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
	<meta name="mobile-web-app-capable" content="yes">

	<link rel="icon" href="favicon.ico" type="image/x-icon" />
	
	<link href="styles/bootstrap.min.css" rel="stylesheet" />
	<style>
		#map {
			height: 93vh;
			width:100vw;
			position:absolute;
			bottom:0;
		}
		html, body {
			height: 100vh;
			margin: 0;
			padding: 0;
			background-color: #333;
		}
		.navbar {
			margin-bottom: 0px;
			height: 50px;
		}

		#popup {
			z-index: 2000;
			position: absolute;
			top: 0px;
			margin: 0;
			height: 100vh;
			width: 100vw;
		}
		#overlay {
			z-index:1040;
			background-color: #333;
			opacity:.4;
			width:100%;
			height:100%;
			position: absolute;
			top:0px;
		}
		.close {
			margin-left: 90%;
		}
		img.play {
			position: relative;
			margin:auto;
		}
		#popup span{
			display: inline-block;
			width: 15vw;
		}
		span.grey{
			color: #bbb;
		}
		span.green {
			color: #4eb660;
		}
		span.red {
			color:#ed7575;
		}
		video.v1 {
			background-color: #4eb660;
		}
		video.v2 {
			background-color: #33454f;
		}
		nav {
			z-index: 0;
		}
		li.navbar-text>a {
			padding: 0px 10px;
		}

		.btn-default:hover{
			color: #333;
			background-color: #fff;
			border-color: #ccc;
		}
		.sm-hide {
			display: none;
		}
		@media screen and (min-width: 480px) {
			#popup {
				z-index: 2000;
				position: absolute;
				top: 0px;
				margin: 10vh 20vw;
				height: 80vh;
				width: 60vw;
				overflow-y: hidden;
				overflow-x: hidden;
			}
			#popup.flow {
				overflow-y: scroll;
				overflow-x: hidden;
			}
			#popup span{
				width: 3vw;
			}
			.navbar-form {
				margin: 0px;
			}
			.btn-default:hover {
				color: #333;
				background-color: #e6e6e6;
				border-color: #adadad;
			}
			.sm-hide {
				display: initial;
			}
		}
	</style>
	<script src="https://use.fontawesome.com/763405a8db.js"></script>
</head>
<body>
	<nav role="navigation" class="navbar navbar-default navbar-fixed-top">
		<div class="container">

			<!-- Title -->
			<div class="navbar-header pull-left">
				<a class="navbar-brand" href="#"> 
					<span><img alt="Brand" src="img/icon.png" style="height: 100%"/><span class="sm-hide"> Battuta</span></a></span>
				</a>
			</div>
			<div class="navbar-header pull-right">
				<ul class="nav pull-left">
					<li class="navbar-text pull-left"><a href="#"><i class="fa fa-info" aria-hidden="true"></i><span class="search-hide"> Nearby</span></a></li>
					<li class="navbar-text pull-left"><a href="#"><i class="fa fa-home" aria-hidden="true"></i><span class="search-hide"> Our Site</span></a></li>
					<span id="search-elem">
						<li class="navbar-text pull-left" style="margin: 7px 0px;">
							<input type="text" class="form-control" id="search" placeholder="Search">
						</li>
						<li class="navbar-text pull-left" style="margin: 7px 0px;">
							<button type="submit" id="submit" class="btn btn-default">Search</button>
						</li>
					</span>
				</ul>
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
			center = {lat: 41.7045216, lng: -86.233559};
			map = new google.maps.Map($('#map')[0], {
				zoom: 15,
				streetViewControl: false,
				center: center
			});
			var markers = [
			marker("Notre Dame Main Building",{lat:41.703026, lng:-86.238964},"img/domeCover.png","mov/main_build.mp4","mov/dome.mp4"),
			marker("Hesburgh Library",{lat:41.702358, lng:-86.234194},""),
			marker("Basilica of the Sacred Heart",{lat:41.7026517,lng:-86.23974629999998},"img/basilCover.png","mov/basilica.mp4","mov/basil.mp4"),
			marker("LaFortune Student Center",{lat:41.7019183,lng:-86.23766969999997},""),
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
		function marker(name,loc,img, mov1, mov2){
			var marker = new google.maps.Marker({
				position: loc,
				map: map,
				title: name
			});
			var content = '<div class="close" onclick="popup()"><i class="fa fa-times fa-lg"></i></div><br/><div class="text-center">';
			content += "<h1>"+name+'</h1><img style="height:20vh;display:block;margin-left:auto;margin-right:auto;" src=\"'+img+"\"></img><h2>Recommended for you:</h2>";
			content += '<div class="row"><div class="col-md-5 col-md-offset-1"><video width="100%" class="aspect v1" controls><source src="'+mov1+'" type="video/mp4"></video><br/><span class="grey"><i class="fa fa-eye"></i> 8300</span> <span class="green"><i class="fa fa-comment"></i> 53</span> <span class="red"><i class="fa fa-heart"></i> 98</span></div><div class="col-md-5"><video width="100%" class="aspect v2" controls><source src="'+mov2+'" type="video/mp4"></video><br/><span class="grey"><i class="fa fa-eye"></i> 6557</span> <span class="green"><i class="fa fa-comment"></i> 43</span> <span class="red"><i class="fa fa-heart"></i> 10</span></div></div></div>'
			content += '<div class="row"><div class="col-md-5 col-md-offset-1 text-center"></div>';
			content += '</div>';
			google.maps.event.addListener(marker, 'click', function() {
				popup(content,"80vh",true);
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

		popup();
		toggleFullScreen();
		locate();
		var visible = true;
		$(function(){
			$( window ).resize(function(){$("#map").height($(window).height()-$("nav").height());}).resize();
			$("#submit").click(function(e) {
				if(visible){
					searchq();
					$('#search').val("");
					$('#search-elem').mouseout();
				}
			});
			if($(window).width() < 480){
				visible = false;
				$("#search").hide().width("35%");
				$("#search-elem").click(function(){
					visible = true;
					$(".search-hide").hide();
					$("#search").show();
				});
				$(document).click(function(event) { 
					if(!$(event.target).closest('#search-elem').length) {
						visible = false;
						$(".search-hide").show();
						$("#search").hide();
					}        
				});
			}
		});
		function searchq(){
			var text = $('#search').val();
			var content = text;
			popup(content,"80vh",false);
		}
		function pos(position) {
			map.setCenter({lat: position.coords.latitude, lng: position.coords.longitude});
			var marker = new google.maps.Marker({
				position: {lat: position.coords.latitude, lng: position.coords.longitude},
				map: map,
				icon: "https://mt.google.com/vt/icon/name=icons/spotlight/star_L_8x.png&scale=1"
			});
		}
		function locate(){
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(pos);
				setTimeout(locate, 500);
			} else {
				console.log("Geolocation is not supported by this browser.");
			}
		}
		function popup(content,height,flow) {
			if(content == undefined || content == ""){
				$("#popup").hide();
				$("#overlay").hide();
			} else {
				$("#popup").show();
				$("#overlay").show();
				$("#popup").html(content);
				if($(window).width()<480 || height == undefined || height == -1){
					$("#popup").height("auto");
				} else {
					$("#popup").height(height);
				}
				if(flow == undefined || flow == false){
					$("#popup").removeClass("flow");
				} else {
					$("#popup").addClass("flow");
				}
			}
			$("video.aspect").each(function(){$(this).height($(this).width()*3/4);});
		}
		function toggleFullScreen() {
			var doc = window.document;
			var docEl = doc.documentElement;

			var requestFullScreen = docEl.requestFullscreen || docEl.mozRequestFullScreen || docEl.webkitRequestFullScreen || docEl.msRequestFullscreen;
			var cancelFullScreen = doc.exitFullscreen || doc.mozCancelFullScreen || doc.webkitExitFullscreen || doc.msExitFullscreen;

			if(!doc.fullscreenElement && !doc.mozFullScreenElement && !doc.webkitFullscreenElement && !doc.msFullscreenElement) {
				requestFullScreen.call(docEl);
			}
			else {
				cancelFullScreen.call(doc);
			}
		}
		var levenshteinenator = (function () {
			function levenshteinenator(a, b) {
				var cost;
				var m = a.length;
				var n = b.length;
				if (m < n) {
					var c = a; a = b; b = c;
					var o = m; m = n; n = o;
				}

				var r = []; r[0] = [];
				for (var c = 0; c < n + 1; ++c) {
					r[0][c] = c;
				}

				for (var i = 1; i < m + 1; ++i) {
					r[i] = []; r[i][0] = i;
					for ( var j = 1; j < n + 1; ++j ) {
						cost = a.charAt( i - 1 ) === b.charAt( j - 1 ) ? 0 : 1;
						r[i][j] = minimator( r[i-1][j] + 1, r[i][j-1] + 1, r[i-1][j-1] + cost );
					}
				}

				return r;
			}
			function minimator(x, y, z) {
				if (x <= y && x <= z) return x;
				if (y <= x && y <= z) return y;
				return z;
			}

			return levenshteinenator;

		}());
	</script>
</body>
</html>