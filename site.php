<?php
/* All of the site's code: settings, helpers, the page frame, policy documents, staff heads, and the application forms. No JavaScript anywhere. */

/* Settings are key=value lines in ../.secrets, one directory above the web root so the web server can never serve it. */
function site_config(): array {

	static $config = null;

	if ($config === null) {

		$config = ['discord_webhook' => '', 'applications_file' => dirname(__DIR__) . '/databases/applications.txt'];

		foreach (explode("\n", (string) @file_get_contents(dirname(__DIR__) . '/.secrets')) as $line) {

			[$key, $value] = explode('=', $line, 2) + ['', ''];

			if (isset($config[$key])) {

				$config[$key] = trim($value, " \t\r\"'");

			}

		}

	}

	return $config;

}

function e(?string $text): string {

	return htmlspecialchars((string) $text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

}

/* Private directory for throttle slots and caches; '' if it cannot be made safely. */
function temp_dir(): string {

	$dir = sys_get_temp_dir() . '/trueog-website';
	$uid = function_exists('posix_geteuid') ? posix_geteuid() : null;
	@mkdir($dir, 0700);

	return is_dir($dir) && is_writable($dir) && ($uid === null || fileowner($dir) === $uid) ? $dir : '';

}

/* Forms work only with a webhook, mbstring, the wrapper for the webhook's scheme (https needs openssl), and a private directory. */
function forms_open(): bool {

	$webhook = site_config()['discord_webhook'];

	return $webhook !== '' && extension_loaded('mbstring') && ini_get('allow_url_fopen') && in_array(parse_url($webhook, PHP_URL_SCHEME), stream_get_wrappers(), true) && temp_dir() !== '';

}

function in_cidr(string $ip, string $cidr): bool {

	[$net, $bits] = explode('/', $cidr);
	$a = inet_pton($ip);
	$b = inet_pton($net);

	if ($a === false || $b === false || strlen($a) !== strlen($b)) {

		return false;

	}

	$bytes = intdiv((int) $bits, 8);
	$rest = (int) $bits % 8;

	return substr($a, 0, $bytes) === substr($b, 0, $bytes) && ($rest === 0 || ord($a[$bytes]) >> (8 - $rest) === ord($b[$bytes]) >> (8 - $rest));

}

/* The visitor's IP: CF-Connecting-IP only when the connection really comes from Cloudflare (cloudflare.com/ips). */
function client_ip(): string {

	static $cloudflare = ['173.245.48.0/20', '103.21.244.0/22', '103.22.200.0/22', '103.31.4.0/22', '141.101.64.0/18', '108.162.192.0/18', '190.93.240.0/20', '188.114.96.0/20', '197.234.240.0/22', '198.41.128.0/17', '162.158.0.0/15', '104.16.0.0/13', '104.24.0.0/14', '172.64.0.0/13', '131.0.72.0/22', '2400:cb00::/32', '2606:4700::/32', '2803:f800::/32', '2405:b500::/32', '2405:8100::/32', '2a06:98c0::/29', '2c0f:f248::/32'];
	$ip = (string) ($_SERVER['REMOTE_ADDR'] ?? '');
	$edge = (string) ($_SERVER['HTTP_CF_CONNECTING_IP'] ?? '');

	if ($edge !== '' && array_filter($cloudflare, fn (string $cidr): bool => in_cidr($ip, $cidr)) !== []) {

		$ip = $edge;

	}

	return filter_var($ip, FILTER_VALIDATE_IP) ?: '';

}

/* Throttle key: the IPv4 address, or the /64 of an IPv6 address. */
function ip_bucket(string $ip): string {

	$bin = inet_pton($ip);

	return $bin !== false && strlen($bin) === 16 ? bin2hex(substr($bin, 0, 8)) : $ip;

}

/* GET, or POST as JSON when $json is given. Body on a 2xx response, else null (and the status is logged). */
function http_fetch(string $url, ?array $json = null): ?string {

	$options = ['timeout' => 10, 'user_agent' => 'TrueOG-Website (+https://true-og.net/)', 'ignore_errors' => true];

	if ($json !== null) {

		$options += ['method' => 'POST', 'header' => "Content-Type: application/json\r\n", 'content' => json_encode($json, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE)];

	}

	ini_set('default_socket_timeout', '10');
	$body = @file_get_contents($url, false, stream_context_create(['http' => $options]));
	$status = 0;

	foreach ($http_response_header ?? [] as $header) {

		if (str_starts_with($header, 'HTTP/')) {

			$status = (int) substr($header, strcspn($header, ' ') + 1, 3); // The last status line wins after redirects.

		}

	}

	if ($body === false || $status < 200 || $status >= 300) {

		error_log('site.php: ' . parse_url($url, PHP_URL_HOST) . " answered $status: " . substr((string) $body, 0, 200));

		return null;

	}

	return $body;

}

/* Opens the page: <head>, then the first section (class $class, id $id) holding the header. The caller closes the section. */
function page_start(string $title, string $class, string $id = ''): void {

	$nav = [
		['/#smp', 'fa-gamepad bukkit-gold', 'Games'],
		['/#shop', 'fa-bag-shopping bukkit-red', 'Shop'],
		['/#team', 'fa-users bukkit-dark-purple', 'Team'],
		['/#world', 'fa-globe bukkit-dark-aqua', 'World'],
		['/rules/', 'fa-scale-balanced bukkit-blue', 'Rules'],
		['/#faq', 'fa-circle-question bukkit-darkgreen', 'FAQ'],
	];
	$version = fn (string $file): int => (int) @filemtime(__DIR__ . $file);
	header('Cache-Control: no-transform'); // Keeps Cloudflare from injecting scripts.
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" href="/assets/images/favicons/favicon.ico">
		<link rel="icon" href="/assets/images/favicons/favicon-32.png" sizes="32x32">
		<link rel="icon" href="/assets/images/favicons/favicon-96.png" sizes="96x96">
		<link rel="icon" href="/assets/images/favicons/favicon-196.png" sizes="196x196">
		<link rel="apple-touch-icon" href="/assets/images/favicons/favicon-180.png">
		<title><?php echo e($title === '' ? 'TrueOG' : "$title | TrueOG"); ?></title>
		<!-- ?v= is the file's mtime, so a deploy busts the Cloudflare and browser caches. -->
		<link rel="stylesheet" href="/Font-Awesome/css/all.min.css?v=<?php echo $version('/Font-Awesome/css/all.min.css'); ?>">
		<link rel="stylesheet" href="/stylesheet.css?v=<?php echo $version('/stylesheet.css'); ?>">
	</head>
	<body>
		<div class="<?php echo e($class); ?>"<?php echo $id !== '' ? ' id="' . e($id) . '"' : ''; ?>>
			<header>
				<a href="/"><img src="/assets/images/logos/trueog-logo-2026-transparent.png" class="main-logo" alt="Logo"></a>
				<nav class="outlined">
					<ul>
<?php foreach ($nav as [$href, $icon, $label]) { ?>
						<li><a href="<?php echo $href; ?>"><i class="fa-solid <?php echo $icon; ?> fa-width-auto" aria-hidden="true"></i> <strong><?php echo $label; ?></strong></a></li>
<?php } ?>
					</ul>
				</nav>
			</header>
<?php
}

function page_end(): void {
?>
		<footer>
			<ul>
				<li><a href="https://github.com/true-og/website" target="_blank" aria-label="TrueOG website source code on GitHub"><i class="fa-brands fa-github fa-width-auto" aria-hidden="true"></i></a></li>
				<li><a href="https://mastodon.gamedev.place/@trueog" target="_blank" aria-label="TrueOG on Mastodon"><i class="fa-brands fa-mastodon fa-width-auto" aria-hidden="true"></i></a></li>
				<li><a href="https://www.facebook.com/people/True-OG/100076093982787" target="_blank" aria-label="TrueOG on Facebook"><i class="fa-brands fa-facebook fa-width-auto" aria-hidden="true"></i></a></li>
				<li><a href="https://reddit.com/r/trueog" target="_blank" aria-label="TrueOG on Reddit"><i class="fa-brands fa-reddit fa-width-auto" aria-hidden="true"></i></a></li>
			</ul>
			<p><a href="/rules/">Rules</a> &middot; <a href="/terms/">Terms of Service</a> &middot; <a href="/privacy/">Privacy Policy</a> &middot; <a href="/impressum/">Impressum</a></p>
			<p><br>Website based on a template from <a href="https://tutorialzine.com/2016/06/freebie-landing-page-template-with-flexbox/" target="_blank">tutorialzine</a> <br>Uses a permissive<a href="https://tutorialzine.com/license/" target="_blank"> Open Source License</a><br><br></p>
			<p><a href="https://stpeter.im/writings/essays/publicdomain.html" target="_blank">
			<img src="/assets/images/logos/Anti-copyright.svg" style="width: 50px" alt="Anti-Copyright Logo"></a>
			&nbsp;<a href="https://iww.org/" target="_blank">
			<img src="/assets/images/logos/iww.png" style="width: 48px" alt="IWW Union Logo"></a></p>
			<p class="bukkit-blue"><br>Ad astra per aspera</p>
		</footer>
		<a href="#" class="top" aria-label="Back to top"><i class="fa-solid fa-circle-up fa-width-auto" aria-hidden="true"></i></a>
	</body>
</html>
<?php
}

/* Escapes text and turns words starting with http(s):// into anchors; trailing punctuation stays outside the link. */
function linked(string $text): string {

	$words = [];

	foreach (explode(' ', $text) as $word) {

		$link = str_starts_with($word, 'http://') || str_starts_with($word, 'https://') ? rtrim($word, '.,;:!?)') : '';
		$words[] = $link === '' ? e($word) : '<a href="' . e($link) . '" target="_blank" rel="noopener">' . e($link) . '</a>' . e(substr($word, strlen($link)));

	}

	return implode(' ', $words);

}

/* $file's contents, refreshed with $fetch() once older than $ttl seconds; if that fails the old copy stays another $ttl. */
function cached(string $file, int $ttl, callable $fetch): ?string {

	if (is_file($file) && filemtime($file) > time() - $ttl) {

		return file_get_contents($file) ?: null;

	}

	$text = $fetch() ?: null;

	if ($text !== null && ($tmp = tempnam(dirname($file), 'tmp')) !== false) {

		file_put_contents($tmp, $text) !== false && rename($tmp, $file) || @unlink($tmp); // Atomic replace.

	} elseif ($text === null && is_file($file)) {

		@touch($file);
		$text = file_get_contents($file) ?: null;

	}

	return $text;

}

/* rules.txt to HTML: "=-=-Section-=-=" is h2, "Rule N - ..." is h3, "- " is a list item, "(...)" a note, the rest paragraphs. */
function rules_html(string $text): string {

	$html = '';
	$list = false;

	foreach (explode("\n", str_replace(["\r\n", "\r"], "\n", $text)) as $line) {

		$line = rtrim($line);
		$item = str_starts_with($line, '- ');

		if ($list && !$item) {

			$html .= "</ul>\n";
			$list = false;

		}

		if ($line === '' || strcasecmp(rtrim($line, ':'), 'TrueOG Official Rules') === 0) {

			continue;

		}

		$linked = linked($item ? substr($line, 2) : $line);

		if (str_starts_with($line, '=-=')) {

			$html .= '<h2>' . e(rtrim(trim($line, "=- "), ':')) . "</h2>\n";

		} elseif (str_starts_with($line, 'Rule ') && ctype_digit((string) strstr(substr($line, 5), ' ', true)) && str_contains($line, ' - ')) {

			$html .= '<h3>' . e(rtrim($line, ':.')) . "</h3>\n";

		} elseif ($item) {

			$html .= ($list ? '' : "<ul>\n") . "<li>$linked</li>\n";
			$list = true;

		} else {

			$html .= (str_starts_with($line, '(') && str_ends_with($line, ')') ? '<p class="note">' : '<p>') . "$linked</p>\n";

		}

	}

	return $html . ($list ? "</ul>\n" : '');

}

/* A document from the true-og repository's policies/: the sibling directory when deployed as its submodule, else GitHub, cached for an hour. */
function policy_page(string $key): void {

	$docs = [
		'rules' => ['rules.txt', 'Rules', 'fa-scale-balanced bukkit-blue'],
		'terms' => ['terms-of-service.html', 'Terms of Service', 'fa-file-contract bukkit-gold'],
		'privacy' => ['privacy-policy.txt', 'Privacy Policy', 'fa-user-shield bukkit-green'],
		'impressum' => ['impressum.html', 'Impressum', 'fa-building bukkit-light-purple'],
	];
	[$file, $title, $icon] = $docs[$key];
	$local = dirname(__DIR__) . '/policies/' . $file;
	$github = 'https://github.com/true-og/true-og/blob/main/policies/' . $file;
	$raw = 'https://raw.githubusercontent.com/true-og/true-og/main/policies/' . $file;

	if (is_file($local)) {

		$text = file_get_contents($local) ?: null;

	} elseif (($dir = temp_dir()) === '') {

		$text = http_fetch($raw) ?: null;

	} else {

		$text = cached("$dir/policy-$file", 3600, fn (): ?string => http_fetch($raw));

	}

	page_start($title, 'games page', 'policy');
?>
			<div class="box">
				<div class="flex-child outlined">
					<h1><i class="fa-solid <?php echo $icon; ?> fa-width-auto" aria-hidden="true"></i>&nbsp;<span class="bukkit-green">True</span><span class="bukkit-red">OG</span> <?php echo e($title); ?>:</h1>
				</div>
			</div>
			<div class="box">
				<div class="flex-child panel policy outlined">
<?php if ($text === null) { ?>
					<p class="notice">This document could not be loaded right now. Read it <a href="<?php echo e($github); ?>" target="_blank" rel="noopener">on GitHub</a> in the meantime.</p>
<?php } else { ?>
<?php echo $key === 'rules' ? rules_html($text) : $text; ?>
<?php } ?>
					<p class="source">Maintained in the <a href="<?php echo e($github); ?>" target="_blank" rel="noopener">TrueOG repository on GitHub</a>.</p>
				</div>
			</div>
		</div>
<?php
	page_end();

}

/* The team, as [uuid, name, role, color]; by UUID so a card keeps working if the player changes their name. */
function staff(): array {

	return [
		['9c272295-71dd-4aad-b59e-3de12d73b68a', 'NotAlexNoyle', 'Admin', 'bukkit-red'],
		['399e3fb8-c7ec-4351-bf78-86d11687d023', 'Gx0rge', 'Developer', 'bukkit-blue'],
		['812bceca-7190-4879-801e-a2e5fa0421b5', 'SKBotNL', 'Developer', 'bukkit-blue'],
		['aec7ca7a-3ca9-4001-adfc-a81b596d8201', 'OmeniusKamis1', 'Moderator', 'bukkit-gold'],
		['a8f81a4a-d522-4cdf-a299-3c2842c13635', 'Sekalol15', 'Moderator', 'bukkit-gold'],
		['27342539-9648-4fbc-ae33-c33242c8711e', 'sam3192', 'Builder', 'bukkit-green'],
	];

}

/* /head/?u=<uuid>: a staff member's head from mc-heads.net, cached here for a day so visitors never contact a third party. */
function head_image(string $uuid): void {

	$dir = temp_dir();
	$upstream = "https://mc-heads.net/avatar/$uuid/128";

	if (!in_array($uuid, array_column(staff(), 0), true)) {

		http_response_code(404);
		return;

	}

	$png = $dir === '' ? null : cached("$dir/head-$uuid.png", 86400, fn (): ?string => str_starts_with($p = (string) http_fetch($upstream), "\x89PNG") ? $p : null);

	if ($png === null) {

		header("Location: $upstream", true, 302);
		return;

	}

	header('Content-Type: image/png');
	header('Cache-Control: public, max-age=86400');
	header('Content-Length: ' . strlen($png));
	echo $png;

}

/* Field types: text, textarea, number (an age), url, radio, checkbox (several), agree (one box that must be ticked). */
function field(string $name, string $label, string $type = 'text', bool $required = true, array $options = [], string $hint = ''): array {

	return compact('name', 'label', 'type', 'required', 'options', 'hint');

}

/* The application forms by key. 'any' lists fields of which at least one must be filled. */
function forms(): array {

	$identity = [
		field('minecraft', 'Minecraft Username'),
		field('discord', 'Discord Username', 'text', true, [], 'As shown in your Discord settings.'),
	];
	$removable = 'may be removed from the team at any time and for any reason at the discretion of the server owner.';
	$playtime = field('playtime', 'How long have you played on TrueOG?');
	$age = field('age', 'How old are you?', 'number');

	return [

		'tester' => [
			'title' => 'Tester Sign-Up',
			'icon' => '<i class="fa-solid fa-triangle-exclamation bukkit-gold fa-width-auto" aria-hidden="true"></i>',
			'intro' => 'Beta test the TrueOG Minecraft server before it is released to the public! Signing up adds you to the server whitelist.',
			'fields' => [
				...$identity,
				field('season1', 'Did you participate in season 1 of OG:SMP, or are you new to the map?', 'radio', true, ['I participated in Season 1', 'This is my first time joining the map']),
				field('version', 'What version of Minecraft do you main?', 'text', false, [], 'For example 1.8.9 or 1.21.'),
				field('agree', 'Testers who cheat or abuse other players will not be entitled to early access. Your access to TrueOG may be revoked at any time at the discretion of the server owner.', 'agree', true, ['I have read this warning and I understand.']),
			],
		],

		'youtube' => [
			'title' => 'YouTube Sign-Up',
			'icon' => '<i class="fa-brands fa-youtube bukkit-red fa-width-auto" aria-hidden="true"></i>',
			'intro' => 'Get extra benefits on the TrueOG Minecraft server as a reward for promoting it on your channel!',
			'requirements' => 'You must be at least 13 years old to apply. 500 subscriber minimum.',
			'fields' => [
				...$identity,
				$playtime,
				field('video', "Link to a video you've published about the server", 'url'),
				field('continue', 'Do you plan to keep making videos about TrueOG once you have the rank?', 'radio', true, ['Yes', 'No']),
				field('stream', 'Do you plan to stream on TrueOG?', 'radio', true, ['Yes', 'No', 'Maybe']),
			],
		],

		'builder' => [
			'title' => 'Builder Application',
			'icon' => '<i class="fa-solid fa-hammer bukkit-blue fa-width-auto" aria-hidden="true"></i>',
			'intro' => 'Help shape TrueOG by building spawn areas, arenas, and community projects.',
			'requirements' => 'You must be at least 13 years old to apply.',
			'fields' => [
				...$identity,
				$playtime,
				field('portfolio', 'Links to screenshots or videos of your builds', 'textarea', true, [], 'Image hosts, YouTube, PlanetMinecraft, or anywhere else we can see your work.'),
				field('style', 'Which styles and scales of building are you best at?', 'textarea'),
				field('experience', 'Have you built for other servers or build teams? Tell us about it.', 'textarea', false),
				field('timezone', 'What timezone are you in, and when are you usually available?', 'textarea'),
				$age,
				field('agree', "Builders $removable", 'agree', true, ['I understand.']),
			],
		],

		'moderator' => [
			'title' => 'Moderator Application',
			'icon' => '<i class="fa-solid fa-heart bukkit-red fa-width-auto" aria-hidden="true"></i>',
			'intro' => 'Apply below to become a staff member on TrueOG and help the community have the best gameplay experience possible!',
			'requirements' => 'Required: 13 years old. Working microphone. English fluency. Other languages are a bonus (especially German and Arabic).',
			'fields' => [
				...$identity,
				$playtime,
				field('past_staff', 'Have you been staff for any other servers in the past?', 'radio', true, ['Yes', 'No']),
				field('current_staff', 'Are you currently staff on any other Minecraft servers?', 'radio', true, ['Yes', 'No']),
				field('why', 'Why do you want to be a moderator?', 'textarea'),
				field('timezone', 'What timezone are you in, and when do you usually log on?', 'textarea'),
				field('community', 'What experience do you have with managing a community?', 'textarea'),
				field('reputation', 'Does the community have a positive opinion of you? Why or why not?', 'textarea'),
				field('other_roles', 'Are you interested in any other roles in addition to moderating?', 'checkbox', true, ['Building', 'Managing Community Events', 'Streaming/Making videos', 'Software Development', 'Systems Administration', 'None of these']),
				$age,
				field('agree', "Moderators $removable", 'agree', true, ['I understand.']),
			],
		],

		'homes' => [
			'title' => 'Home Recovery',
			'icon' => '<i class="fa-solid fa-house bukkit-green fa-width-auto" aria-hidden="true"></i>',
			'intro' => 'Essentials playerdata was unfortunately not saved from OG:SMP Season 1. TrueOG staff can still attempt manual re-assignment of your homes, assuming you remember where they are located.',
			'any' => ['bed', 'home1', 'home2', 'home3', 'home4'],
			'fields' => [
				$identity[0],
				field('discord', 'Discord Username', 'text', false),
				field('bed', 'Bed Coordinates (X, Y, Z)', 'text', false),
				field('home1', 'Home 1 Coordinates (X, Y, Z)', 'text', false),
				field('home2', 'Home 2 Coordinates (X, Y, Z)', 'text', false),
				field('home3', 'Home 3 Coordinates (X, Y, Z)', 'text', false),
				field('home4', 'Home 4 Coordinates (X, Y, Z)', 'text', false),
				field('agree', 'We will do our best to verify your ownership of past homes, but if the locations provided cannot be tied to your username or group, you will not be re-assigned to them.', 'agree', true, ['I understand.']),
			],
		],

	];

}

/* Returns [$values, $errors], both keyed by field name. */
function validate(array $fields, array $post): array {

	$values = [];
	$errors = [];
	$controls = implode('', array_map('chr', range(0, 31))) . "\x7F"; // ASCII control characters.

	foreach ($fields as $f) {

		$name = $f['name'];
		$raw = $post[$name] ?? '';
		$multi = $f['type'] === 'checkbox';
		$value = $multi ? array_values(array_unique(array_intersect(array_filter(is_array($raw) ? $raw : [], 'is_string'), $f['options']))) : (is_string($raw) ? trim(str_replace("\r\n", "\n", $raw)) : '');
		$values[$name] = $value;

		if ($value === '' || $value === []) {

			if ($f['required']) {

				$errors[$name] = $f['type'] === 'agree' ? 'Please tick the box to continue.' : 'This question is required.';

			}

			continue;

		}

		$limit = $f['type'] === 'textarea' ? 800 : 200;
		$error = match (true) {
			$multi => null,
			!mb_check_encoding($value, 'UTF-8') => 'Please use plain text.',
			strpbrk($value, $f['type'] === 'textarea' ? str_replace(["\n", "\t"], '', $controls) : $controls) !== false => 'Please remove control characters' . ($f['type'] === 'textarea' ? '.' : ' and line breaks.'),
			in_array($f['type'], ['radio', 'agree'], true) && !in_array($value, $f['options'], true) => 'Please pick one of the options.',
			$f['type'] === 'number' && (!ctype_digit($value) || (int) $value < 13 || (int) $value > 120) => 'Please enter your age as a whole number. You must be 13 or older.',
			$f['type'] === 'url' && (!in_array(strtolower((string) parse_url($value, PHP_URL_SCHEME)), ['http', 'https'], true) || !parse_url($value, PHP_URL_HOST) || str_contains($value, ' ')) => 'Please enter a full link, starting with http:// or https://.',
			$name === 'minecraft' && (strlen($value) < 3 || strlen($value) > 16 || !ctype_alnum(strtr($value, '_', 'a'))) => 'A Minecraft username is 3 to 16 letters, numbers, or underscores.',
			mb_strlen($value) > $limit => "Please keep this to $limit characters or fewer.",
			default => null,
		};

		if ($error !== null) {

			$errors[$name] = $error;

		}

	}

	return [$values, $errors];

}

/* [question, answer] rows in form order, ending with when and where it was submitted from. */
function answers(array $fields, array $values): array {

	$rows = [];

	foreach ($fields as $f) {

		$value = $values[$f['name']];
		$value = is_array($value) ? implode(', ', $value) : $value;
		$rows[] = [$f['label'], $value === '' ? '(no answer)' : $value];

	}

	$rows[] = ['Submitted', gmdate('Y-m-d H:i') . ' UTC from ' . client_ip()];

	return $rows;

}

/* One embed per application (the field limits keep it inside Discord's caps), plus a reminder if the fallback file has content. */
function send_discord(string $title, array $rows): bool {

	['discord_webhook' => $webhook, 'applications_file' => $file] = site_config();
	$fields = array_map(fn (array $row): array => ['name' => mb_strimwidth($row[0], 0, 256, '...'), 'value' => $row[1]], $rows);
	$sent = http_fetch($webhook, ['embeds' => [['title' => $title, 'color' => 0xAA00AA, 'fields' => $fields]], 'allowed_mentions' => ['parse' => []]]) !== null;
	$pending = (int) @filesize($file);

	if ($sent && $pending > 0) {

		http_fetch($webhook, ['content' => "Applications were saved to $file while Discord was down ($pending bytes). Read it on the server, then delete it.", 'allowed_mentions' => ['parse' => []]]);

	}

	return $sent;

}

/* Fallback when Discord is down: appends the application to applications_file, up to 5 MB. */
function save_application(string $title, array $rows): bool {

	$file = site_config()['applications_file'];
	$text = "=== $title ===\n";

	foreach ($rows as [$question, $answer]) {

		$text .= "$question: " . str_replace("\n", "\n    ", $answer) . "\n";

	}

	$saved = (int) @filesize($file) < 5_000_000 && @file_put_contents($file, "$text\n", FILE_APPEND | LOCK_EX) !== false;
	error_log('site.php: Discord webhook failed; application ' . ($saved ? "saved to $file" : "LOST, $file is full or not writable"));

	return $saved;

}

/* Takes the sender's one-a-minute slot under a lock, so parallel posts cannot share it. */
function reserve(string $slot): bool {

	$handle = @fopen($slot, 'c+');

	if ($handle === false || !flock($handle, LOCK_EX)) {

		return false;

	}

	$stat = fstat($handle);
	$free = $stat['size'] === 0 || $stat['mtime'] <= time() - 60;

	if ($free) {

		ftruncate($handle, 0);
		fwrite($handle, '1');

	}

	flock($handle, LOCK_UN);
	fclose($handle);

	return $free;

}

/* /apply.php lists the forms; ?form=<key> shows one and posts it to Discord, or the fallback file if Discord is down. */
function apply_page(): void {

	$https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https';
	session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax', 'secure' => $https, 'path' => '/']);
	session_start();
	$_SESSION['csrf'] ??= bin2hex(random_bytes(16));

	$forms = forms();
	$key = isset($_GET['form']) && is_string($_GET['form']) ? $_GET['form'] : '';
	$form = $forms[$key] ?? null;
	$open = forms_open();
	$values = [];
	$errors = [];
	$state = 'form';

	if ($form && $open && $_SERVER['REQUEST_METHOD'] === 'POST') {

		[$values, $errors] = validate($form['fields'], $_POST);
		$dir = temp_dir();
		$slot = "$dir/apply-" . sha1($key . ip_bucket(client_ip()));
		$started = $_SESSION['started'][$key] ?? null;

		if (($_POST['website'] ?? '') !== '') {

			error_log('site.php: honeypot hit from ' . client_ip()); // A bot: pretend it worked.
			header("Location: /apply.php?form=$key&sent=1", true, 303);
			exit;

		} elseif (!is_string($_POST['csrf'] ?? null) || !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {

			$errors['form'] = 'Your session expired. Please check your answers and send again.';

		} elseif ($started === null || time() - $started < 3) {

			$errors['form'] = 'That was quick. Please check your answers and send again.';

		} elseif (isset($form['any']) && array_filter(array_intersect_key($values, array_flip($form['any']))) === []) {

			$errors['form'] = 'Please give at least one set of coordinates.';

		} elseif (count(array_filter(glob("$dir/apply-*") ?: [], fn (string $file): bool => filesize($file) > 0 && filemtime($file) > time() - 600)) >= 30) {

			$errors['form'] = 'The forms are busy right now. Please try again in a few minutes.';

		} elseif ($errors === [] && !reserve($slot)) {

			$errors['form'] = 'Please wait a minute before sending another application.';

		}

		if ($errors === []) {

			$title = "New {$form['title']} from {$values['minecraft']}";
			$rows = answers($form['fields'], $values);

			if (send_discord($title, $rows) || save_application($title, $rows)) {

				$_SESSION['sent'] = [$values['minecraft'], $values['discord'] !== ''];
				$_SESSION['csrf'] = bin2hex(random_bytes(16));
				unset($_SESSION['started'][$key]);
				header("Location: /apply.php?form=$key&sent=1", true, 303);
				exit;

			}

			$state = 'failed';

		}

	} elseif ($form) {

		$_SESSION['started'][$key] = time();
		$state = isset($_GET['sent']) ? 'sent' : 'form';

	}

	page_start($form ? $form['title'] : 'Apply', 'games page', 'apply');
?>
			<div class="box">
				<div class="flex-child outlined">
					<h1><?php echo $form ? $form['icon'] : '<i class="fa-solid fa-file-signature bukkit-dark-purple fa-width-auto" aria-hidden="true"></i>'; ?>&nbsp;<?php echo $form ? '' : 'Apply to '; ?><span class="bukkit-green">True</span><span class="bukkit-red">OG</span><?php echo $form ? ' ' . e($form['title']) : ''; ?>:</h1>
				</div>
			</div>
			<div class="box">
				<div class="flex-child panel outlined">
<?php if (!$form) { ?>
					<p>Pick a form. Applications go straight to the staff team, who will reach out on Discord.</p>
<?php if (!$open) { ?>
					<p class="notice">Applications are closed at the moment. Ask on <a href="https://discord.gg/ma9pMYpBU6">Discord</a> if you have questions.</p>
<?php } ?>
					<div class="apply">
<?php foreach ($forms as $k => $f) { ?>
						<a class="apply-button" href="/apply.php?form=<?php echo $k; ?>"><?php echo $f['icon']; ?> <?php echo e($f['title']); ?></a>
<?php } ?>
					</div>
<?php } elseif ($state === 'sent') { [$who, $discord] = $_SESSION['sent'] ?? ['friend', true]; ?>
					<p class="bukkit-green">Thanks, <?php echo e($who); ?>! Your <?php echo e($form['title']); ?> has been sent to the staff team.</p>
					<p><?php echo $discord ? 'We will follow up on Discord, so make sure you are in the' : 'We will follow up in game, or on Discord if you join the'; ?> <a href="https://discord.gg/ma9pMYpBU6">TrueOG Discord</a>.</p>
<?php } else { ?>
					<p><?php echo e($form['intro']); ?></p>
<?php if (isset($form['requirements'])) { ?>
					<p class="bukkit-gold"><?php echo e($form['requirements']); ?></p>
<?php } ?>
<?php if (!$open) { ?>
					<p class="notice">Applications are closed at the moment. Ask on <a href="https://discord.gg/ma9pMYpBU6">Discord</a> if you have questions.</p>
<?php } elseif ($state === 'failed') { ?>
					<p class="notice">Your application could not be sent. Please try again later, or reach out on <a href="https://discord.gg/ma9pMYpBU6">Discord</a>.</p>
<?php } elseif (isset($errors['form'])) { ?>
					<p class="notice"><?php echo e($errors['form']); ?></p>
<?php } elseif ($errors !== []) { ?>
					<p class="notice">Please fix the highlighted answers below.</p>
<?php } ?>
					<form method="post" action="/apply.php?form=<?php echo e($key); ?>">
						<fieldset<?php echo $open ? '' : ' disabled'; ?>>
						<input type="hidden" name="csrf" value="<?php echo e($_SESSION['csrf']); ?>">
						<div class="honeypot" aria-hidden="true"><label>Leave this field empty <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
<?php foreach ($form['fields'] as $f) {
	$name = $f['name'];
	$value = $values[$name] ?? ($f['type'] === 'checkbox' ? [] : '');
	$label = e($f['label']) . ($f['required'] ? ' <span class="required" title="Required">*</span>' : '');
	$hint = $f['hint'] !== '' ? '<p class="hint" id="h-' . $name . '">' . e($f['hint']) . '</p>' : '';
	$describe = trim(($f['hint'] !== '' ? "h-$name " : '') . (isset($errors[$name]) ? "e-$name" : ''));
	$aria = $describe !== '' ? ' aria-describedby="' . $describe . '"' : '';
	$required = ($f['required'] && $f['type'] !== 'checkbox' ? ' required' : '') . (isset($errors[$name]) && $f['options'] === [] ? ' aria-invalid="true"' : '');
?>
						<div class="field<?php echo isset($errors[$name]) ? ' invalid' : ''; ?>">
<?php if ($f['options'] !== []) { ?>
							<fieldset<?php echo $aria; ?>>
								<legend class="question"><?php echo $label; ?></legend><?php echo $hint; ?>
<?php foreach ($f['options'] as $option) { ?>
								<label class="choice"><input type="<?php echo $f['type'] === 'radio' ? 'radio' : 'checkbox'; ?>" name="<?php echo $name . ($f['type'] === 'checkbox' ? '[]' : ''); ?>" value="<?php echo e($option); ?>"<?php echo ($f['type'] === 'checkbox' ? in_array($option, $value, true) : $value === $option) ? ' checked' : ''; ?><?php echo $required; ?>> <?php echo e($option); ?></label>
<?php } ?>
							</fieldset>
<?php } elseif ($f['type'] === 'textarea') { ?>
							<label class="question" for="f-<?php echo $name; ?>"><?php echo $label; ?></label><?php echo $hint; ?>
							<textarea id="f-<?php echo $name; ?>" name="<?php echo $name; ?>" rows="5" maxlength="800"<?php echo $required . $aria; ?>><?php echo e($value); ?></textarea>
<?php } elseif ($f['type'] === 'number') { ?>
							<label class="question" for="f-<?php echo $name; ?>"><?php echo $label; ?></label><?php echo $hint; ?>
							<input type="number" id="f-<?php echo $name; ?>" name="<?php echo $name; ?>" value="<?php echo e($value); ?>" min="13" max="120"<?php echo $required . $aria; ?>>
<?php } else { ?>
							<label class="question" for="f-<?php echo $name; ?>"><?php echo $label; ?></label><?php echo $hint; ?>
							<input type="<?php echo $f['type'] === 'url' ? 'url' : 'text'; ?>" id="f-<?php echo $name; ?>" name="<?php echo $name; ?>" value="<?php echo e($value); ?>"<?php echo $name === 'minecraft' ? ' maxlength="16"' : ' maxlength="200"'; ?><?php echo $required . $aria; ?>>
<?php } ?>
<?php if (isset($errors[$name])) { ?>
							<p class="error" id="e-<?php echo $name; ?>"><?php echo e($errors[$name]); ?></p>
<?php } ?>
						</div>
<?php } ?>
<?php if ($open) { ?>
						<button type="submit" class="submit"><i class="fa-solid fa-paper-plane fa-width-auto" aria-hidden="true"></i> Send Application</button>
						<p class="hint">Your answers, IP address, and the time are sent to the staff Discord. See the <a href="/privacy/">Privacy Policy</a>.</p>
<?php } ?>
						</fieldset>
					</form>
<?php } ?>
				</div>
			</div>
		</div>
<?php
	page_end();

}
