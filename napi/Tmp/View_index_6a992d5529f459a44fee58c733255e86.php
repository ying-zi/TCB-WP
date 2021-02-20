<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no" />
	<title>Hello World!</title>
	<style type="text/css">
		* {
			font-family: Consolas, "Andale Mono WT", "Andale Mono", "Lucida Console", "Lucida Sans Typewriter", "DejaVu Sans Mono", "Bitstream Vera Sans Mono", "Liberation Mono", "Nimbus Mono L", Monaco, "Courier New", Courier, monospace;
		}
		html {
			font-size:20px;
			overflow-y: hidden;
		}
		body {
			background-image: -webkit-linear-gradient(to bottom right, #888888, #333333);
			background-image: linear-gradient(to bottom right, #888888, #333333);
			margin: 0;
		}
		.blue {
			color: #29b6f6;
		}
		.green {
			color: #9ccc65;
		}
		.purple {
			color: #ba68c8;
		}
		.cyan {
			color: #4dd0e1;
		}
		.red {
			color: #ef5350;
		}
		.content {
			height: 100vh;
			color: white;
			display: flex;
			justify-content: center;
			align-items: center;
		}
		.card {
			-webkit-perspective: 150rem;
			perspective: 150rem;
			height: 15rem;
			width: 20rem;
			position: relative;
		}
		.card__side {
			height: 15rem;
			transition: all 0.8s ease;
			position: absolute;
			top: 0;
			left: 0;
			margin: auto;
			width: 20rem;
			-webkit-backface-visibility: hidden;
			backface-visibility: hidden;
			border-radius: 3px;
			overflow: hidden;
			box-shadow: 0 1.5rem 4rem rgba(0, 0, 0, 0.4);
		}
		.card__side--front {
			background-color: #1c1c1c;
		}
		.card__side--back {
			-webkit-transform: rotateY(180deg);
			transform: rotateY(180deg);
			background-color: #1c1c1c;
		}
		.card:hover .card__side--front {
			-webkit-transform: rotateY(-180deg);
			transform: rotateY(-180deg);
		}
		.card:hover .card__side--back {
			-webkit-transform: rotateY(0deg);
			transform: rotateY(0deg);
		}
		.card__cont {
			height: 15rem;
			background-color: #1c1c1c;
			display: flex;
			align-items: center;
			justify-content: center;
		}
		.card__cta {
			position: absolute;
			top: 50%;
			left: 50%;
			-webkit-transform: translate(-50%, -50%);
			transform: translate(-50%, -50%);
			width: 90%;
			color: white;
		}
		.card__cta p {
			margin-left: 1rem;
		}
		.card__cta p >.space {
			margin-left: 2rem;
		}
		@media screen and (min-width: 601px) {
			.card {
				width: 30rem;
			}
			.card__side {
				width: 30rem;
			}
		}
		@media screen and (min-width: 561px) and (max-width: 600px) {
			.card {
				width: 28rem;
			}
			.card__side {
				width: 28rem;
			}
		}
		@media screen and (min-width: 521px) and (max-width: 560px) {
			.card {
				width: 26rem;
			}
			.card__side {
				width: 26rem;
			}
		}
		@media screen and (min-width: 481px) and (max-width: 520px) {
			.card {
				width: 24rem;
			}
			.card__side {
				width: 24rem;
			}
		}
		@media screen and (min-width: 441px) and (max-width: 480px) {
			.card {
				width: 22rem;
			}
			.card__side {
				width: 22rem;
			}
		}
		@media screen and (min-width: 361px) and (max-width: 400px) {
			html {
				font-size:18px;
			}
		}
		@media screen and (min-width: 321px) and (max-width: 360px) {
			html {
				font-size:16px;
			}
		}
		@media screen and (max-width: 320px) {
			html {
				font-size:14px;
			}
		}
	</style>
</head>
<body>
<div class="content">
	<div class="card">
		<div class="card__side card__side--front">
		<!-- Front Content -->
			<div class="card__cont">
				<span class="blue">alert</span>
				<span>(<span class="green">'Hello World!'</span>)</span>
			</div>
		</div>
		<div class="card__side card__side--back">
		<!-- Back Content -->
			<div class="card__cta">
				<p><span class="purple">const</span> aboutMe <span class="cyan">=</span> {<br /><span class="space red">name</span><span class="cyan">:</span><span class="green">'YingZi'</span>,<br /><span class="space red">position</span><span class="cyan">:</span><span class="green">'路漫漫其修远兮,吾将上下而求索...</span>',<br /><span class="space red">email</span><span class="cyan">:</span><span class="green">'I@YingZi.Email'</span>,<br /><span class="space red">WeChat</span><span class="cyan">:</span><span class="green">'ying-zi'</span><br />};</p>
			</div>
		</div>
	</div>
</div>
</body>
</html>