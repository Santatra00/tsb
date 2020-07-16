<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>EMITRACK - Application de Tracking des bus de l'EMIT</title>
	<link rel="stylesheet" href="<?php $this->load->helper("url"); echo base_url('assets/css/font-awesome.css');?>">
	<style>
		/* @import url('https://fonts.googleapis.com/css?family=Poppins'); */

		/* BASIC */

		html {
			background-color: #56baed;
		}

		body {
			font-family: "Poppins", sans-serif;
			height: 100vh;
		}

		a {
			color: #92badd;
			display: inline-block;
			text-decoration: none;
			font-weight: 400;
		}

		h2 {
			text-align: center;
			font-size: 16px;
			font-weight: 600;
			text-transform: uppercase;
			display: inline-block;
			margin: 40px 8px 10px 8px;
			color: #cccccc;
		}



		/* STRUCTURE */

		.wrapper {
			display: flex;
			align-items: center;
			flex-direction: column;
			justify-content: center;
			width: 100%;
			min-height: 100%;
			padding: 20px;
		}

		#formContent {
			/* -webkit-border-radius: 10px 10px 10px 10px; */
			/* border-radius: 10px 10px 10px 10px; */
			background: #fff;
			padding: 30px;
			width: 90%;
			max-width: 450px;
			position: relative;
			padding: 0px;
			-webkit-box-shadow: 0 30px 60px 0 rgba(0, 0, 0, 0.3);
			box-shadow: 0 30px 60px 0 rgba(0, 0, 0, 0.3);
			text-align: center;
		}

		#formFooter {
			background-color: #f6f6f6;
			border-top: 1px solid #dce8f1;
			padding: 25px;
			text-align: center;
			/* -webkit-border-radius: 0 0 10px 10px; */
			/* border-radius: 0 0 10px 10px; */
		}



		/* TABS */

		h2.inactive {
			color: #cccccc;
		}

		h2.active {
			color: #0d0d0d;
			border-bottom: 2px solid #5fbae9;
		}



		/* FORM TYPOGRAPHY*/

		.material-button {
			background-color: #56baed;
			border: none;
			color: white;
			padding: 15px 80px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			text-transform: uppercase;
			font-size: 13px;
			-webkit-box-shadow: 0 10px 30px 0 rgba(95, 186, 233, 0.4);
			box-shadow: 0 10px 30px 0 rgba(95, 186, 233, 0.4);
			/* -webkit-border-radius: 5px 5px 5px 5px;
			border-radius: 5px 5px 5px 5px; */
			margin: 5px 20px 40px 20px;
			-webkit-transition: all 0.3s ease-in-out;
			-moz-transition: all 0.3s ease-in-out;
			-ms-transition: all 0.3s ease-in-out;
			-o-transition: all 0.3s ease-in-out;
			transition: all 0.3s ease-in-out;
		}

		.material-button:hover {
			background-color: #39ace7;
		}

		.material-button:active {
			-moz-transform: scale(0.95);
			-webkit-transform: scale(0.95);
			-o-transform: scale(0.95);
			-ms-transform: scale(0.95);
			transform: scale(0.95);
		}

		input[type=text] {
			background-color: #f6f6f6;
			border: none;
			color: #0d0d0d;
			padding: 15px 32px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
			margin: 5px;
			width: 85%;
			border: 2px solid #f6f6f6;
			-webkit-transition: all 0.5s ease-in-out;
			-moz-transition: all 0.5s ease-in-out;
			-ms-transition: all 0.5s ease-in-out;
			-o-transition: all 0.5s ease-in-out;
			transition: all 0.5s ease-in-out;
			-webkit-border-radius: 5px 5px 5px 5px;
			border-radius: 5px 5px 5px 5px;
		}

		input[type=text]:focus {
			background-color: #fff;
			border-bottom: 2px solid #5fbae9;
		}

		input[type=text]:placeholder {
			color: #cccccc;
		}


		input[type=email],
		input[type=password] {
			background-color: #f6f6f6;
			border: none;
			color: #0d0d0d;
			padding: 15px 32px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
			margin: 5px;
			width: 85%;
			border: 2px solid #f6f6f6;
			-webkit-transition: all 0.5s ease-in-out;
			-moz-transition: all 0.5s ease-in-out;
			-ms-transition: all 0.5s ease-in-out;
			-o-transition: all 0.5s ease-in-out;
			transition: all 0.5s ease-in-out;
			-webkit-border-radius: 5px 5px 5px 5px;
			border-radius: 5px 5px 5px 5px;
		}

		input[type=email],
		input[type=password]:focus {
			background-color: #fff;
			border-bottom: 2px solid #5fbae9;
		}

		input[type=email],
		input[type=password]:placeholder {
			color: #cccccc;
		}

		.button-file {
			background-color: #f6f6f6;
			border: none;
			color: #0d0d0d;
			padding: 15px 32px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
			margin: 5px;
			width: 85%;
			border: 2px solid #f6f6f6;
			-webkit-transition: all 0.5s ease-in-out;
			-moz-transition: all 0.5s ease-in-out;
			-ms-transition: all 0.5s ease-in-out;
			-o-transition: all 0.5s ease-in-out;
			transition: all 0.5s ease-in-out;
			-webkit-border-radius: 5px 5px 5px 5px;
			border-radius: 5px 5px 5px 5px;
		}

		.button-file:focus {
			background-color: #fff;
			border-bottom: 2px solid #5fbae9;
		}



		/* ANIMATIONS */

		/* Simple CSS3 Fade-in-down Animation */
		.fadeInDown {
			-webkit-animation-name: fadeInDown;
			animation-name: fadeInDown;
			-webkit-animation-duration: 1s;
			animation-duration: 1s;
			-webkit-animation-fill-mode: both;
			animation-fill-mode: both;
		}

		@-webkit-keyframes fadeInDown {
			0% {
				opacity: 0;
				-webkit-transform: translate3d(0, -100%, 0);
				transform: translate3d(0, -100%, 0);
			}

			100% {
				opacity: 1;
				-webkit-transform: none;
				transform: none;
			}
		}

		@keyframes fadeInDown {
			0% {
				opacity: 0;
				-webkit-transform: translate3d(0, -100%, 0);
				transform: translate3d(0, -100%, 0);
			}

			100% {
				opacity: 1;
				-webkit-transform: none;
				transform: none;
			}
		}

		/* Simple CSS3 Fade-in Animation */
		@-webkit-keyframes fadeIn {
			from {
				opacity: 0;
			}

			to {
				opacity: 1;
			}
		}

		@-moz-keyframes fadeIn {
			from {
				opacity: 0;
			}

			to {
				opacity: 1;
			}
		}

		@keyframes fadeIn {
			from {
				opacity: 0;
			}

			to {
				opacity: 1;
			}
		}

		.fadeIn {
			opacity: 0;
			-webkit-animation: fadeIn ease-in 1;
			-moz-animation: fadeIn ease-in 1;
			animation: fadeIn ease-in 1;

			-webkit-animation-fill-mode: forwards;
			-moz-animation-fill-mode: forwards;
			animation-fill-mode: forwards;

			-webkit-animation-duration: 1s;
			-moz-animation-duration: 1s;
			animation-duration: 1s;
		}

		.fadeIn.first {
			-webkit-animation-delay: 0.4s;
			-moz-animation-delay: 0.4s;
			animation-delay: 0.4s;
		}

		.fadeIn.second {
			-webkit-animation-delay: 0.6s;
			-moz-animation-delay: 0.6s;
			animation-delay: 0.6s;
		}

		.fadeIn.third {
			-webkit-animation-delay: 0.8s;
			-moz-animation-delay: 0.8s;
			animation-delay: 0.8s;
		}

		.fadeIn.fourth {
			-webkit-animation-delay: 1s;
			-moz-animation-delay: 1s;
			animation-delay: 1s;
		}

		/* Simple CSS3 Fade-in Animation */
		.underlineHover:after {
			display: block;
			left: 0;
			bottom: -10px;
			width: 0;
			height: 2px;
			background-color: #56baed;
			content: "";
			transition: width 0.2s;
		}

		.underlineHover:hover {
			color: #0d0d0d;
		}

		.underlineHover:hover:after {
			width: 100%;
		}



		/* OTHERS */

		*:focus {
			outline: none;
		}

		#icon {
			width: 60%;
		}

		* {
			box-sizing: border-box;
		}

		.hidden {
			display: none !important;
		}
	</style>

