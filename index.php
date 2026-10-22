<?php
require __DIR__ . '/site.php';
page_start('', 'banner');
?>
			<!-- Full-screen banner: galaxy background behind the header, tagline centered below it. -->
			<div class="background-image" style="background-image: url(assets/images/galaxy-background.png);"></div>
			<div class="tagline">
				<p class="bukkit-green">The <a href="https://git.trueog.net/trueog/true-og">Open Source</a>,</p>
				<p class="bukkit-blue">Community-First,</p>
				<p><span class="bukkit-red"><u>OG</u></span> <span class="bukkit-gold">Minecraft Experience!</span></p>
				<a class="discord-button" href="https://discord.gg/ma9pMYpBU6"><i class="fa-brands fa-discord fa-width-auto" aria-hidden="true"></i> JOIN DISCORD</a>
			</div>
		</div>

		<!-- Games: the SMP. The first row introduces it; each row after pairs a screenshot with a topic. -->
		<div class="games" id="smp">
			<div class="box">
				<div class="flex-child outlined">
					<h1><i class="fa-solid fa-cubes bukkit-darkgreen fa-width-auto" aria-hidden="true"></i>&nbsp;The <span class="bukkit-green">True</span><span class="bukkit-red">OG</span> SMP:</h1>
					<p><br>Our biggest and best gamemode, the SMP is where it all began. <span class="bukkit-green">True</span><span class="bukkit-red">OG</span>'s founders were once players on a server which announced a map reset and a general shift away from the "OG" gameplay meta.<br><br>We revolted against their bad choices by buying the map, splitting from the original server, and making the worlds into our own. We rebuilt the old SMP's features from the ground up, fixing many bugs, opening up the code to the community, and enhancing the experience wherever possible.<br><br>Our SMP has grown into its own, preserving the incredible history of the original worlds, enabling a unique, yet familiar meta that evokes memories of 2011-2013 community-run SMP servers.</p>
				</div>
			</div>
			<div class="box">
				<div class="flex-child large zoomedout roundedcorners" style="filter: drop-shadow(0 0 0.3rem #FFAA00); background-image: url(assets/images/smp-banner-two.png)"></div>
				<div class="flex-child small splitter outlined">
					<h2><strong class="bukkit-gold">The "OG" Meta:</strong></h2>
					<p class="bukkit-gold"><br>OG means more to us than "not being pay-to-win". OG is about maintaining and building upon what we loved about SMP servers back in the day. A simple, robust economy. Competative, fast-paced PvP. Worlds that become richer and more fun to explore as the versions go by, giving players a sense of deep time and community. The <span class="bukkit-green">True</span><span class="bukkit-red">OG</span> Meta is more "OG" than OG:SMP and more anarchistic than anarchy. Here, you are truly free to play however you want, on a fair playing field. No bots. No hacks. There's nothing quite like it in Minecraft, or any other game for that matter.</p>
				</div>
			</div>
			<div class="box">
				<div class="flex-child small splitter bukkit-red outlined">
					<h2><strong>Great on 1.8:</strong></h2>
					<p><br>Unlike some other servers, we don't believe in leaving our loyal players in the dust with no support. There are good reasons many people continue to use Minecraft 1.8. From performance, to combat, to mods. If you are one of them, welcome home! Here you will experience being treated like a first class citizen. We have working fishing rods, ladders, lily pads, and brewing stands. All potions work on 1.8 at their correct durations. Builds at spawn have been optimized for 1.8 block appearance. You can even craft enchanted golden apples!</p>
				</div>
				<div class="flex-child large zoomedout roundedcorners" style="filter: drop-shadow(0 0 0.3rem #FF5555); background-image: url(assets/images/smp-banner-five.png)"></div>
			</div>
			<div class="box">
				<div class="flex-child large zoomedout roundedcorners" style="filter: drop-shadow(0 0 0.3rem #55FFFF); background-image: url(assets/images/smp-banner-three.png)"></div>
				<div class="flex-child small splitter bukkit-blue outlined">
					<h2><strong>Classic Combat:</strong></h2>
					<p><br><span class="bukkit-green">True</span><span class="bukkit-red">OG</span> utilizes the 1.8 style PvP/PvE system with NO click-delay. We believe this model is vastly superior to 1.9+ combat. It's quicker, more intense, and has a longer, more fulfilling skill ladder. Mojang is well aware of the new system's flaws, which is why they haven't added it to Bedrock. The experimental combat snapshot also eliminates the click-delay, and we will consider switching to those new mechanics once they are rolled out in a future version of Minecraft. Until that time we are committed to supporting 1.8 combat.</p>
				</div>
			</div>
			<div class="box">
				<div class="flex-child small splitter bukkit-green outlined">
					<h2><strong>Open Source:</strong></h2>
					<p><br><span class="bukkit-green">True</span><span class="bukkit-red">OG</span> is run by a dedicated Socialist and open source advocate. As such, the server is <a href="https://git.trueog.net/trueog/true-og" target="_blank" class="bukkit-blue">published on Gitea</a> in its entirety. Original code uses <a href="https://unlicense.org/" target="_blank" class="bukkit-blue">The Unlicense</a>, meaning it is released into the public domain for any purpose, commercial or personal, for free, forever. The code for community projects utilized by <span class="bukkit-green">True</span><span class="bukkit-red">OG</span> is linked to on GitHub. Their respective terms must be followed. The only proprietary part of <span class="bukkit-green">True</span><span class="bukkit-red">OG</span> is our post-launch map and seed. This is to prevent coordinates and bases from being compromised.</p>
				</div>
				<div class="flex-child large zoomedout roundedcorners" style="filter: drop-shadow(0 0 0.3rem #55FF55); background-image: url(assets/images/smp-banner-four.png)"></div>
			</div>
		</div>

		<!-- Shop: the donor ranks, mirrored from the store at store.trueog.net. -->
		<div class="games" id="shop">
			<div class="box">
				<div class="flex-child outlined">
					<h1><i class="fa-solid fa-bag-shopping bukkit-red fa-width-auto" aria-hidden="true"></i>&nbsp;The <span class="bukkit-green">True</span><span class="bukkit-red">OG</span> Shop:</h1>
					<p><br>Premium Ranks are affordable, <strong class="bukkit-gold">never pay-to-win</strong>, and help the server thrive! Your contribution helps us pay for server bills, DDOS protection, advertising, and a plethora of free and open source services. Any contributions in a given month that exceed our monthly expenses are distributed via a democratic vote of the staff team.<br><br>Each rank progresses from the one before it. You start your journey as an <strong>OG</strong> ($10), then upgrade to <strong class="bukkit-red">OG Pro</strong> ($50), and finally, you can become a true <strong class="bukkit-dark-red">OG Master</strong> ($10/month subscription).</p>
				</div>
			</div>
			<!-- One card per rank, linking to its store page. -->
			<div class="box ranks">
				<a class="rank outlined" href="https://store.trueog.net/package/1034440" target="_blank">
					<img src="assets/images/logos/og.png" alt="OG rank">
					<p class="price">$10 <span>one time</span></p>
					<ul>
						<li>Use /afk for an unlimited amount of time.</li>
						<li>Prominent white chat prefix.</li>
						<li>Create unions with /union create.</li>
						<li>Invite people to unions with /union invite.</li>
						<li>Access to #donor-chat on Discord.</li>
						<li>6 homes (temporary benefit until the implementation of our in-game home earning plugin).</li>
						<li>More TBA.</li>
					</ul>
					<span class="buy"><i class="fa-solid fa-cart-shopping fa-width-auto" aria-hidden="true"></i> Buy OG</span>
				</a>
				<a class="rank outlined" href="https://store.trueog.net/package/1141035" target="_blank">
					<img src="assets/images/logos/og-pro.png" alt="OG Pro rank">
					<p class="price">$50 <span>one time &middot; best value</span></p>
					<ul>
						<li>All OG Benefits.</li>
						<li>Rent up to 2 shops at the player market.</li>
						<li>Special chat formatting (bold, italics, magic, etc).</li>
						<li>Use color codes in chat, mail, unions, signs, anvils, and book titles.</li>
						<li>Edit written books with /book.</li>
						<li>Edit signs with /editsign.</li>
						<li>Wear hats with /hat.</li>
						<li>Sit anywhere with /sit.</li>
						<li>Access your ender chest anywhere with /echest.</li>
						<li>Use 9 exclusive particle cosmetics with /cosmetics (up to 3 at once).</li>
						<li>More TBA.</li>
					</ul>
					<span class="buy"><i class="fa-solid fa-cart-shopping fa-width-auto" aria-hidden="true"></i> Buy OG Pro</span>
				</a>
				<a class="rank outlined" href="https://store.trueog.net/package/882910" target="_blank">
					<img src="assets/images/logos/og-master.png" alt="OG Master rank">
					<p class="price">$10 <span>per month</span></p>
					<ul>
						<li>All OG and OG Pro Benefits.</li>
						<li>Rent up to 3 shops at the player market.</li>
						<li>World inspection with /co inspect.</li>
						<li>Return to last teleport destination with /back.</li>
						<li>Toggle your death coordinates in chat with /tdc.</li>
						<li>Special mail, sign, and anvil formatting (strike-through, italics, magic, etc).</li>
						<li>More TBA.</li>
					</ul>
					<span class="buy"><i class="fa-solid fa-cart-shopping fa-width-auto" aria-hidden="true"></i> Buy OG Master</span>
				</a>
			</div>
			<div class="box">
				<div class="flex-child outlined">
					<p style="text-align: center">If you would like to contribute to <span class="bukkit-green">True</span><span class="bukkit-red">OG</span> without getting a rank, you may do so using <a href="https://www.paypal.com/donate/?hosted_button_id=99S3FB4HLYK78" target="_blank" class="bukkit-blue"><i class="fa-brands fa-paypal fa-width-auto" aria-hidden="true"></i> PayPal</a>, <a href="https://buy.stripe.com/7sI2bR9Xx4r27Ys000" target="_blank" class="bukkit-blue"><i class="fa-brands fa-stripe-s fa-width-auto" aria-hidden="true"></i> Stripe</a>, or <a href="https://commerce.coinbase.com/checkout/bdce2a7e-0eab-46fb-9dda-e96b0044c7a4" target="_blank" class="bukkit-blue"><i class="fa-brands fa-bitcoin fa-width-auto" aria-hidden="true"></i> Coinbase</a>.<br><br>Premium benefits are non-transferable, and subject to change. Please read the <a href="/terms/" class="bukkit-blue">Terms of Service</a>, <a href="/privacy/" class="bukkit-blue">Privacy Policy</a>, and <a href="/impressum/" class="bukkit-blue">Impressum</a> before making a purchase.</p>
				</div>
			</div>
		</div>

		<!-- Team: a card per staff member, then the application forms (apply.php). -->
		<div class="games" id="team">
			<div class="box">
				<div class="flex-child outlined">
					<h1><i class="fa-solid fa-users bukkit-dark-purple fa-width-auto" aria-hidden="true"></i>&nbsp;The <span class="bukkit-green">True</span><span class="bukkit-red">OG</span> Team:</h1>
					<p style="text-align: center"><br>Our staff team is structured as a unionized, democratic worker cooperative.</p>
				</div>
			</div>
			<!-- Heads come from mc-heads.net by UUID through /head/, which caches them for a day. -->
			<div class="box staff">
