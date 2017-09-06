<!DOCTYPE html>
<html>
	<head>
		<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<title>Alpha</title>
		<style>
			*{
				font-family:Courier;
			}
			#topbar{
				background-color:#000000;
				margin-bottom:0px;
				height:50px;
			}
			#title{
				font-family:Courier;
				font-size:28px;
				color:#ffffff;

			}
			#sidebar{
				background-color:#223344;
				float: left;
				margin-top:0px;
				padding-left:4px;
				padding-right: 4px; 
				height:700px;
				width:300px;
				color:white;				
			}
			#main{
				background-color:#6666aa;
				float:center;
				margin-top:0px;
				height:700px;
				padding-left:20px;
			}
			#gamecanvas{
				background-color:#ffffff;
				margin-left:20px;
				margin-top:20px;
			}
			#input{
				float:bottom;
			}
			#blockid{
				background-color:#ffffff;
				margin-left:20px;
				border: 2px solid black;
			}
			#start{
				margin-left:20px;
				border:3px dashed black;
				background-color:#ffffff;
			}
			#display, #display2{
				color: #ffffff;
			}
		</style>
	</head>
	<body>
	<div id="topbar">
		<p id="title">Game One</p>
	</div>
	<div id="sidebar">
		<span id = "display">
		
		</span>
		<br/><br/>
		<span id = "display2">
		
		</span>
		
	</div>
	<div id="main">
		<canvas id="gamecanvas" width="800px" height="600px">
			Your browser does not support html5<br/><span style="font-size:5px">cough cough... internet explorer</span>
		</canvas>
		
	</div>
	<script src="display.js"></script>

	</body>
</html>