</head>

<body>
	<script src=<?= base_url('assets/js/jquery.min.js')?>>

	</script>
	<div class="wrapper fadeInDown">
		<div id="formContent">
			<!-- Tabs Titles -->
			<h2 class="active" id="signIn"> Authentification </h2>
			<!-- <h2 class="inactive underlineHover" id="signUp">Nouveau </h2> -->

			<!-- Icon -->
			<!-- <div class="fadeIn first">
				<img src="" id="icon" alt="User Icon" />
			</div> -->
			<div style="height: 30px;"></div>
			<div id="contentForm">


			</div>

			<div id="page-zero" class="hidden">

			</div>
			<div id="page-one" class="hidden">
				<form action="<?= base_url("login/login")?>" method="POST">
					<input type="text" id="identity" class="fadeIn second" name="identity" placeholder="Pseudo">
					<input type="password" id="password" class="fadeIn third" name="password" placeholder="Password">
					<div style="color: grey;" class="fadeIn third">
						<input type="checkbox" name="remember" value="remember" class="fadeIn third"> se souvenir
					</div>
					<div style="color: #966;">
						<?= $message?>
					</div>

					<button type="submit" class="fadeIn fourth material-button	" id="submit-nouveau-etudiant">Se
						Connecter</button>
				</form>
			</div>
			
			<div id="page-tree" class="hidden">
				<form action="<?= base_url("login/forbidden")?>" method="POST">
					Veuillez entrer votre adresse pseudo
					<input type="text" id="login" class="fadeIn second" name="identity" placeholder="Pseudo" required>
					<button class="fadeIn fourth material-button" id="submit-nouveau-etudiant">ENVOYER MAIL</button>
				</form>
			</div>
			<div>
			</div>

			<!-- Remind Passowrd -->
			<div id="formFooter">
				<a class="underlineHover" href="#" id="forgotPass">Forgot Password?</a>
			</div>

		</div>
	</div>

	<script>
		window.onload = function () {
			document.getElementById("contentForm").innerHTML = document.getElementById("page-one").innerHTML;
			console.log("window");
		};


		document.getElementById("signIn").addEventListener("click", function () {
			document.getElementById("contentForm").innerHTML = document.getElementById("page-one").innerHTML;
			document.getElementById("signIn").className = "active";
		});
		document.getElementById("forgotPass").addEventListener("click", function () {
			document.getElementById("contentForm").innerHTML = document.getElementById("page-tree").innerHTML;
			document.getElementById("signUp").className = "inactive underlineHover";
		});


		function upload_image_init() {
			var elem = document.getElementById('photo');
			if (elem && document.createEvent) {
				var evt = document.createEvent("MouseEvents");
				evt.initEvent("click", true, false);
				elem.dispatchEvent(evt);
				document.getElementById("photo-input").value = elem.value;
			}
		}

		var cool = {

		};
	</script>


</body>





</html>