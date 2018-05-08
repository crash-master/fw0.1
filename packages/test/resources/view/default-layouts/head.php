<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Default template</title>
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
