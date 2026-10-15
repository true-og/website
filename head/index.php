<?php
require dirname(__DIR__) . '/site.php';
head_image(is_string($_GET['u'] ?? null) ? $_GET['u'] : '');
