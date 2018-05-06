<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 not found</title>
    <link rel="shortcut icon" href="/frontend/img/favicon.png">
    <?=View::css([
        '*' => [],
        'default/404' => ['404.css']
    ]); ?>
    
    <?=View::js([
        '*' => []
    ]); ?>
</head>
<body>

<div class="wrapper">
	<p class="main-text">Sorry, 404</p>
	<p class="link">Link <span>&laquo; <?= Request::getUrl() ?> &raquo;</span> not found</p>
	<a href="#" class="go-back" onclick="history.go(-1);return false;">Go back</a>
</div>


</body>
</html>