<!-- Define file as HTML for browser. -->
<!DOCTYPE html>
<!-- Declare native language. -->
<html lang="en">
	<!-- Declare Head for metadata. -->
	<head>

		<!-- Set website character set and dimensions so that it displays correctly. -->
		<meta charset="UTF-8">
		<!-- Inform old browsers that the site is supported. -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!-- Scale the site to the screen size of the device viewing it. -->
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Link to favicons for thumbnails in browsers. -->
		<!-- Generic: -->
		<link rel="icon" type="image/x-icon" href="assets/favicons/favicon.ico">
		<link rel="icon" href="assets/images/favicons/favicon-32.png" sizes="32x32">
		<link rel="icon" href="assets/images/favicons/favicon-57.png" sizes="57x57">
		<link rel="icon" href="assets/images/favicons/favicon-76.png" sizes="76x76">
		<link rel="icon" href="assets/images/favicons/favicon-96.png" sizes="96x96">
		<link rel="icon" href="assets/images/favicons/favicon-128.png" sizes="128x128">
		<link rel="icon" href="assets/images/favicons/favicon-192.png" sizes="192x192">
		<link rel="icon" href="assets/images/favicons/favicon-228.png" sizes="228x228">
		<!-- Android: -->
		<link rel="shortcut icon" sizes="196x196" href="assets/images/favicons/favicon-196.png">
		<!-- iOS: -->
		<link rel="apple-touch-icon" href="assets/images/favicons/favicon-120.png" sizes="120x120">
		<link rel="apple-touch-icon" href="assets/images/favicons/favicon-152.png" sizes="152x152">
		<link rel="apple-touch-icon" href="assets/images/favicons/favicon-180.png" sizes="180x180">
		<!-- Windows 8 IE 10: -->
		<meta name="msapplication-TileColor" content="#FFFFFF">
		<meta name="msapplication-TileImage" content="assets/images/favicons/favicon-144.png">
		<!-- Windows 8.1 + IE11 and above: -->
		<meta name="msapplication-config" content="assets/images/favicons/browserconfig.xml"/>

		<!-- Declare Page Title. -->
		<title>TrueOG</title>

		<!-- Import Font Awesome 4.7 and keep the rendering engine awake using PHP trick. -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css?v=<?php echo time(); ?>">
		<!-- Import custom CSS and keep the rendering engine awake using PHP trick. -->
		<link rel="stylesheet" href="stylesheet.css?v=<?php echo time(); ?>">

	<!-- Close Head. -->
	</head>

	<!-- Declare Body. -->
	<body>

		<!-- Declare Header. -->
		<header>

			<!-- Display TrueOG logo in top left of navbar. -->
			<a href="https://www.true-og.net/" target="_blank">
			<img src="assets/images/logos/true-og-logo-transparent-background.png" class="main-logo" alt="Logo"></a>

			<!-- Declare navigation menu. -->
			<nav class="outlined">

				<!-- Declare navigation button for Games. -->
				<li><a href="#smp">&nbsp;&nbsp;<i class="fa fa-gamepad bukkit-gold">&nbsp;&nbsp;</i><strong>Games</strong></a></li>
				<!-- Declare navigation button for Shop. -->
				<li><a href="#shop">&nbsp;&nbsp;<i class="fa fa-shopping-bag bukkit-red">&nbsp;&nbsp;</i><strong>Shop</strong></a></li>
				<!-- Declare navigation button for Team. -->
				<li><a href="#team">&nbsp;&nbsp;<i class="fa fa-users bukkit-dark-purple">&nbsp;&nbsp;</i><strong>Team</strong></a></li>
				<!-- Declare navigation button for FAQ. -->
				<li><a href="#faq">&nbsp;&nbsp;<i class="fa fa-question-circle bukkit-darkgreen">&nbsp;&nbsp;</i><strong>FAQ</strong></a></li>

			<!-- Close navigation menu. -->
			</nav>

		<!-- Close Header. -->
		</header>

		<!-- TODO: Refactor/Comment below this line -->
		<section class="banner">
			<div class="background-image" style="background-image: url(assets/images/galaxy-background.png);"></div>
			<p class="simple-highlight bukkit-green">The <a href="https://github.com/true-og/true-og/">Open Source</a>,</p>
			<p class="simple-highlight bukkit-blue">Community-First,</p>
			<p><span class="simple-highlight bukkit-dark-red"><u>&nbsp;OG</u></span><span class="simple-highlight bukkit-gold">&nbsp;&nbsp;Minecraft Experience!&nbsp;</span></p>
    		<h5 style="font-family: minecraft; text-shadow: 3px 3px 1px black; padding-top: 20px;" class="bukkit-blue">
    		<?php
    			$waiting_day = 1686837600;
    			$time_left = $waiting_day - time();

    			$days = floor($time_left / (60*60*24));
    			$time_left %= (60 * 60 * 24);

    			$hours = floor($time_left / (60 * 60));
    			$time_left %= (60 * 60);

    			$min = floor($time_left / 60);
    			$time_left %= 60;

    			echo "$days days, $hours hours, and $min minutes until soft launch.";
    		?>
    		</h5>

			<a style="text-decoration:none; font-size: 3.5vw; color: #738ADB; margin-top: 8%; text-shadow: 0px 0px 30px white, 0 2px 0 white;" href="https://discord.gg/ma9pMYpBU6">&nbsp;JOIN DISCORD&nbsp;</a>
		</section>

		<div class="games" id="smp">
			<div class="box">
				<div class="flex-child grid outlined">
					<h1 style="color: white; text-align: center"><i class="fa fa-cubes bukkit-darkgreen"></i>&nbsp;The <span class="bukkit-darkgreen">True</span><span class="bukkit-dark-red">OG</span> SMP:</h1>
					<p style="color: white; font-size: 2.5vh; padding: 0vh"><br>Our biggest and best gamemode, the SMP is where it all began. <span class="bukkit-darkgreen">True</span><span class="bukkit-dark-red">OG</span>'s founders were once players on a server which announced a map reset and a general shift away from the "OG" gameplay meta.<br><br>We revolted against their bad choices by buying the map, splitting from the original server, and making the worlds into our own. We rebuilt the old SMP's features from the ground up, fixing many bugs, opening up the code to the community, and enhancing the experience wherever possible.<br><br>Our SMP has grown into its own, preserving the incredible history of the original worlds, enabling a unique, yet familiar meta that evokes memories of 2011-2013 community-run SMP servers.</p>
				</div>
			</div>
			<div class="box">
				<div class="flex-child large grid zoomedout roundedcorners" style="filter: drop-shadow(0 0 0.3rem #FFAA00); background-image: url(assets/images/smp-banner-two.png)"></div>
				<div class="flex-child small grid splitter outlined">
					<h2 style="color: white; text-align: center"><strong class="bukkit-gold">The "OG" Meta:</strong></h2>
					<p class="bukkit-gold" style="font-size: 2.5vh"><br>OG means more to us than "not being pay-to-win". OG is about maintaining and building upon what we loved about SMP servers back in the day. A simple, robust economy. Competative, fast-paced PvP. Worlds that become richer and more fun to explore as the versions go by, giving players a sense of deep time and community. The <span class="bukkit-darkgreen">True</span><span class="bukkit-red">OG</span> Meta is more "OG" than OG:SMP and more anarchistic than anarchy. Here, you are truly free to play however you want, on a fair playing field. No bots. No hacks. There's nothing quite like it in Minecraft, or any other game for that matter.</p>
				</div>
			</div>
			<div class="box">
				<div class="flex-child small grid splitter bukkit-red outlined">
					<h2 style="text-align: center"><strong>Great on 1.8:</strong></h2>
					<p style="font-size: 2.5vh"><br>Unlike some other servers, we don't believe in leaving our loyal players in the dust with no support. There are good reasons many people continue to use Minecraft 1.8. From performance, to combat, to mods. If you are one of them, welcome home! Here you will experience being treated like a first class citizen. We have working fishing rods, ladders, lily pads, and brewing stands. All potions work on 1.8 at their correct durations. Builds at spawn have been optimized for 1.8 block appearance. You can even craft enchanted golden apples!</p>
				</div>
				<div class="flex-child large grid zoomedout roundedcorners" style="filter: drop-shadow(0 0 0.3rem #FF5555); background-image: url(assets/images/smp-banner-five.png)"></div>
			</div>
		</div>

		<!-- <div class="games" id="duels">
			<div class="box">
				<div class="flex-child grid outlined">
					<h1 style="color: white; text-align: center"><i class="fa fa-heartbeat bukkit-dark-red"></i>&nbsp;<span class="bukkit-darkgreen">True</span><span class="bukkit-dark-red">OG</span> Duels:</h1>
					<p style="color: white; font-size: 2.5vh; padding: 0vh"><br>A long-requested feature of the Season 1 community, <span class="bukkit-darkgreen">True</span><span class="bukkit-red">OG</span> Duels allow you to challenge anyone to a fight without risking your gear, experience, or SMP stats. Duel stats are tracked in an entirely seperate system called <a href="https://dotesports.com/general/news/elo-ratings-explained-20565" target="_blank" class="bukkit-blue">ELO</a>.<br><br>All duels take place using glorious 1.8 PVP! You will be equipped with golden apples, ender pearls, a variety of potions, and weapons/armor according to your kit selections. You can cycle through a random arena, or pick your favorite from over a dozen custom builds. If you are feeling confident, you can even duel for Diamonds!</p>
				</div>
			</div>
			<div class="container bukkit-green" style="margin-bottom: 2vh; filter: drop-shadow(0 0 0.3rem black);">
				<img src="assets/images/Atlantis.png" class="image-item zoomedout roundedcorners" alt="Atlantis">
				<span class="overlay">Atlantis</span>
				<img src="assets/images/Blizzard.png" class="image-item zoomedout roundedcorners" alt="Blizzard">
				<div class="overlay"><span>Blizzard</span></div>
				<img src="assets/images/Castle.png" class="image-item zoomedout roundedcorners" alt="Castle">
				<div class="overlay"><span>Castle</span></div>
				<img src="assets/images/Cave.png" class="image-item zoomedout roundedcorners" alt="Cave">
				<div class="overlay"><span>Cave</span></div>
				<img src="assets/images/Colosseum.png" class="image-item zoomedout roundedcorners" alt="Colosseum">
				<div class="overlay"><span>Colosseum</span></div>
				<img src="assets/images/Ender.png" class="image-item zoomedout roundedcorners" alt="Ender">
				<div class="overlay"><span>Ender</span></div>
				<img src="assets/images/Frozone.png" class="image-item zoomedout roundedcorners" alt="Frozone">
				<div class="overlay"><span>Frozone</span></div>
				<img src="assets/images/Fungi.png" class="image-item zoomedout roundedcorners" alt="Fungi">
				<div class="overlay"><span>Fungi</span></div>
				<img src="assets/images/Hell.png" class="image-item zoomedout roundedcorners" alt="Hell">
				<div class="overlay"><span>Hell</span></div>
				<img src="assets/images/Olympus.png" class="image-item zoomedout roundedcorners" alt="Olympus">
				<div class="overlay"><span>Olympus</span></div>
				<img src="assets/images/Sewer.png" class="image-item zoomedout roundedcorners" alt="Sewer">
				<div class="overlay"><span>Sewer</span></div>
			</div>
		</div>-->

		<footer>
			<ul>
				<li><a href="https://github.com/true-og/website/" target="_blank"><i class="fa fa-github-square"></i></a></li>
				<li><a href="https://www.facebook.com/people/True-OG/100076093982787/" target="_blank"><i class="fa fa-facebook-square"></i></a></li>
				<li><a href="https://twitter.com/TrueOGSMP/" target="_blank"><i class="fa fa-twitter-square"></i></a></li>
			</ul>
			<p><a href="https://shop.trueg.net/" target="_blank">Donation Store</a></p>
			<p><br>Forked From <a href="https://tutorialzine.com/2016/06/freebie-landing-page-template-with-flexbox/" target="_blank">tutorialzine</a> under an<a href="https://tutorialzine.com/license/" target="_blank"> Open Source License</a><br><br></p>
			<p><a href="https://questioncopyright.org/understanding-free-content/" target="_blank">
			<img src="assets/images/logos/Anti-copyright.svg" style="width: 50px" alt="Anti-Copyright Logo"></a>
			&nbsp;<a href="https://iww.org/" target="_blank">
			<img src="assets/images/logos/iww.png" style="width: 48px" alt="IWW Union Logo"</a></a>
			<p class="bukkit-blue"><br>Ad astra per aspera</p></span>
		</footer>

		<a href="#" class="top"><i class="fa fa-arrow-circle-o-up"></i></a>

	</body>

</html>
