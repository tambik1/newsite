<?php

/** @var string $content */
/** @var string $title */

?>
<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?= $title ?></title>
	<link rel="shortcut icon" href="/public/img/layout_img/favicon.png" type="image/png">
	<link rel="stylesheet" href="/public/css/reset.css">
	<link rel="stylesheet" href="/public/css/style.css">
</head>
<body>
	<div class="content">
		<?= $content ?>
	</div>

</body>
</html>
