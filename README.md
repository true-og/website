# TrueOG Network Website

Source of [true-og.net](https://true-og.net/). Plain PHP, HTML5, and CSS. No JavaScript.

- `index.php` is the front page, `site.php` everything else, `stylesheet.css` the styles. 
- Runs on PHP 8.0+ under nginx, behind Cloudflare's orange proxy.
- The fillable forms show as closed if dependencies are missing.
- Secrets: copy `.secrets.template` to `../.secrets`, `discord_webhook` is for the form notifications;  `applications_file` `../databases/applications.txt` catches them if Discord is down.
- Staff Heads come from mc-heads.net through `/head/?u=<uuid>`, cached for a day.
- Dependencies: [Font Awesome Free](https://fontawesome.com/) 7.3.1 (`Font-Awesome` submodule), [Monocraft](https://github.com/IdreesInc/Monocraft) 4.2 (`assets/fonts/`), and the 2016 [Tutorialzine flexbox template](https://tutorialzine.com/2016/06/freebie-landing-page-template-with-flexbox/) the layout grew from.

Licenses: `index.php` and `stylesheet.css` [Tutorialzine](LICENSE); `site.php` and the stubs [Unlicense](https://unlicense.org/); Monocraft [OFL 1.1](assets/fonts/Monocraft/LICENSE); Font Awesome [its own](Font-Awesome/LICENSE.txt); all other assets [Unlicense](assets/images/LICENSE).