<?php foreach (staff() as [$uuid, $name, $role, $color]) { ?>
				<div class="member outlined <?php echo $color; ?>">
					<img src="/head/?u=<?php echo $uuid; ?>" width="128" height="128" alt="<?php echo $name; ?>'s Minecraft head">
					<p class="name"><?php echo $name; ?></p>
					<p class="role"><?php echo $role; ?></p>
				</div>
<?php } ?>
			</div>
			<div class="box">
				<div class="flex-child outlined">
<?php if (!forms_open()) { ?>
					<p class="notice" style="text-align: center">Applications are closed at the moment.</p>
<?php } ?>
					<h2><strong class="bukkit-dark-purple">Apply for Ranks:</strong></h2>
					<div class="apply">
						<a class="apply-button" href="/apply.php?form=tester"><i class="fa-solid fa-triangle-exclamation bukkit-gold fa-width-auto" aria-hidden="true"></i> Apply for Tester</a>
						<a class="apply-button" href="/apply.php?form=youtube"><i class="fa-brands fa-youtube bukkit-red fa-width-auto" aria-hidden="true"></i> Apply for YouTube</a>
						<a class="apply-button" href="/apply.php?form=builder"><i class="fa-solid fa-hammer bukkit-blue fa-width-auto" aria-hidden="true"></i> Apply for Builder</a>
						<a class="apply-button" href="/apply.php?form=moderator"><i class="fa-solid fa-heart bukkit-red fa-width-auto" aria-hidden="true"></i> Apply for Moderator</a>
					</div>
					<h2><strong class="bukkit-dark-purple">Season 1 Migration:</strong></h2>
					<div class="apply">
						<a class="apply-button" href="/apply.php?form=homes"><i class="fa-solid fa-house bukkit-green fa-width-auto" aria-hidden="true"></i> Recover Homes</a>
					</div>
				</div>
			</div>
		</div>

		<!-- World: the Season 1 map download. Direct link while the torrent server is down; magnet for when it is back. -->
		<div class="games" id="world">
			<div class="box">
				<div class="flex-child outlined">
					<h1><i class="fa-solid fa-globe bukkit-dark-aqua fa-width-auto" aria-hidden="true"></i>&nbsp;Season 1 World Download:</h1>
					<p style="text-align: center"><br>The pre-launch OG:SMP Season 1 world is available for personal use only. Our license to use the maps commercially is non-transferable, and the post-launch <span class="bukkit-green">True</span><span class="bukkit-red">OG</span> maps will not be published during the lifetime of the server.<br><br>The archive is about 171 GB. While the torrent server is down, use the direct download; the magnet link will work again once it is back and seeding.</p>
					<div class="apply">
						<a class="apply-button" href="https://true-og.net/smp.tar.gz"><i class="fa-solid fa-download bukkit-green fa-width-auto" aria-hidden="true"></i> Direct Download</a>
						<a class="apply-button" href="magnet:?xt=urn:btih:402df9c1d86bebb5f4b0523038e713dc3d50b0be&amp;dn=smp.tar.gz&amp;tr=udp%3A%2F%2Ftracker.opentrackr.org%3A1337%2Fannounce&amp;tr=udp%3A%2F%2Fopen.stealth.si%3A80%2Fannounce&amp;tr=udp%3A%2F%2Ftracker.torrent.eu.org%3A451%2Fannounce"><i class="fa-solid fa-magnet bukkit-gold fa-width-auto" aria-hidden="true"></i> Magnet Link</a>
					</div>
				</div>
			</div>
		</div>

		<!-- FAQ: questions and answers on the left, server facts on the right. -->
		<div class="games" id="faq">
			<div class="box">
				<div class="flex-child outlined">
					<h1><i class="fa-solid fa-circle-question bukkit-darkgreen fa-width-auto" aria-hidden="true"></i>&nbsp;Frequently Asked Questions:</h1>
				</div>
			</div>
			<div class="box faq">
				<div class="flex-child qa outlined">
					<p class="q">Q: Where did <span class="bukkit-green">True</span><span class="bukkit-red">OG</span> come from?</p>
					<p><strong>A:</strong> <span class="bukkit-green">True</span><span class="bukkit-red">OG</span> is a community SMP based on the OG:SMP Season 1 map by players who disagreed with the map reset and the direction of the server away from the "OG" meta.</p>
					<p class="q">Q: What version of Minecraft is the terrain generated in?</p>
					<p><strong>A:</strong> Terrain from spawn to 40k is 1.16.5. Terrain from 40k to 80k is 1.17.1. Terrain from 80k to 96k is 1.18.2. Terrain from 96k to 112k is 1.19.4. The Nether border is at 14k, and the End border is at 30 million, as always. The world border is expanded for each major update with new chunks.</p>
					<p class="q">Q: How do I navigate the spawn and community marketplace?</p>
					<p><strong>A:</strong> <a href="assets/images/market-map.png" target="_blank">Market Map</a></p>
					<p><strong>A:</strong> <a href="assets/images/market-map-2.png" target="_blank">Combined Spawn/Market Map</a></p>
					<p class="q">Q: How does the economy work?</p>
					<p><strong>A:</strong> Like 2011-2013 era SMP servers, the <span class="bukkit-green">True</span><span class="bukkit-red">OG</span> economy is based on diamonds. Unlike Essentials money, they are a tangible object with a limited supply. As the universal currency, they combat inflation and facilitate fair, understandable transactions. /pay sends another player the specified amount of diamonds. /withdraw takes the specified amount of diamonds out of your bank account and places them into your inventory. /deposit works the other way around. Diamonds stored in your inventory or at the bank will count towards your balance, which can be checked with /balance. The bank is located to the right of the community marketplace entryway.</p>
				</div>
				<div class="flex-child qa outlined">
					<p class="q"><i class="fa-solid fa-network-wired fa-width-auto" aria-hidden="true"></i> IP for Minecraft Java:</p>
					<p><strong>true-og.net</strong></p>
					<p><strong>trueog.net</strong></p>
					<p>Alternate: <strong>play.true-og.net</strong></p>
					<p>Alternate: <strong>play.trueog.net</strong></p>
					<p class="q"><i class="fa-solid fa-server fa-width-auto" aria-hidden="true"></i> Host:</p>
					<p><a href="https://www.hetzner.com/dedicated-rootserver/ax101/" target="_blank">Hetzner AX101</a> in Falkenstein, Germany</p>
					<p class="q"><i class="fa-solid fa-microchip fa-width-auto" aria-hidden="true"></i> Hardware:</p>
					<p>Dedicated AMD Ryzen 9 5950X | 128GB RAM | 2x 1.92TB NVMe SSD | 1Gbps Unmetered Connection</p>
					<p class="q"><i class="fa-solid fa-gear fa-width-auto" aria-hidden="true"></i> Software:</p>
					<p><a href="https://git.trueog.net/trueog/Purpur" target="_blank">Purpur</a> 1.19.4 with custom patches for TrueOG Network</p>
					<p class="q"><i class="fa-solid fa-scale-balanced fa-width-auto" aria-hidden="true"></i> Rules:</p>
					<p><a href="/rules/">true-og.net/rules</a></p>
					<p class="q"><i class="fa-solid fa-code fa-width-auto" aria-hidden="true"></i> Source Code:</p>
					<p><a href="https://git.trueog.net/trueog/true-og" target="_blank">TrueOG on Gitea</a></p>
					<p class="q"><i class="fa-solid fa-bag-shopping fa-width-auto" aria-hidden="true"></i> Donation Store:</p>
					<p><a href="https://store.trueog.net/" target="_blank">store.trueog.net</a></p>
				</div>
			</div>
		</div>

<?php
page_end();
