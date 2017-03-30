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
		video {
			display: none;
			width: 100%;
			height: 100%;
		}
		@media screen and (min-width: 480px) {
			#popup {
				z-index: 2000;
				position: absolute;
				margin: auto;
				top: 0;
				bottom: 0;
				left: 0;
				right: 0;
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
			#popup .panel {
				cursor: pointer;
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
			.padded {
				padding:0px 2vw;
			}
			a {
				cursor: pointer;
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
					<li class="navbar-text pull-left"><a href="http://www.battutatour.com/"><i class="fa fa-home" aria-hidden="true"></i><span class="search-hide"> Our Site</span></a></li>
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
	<div id="overlay" style="display: none;">
	</div>
	<div id="popup" class="panel panel-default" style="display: none">
	</div>
	<video controls>
		<source src="movie.mp4" type="video/mp4">
		</video>
		<script>
			var map;
			var markers = [];
			markerCluster = null;
			function initMap() {
				center = {lat: 41.7045216, lng: -86.233559};
				map = new google.maps.Map($('#map')[0], {
					zoom: 15,
					streetViewControl: false,
					center: center
				});
				markerCluster = new MarkerClusterer(map, markers,{imagePath: 'img/m'});
				google.maps.event.addListener(markerCluster, 'clusterclick', function(cluster) {
					map.setCenter(cluster.getCenter());
					cluster.getMarkers();
					cluster.getSize();
				});
			}
			function marker(name,loc,id){
				var marker = new google.maps.Marker({
					position: loc,
					map: map,
					title: name
				});
				$.getJSON("api/videos.php?id="+id+"&callback=?",function(data){
					var content = markerTemplate.find("#outer").clone();
				var sort = data[0].length % 3;//handle 1 case eventually
				switch(sort){//rec sould have at most 3
					case 1:
					var single = markerTemplate.find("#inner-single").clone();
					$.each(data[0],function(i,vid){
						var panel = single.find(".panel:eq("+i+")");
						panel.find("img").attr("src","img/"+vid.pro.img);
						panel.find(".panel-body p").html(vid.pro.name + ", " + vid.pro.age);
						panel.addClass("panel-primary").on("click",function(){
							fullscreen($("video source").attr("src","mov/"+vid.vid).parent()[0]);
						});
					});
					content.find("#rec").append(single);
					break;
					case 2:
					var double = markerTemplate.find("#inner-double").clone();
					$.each(data[0],function(i,vid){
						var panel = double.find(".panel:eq("+i+")");
						panel.find("img").attr("src","img/"+vid.pro.img);
						panel.find(".panel-body p").html(vid.pro.name + ", " + vid.pro.age);
						panel.addClass("panel-primary").attr("onclick","fullscreen($('video source').attr('src','mov/"+vid.vid+"').parent()[0])");
					});
					content.find("#rec").append(double);
					break;
					case 0:
					var triple = markerTemplate.find("#inner-triple").clone();
					$.each(data[0],function(i,vid){
						var panel = double.find(".panel:eq("+i+")");
						panel.find("img").attr("src","img/"+vid.pro.img);
						panel.find(".panel-body p").html(vid.pro.name + ", " + vid.pro.age);
						panel.addClass("panel-primary").attr("onclick","fullscreen($('video source').attr('src','mov/"+vid.vid+"').parent()[0])");
					});
					content.find("#rec").append(triple);
					break;
				}

				sort = data[1].length % 3;
				var x = 0;
				for(x = 0; x < data[1].length / 3 - 1; x++){
					var triple = markerTemplate.find("#inner-triple").clone();
					$.each(data[1].slice(3*x,3*x+3),function(i,vid){
						var panel = triple.find(".panel:eq("+i+")");
						panel.find("img").attr("src","img/"+vid.pro.img);
						panel.find(".panel-body p").html(vid.pro.name + ", " + vid.pro.age);
						panel.addClass("panel-default").attr("onclick","fullscreen($('video source').attr('src','mov/"+vid.vid+"').parent()[0])");
					});
					content.find("#addl").append(triple.html());
				}
				switch(sort){
					case 1:
					var single = markerTemplate.find("#inner-single").clone();
					$.each(data[1].slice(3*x,3*x+1),function(i,vid){
						var panel = single.find(".panel:eq("+i+")");
						panel.find("img").attr("src","img/"+vid.pro.img);
						panel.find(".panel-body p").html(vid.pro.name + ", " + vid.pro.age);
						panel.addClass("panel-default").attr("onclick","fullscreen($('video source').attr('src','mov/"+vid.vid+"').parent()[0])");
					});
					content.find("#addl").append(single.html());
					break;
					case 2:
					var double = markerTemplate.find("#inner-double").clone();
					$.each(data[1].slice(3*x,3*x+2),function(i,vid){
						var panel = double.find(".panel:eq("+i+")");
						panel.find("img").attr("src","img/"+vid.pro.img);
						panel.find(".panel-body p").html(vid.pro.name + ", " + vid.pro.age);
						panel.addClass("panel-default").attr("onclick","fullscreen($('video source').attr('src','mov/"+vid.vid+"').parent()[0])");
					});
					content.find("#addl").append(double.html());
					break;
					case 0:
					var triple = markerTemplate.find("#inner-triple").clone();
					$.each(data[1].slice(3*x,3*x+3),function(i,vid){
						var panel = triple.find(".panel:eq("+i+")");
						panel.find("img").attr("src","img/"+vid.pro.img);
						panel.find(".panel-body p").html(vid.pro.name + ", " + vid.pro.age);
						panel.addClass("panel-default").attr("onclick","fullscreen($('video source').attr('src','mov/"+vid.vid+"').parent()[0])");
					});
					content.find("#addl").append(triple.html());
					break;
				}
				google.maps.event.addListener(marker, 'click', function() {
					popup(content.html());
				});
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
	pullMarkers();
	locate();
	var visible = true;
	var posMark = null;
	markerTemplate = null;
	$.get("api/markerTemplate.html",function(html){
		markerTemplate = $(html);
	})
	$(function(){
		$( window ).resize(function(){
			$("#popup").removeClass("flow");
			if(Math.ceil($("#popup").height()) < $("#popup")[0].scrollHeight - 10){
				$("#popup").addClass("flow");
			}
			$("#map").height($(window).height()-$("nav").height());
		}).resize();
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
	function pullMarkers(){
		$.getJSON("api/markers.php?callback=?",function(data){
			$.each(data,function(i,item){
				var newmark = marker(item.name,item.loc,item.id);
				markers.push(newmark);
				if(markerCluster != null)
					markerCluster.addMarker(newmark);
			});
		});
	}
	function searchq(){
		var text = $('#search').val();
		$.getJSON("api/search.php?query="+text+"&callback=?",function(data){
			var content = "";
			$.each(data,function(i,item){
				content += "<div><a>"+item+"</a></div>";
			});

			popup(content);
		});
	}
	function pos(position) {
		if(posMark==null){
			map.setCenter({lat: position.coords.latitude, lng: position.coords.longitude});
			posMark = new google.maps.Marker({
				position: {lat: position.coords.latitude, lng: position.coords.longitude},
				map: map,
				icon: "https://mt.google.com/vt/icon/name=icons/spotlight/star_L_8x.png&scale=1"
			});
		}
		posMark.setPosition({lat: position.coords.latitude, lng: position.coords.longitude});
	}
	function locate(){
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(pos);
			setTimeout(locate, 500);
		} else {
			console.log("Geolocation is not supported by this browser.");
		}
	}
	function popup(content) {
		if(content == undefined || content == ""){
			$("#popup").hide();
			$("#overlay").hide();
		} else {
			$("#popup").show();
			$("#overlay").show();
			$("#popup").html(content);
			if($(window).width()<480){
				$("#popup").css("height","initial");
			} else {
				$("#popup").css("height","");
			}
			$("#popup").removeClass("flow");
			if(Math.ceil($("#popup").height()) < $("#popup")[0].scrollHeight - 10){
				$("#popup").addClass("flow");
			}
		}
			//$("video.aspect").each(function(){$(this).height($(this).width()*3/4);});
		}
		function fullscreen(elem){
			if(elem.requestFullscreen)
				elem.requestFullscreen();
			else if(elem.webkitRequestFullscreen)
				elem.webkitRequestFullscreen();
			else if(elem.mozRequestFullScreen)
				elem.mozRequestFullScreen();
			else if(elem.msRequestFullscreen)
				elem.msRequestFullscreen();
		}
	</script>
</body>
</html>