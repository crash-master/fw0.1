<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hello :)</title>
    <?= 
        View::css([
            '*' => ['hello.css']
        ]); 
    ?>
    
    <?= 
        View::js([
            '*' => []
        ]); 
    ?>
</head>
<body>
    <div class="wrapper">
        <h1 class="hello">Hello, I`m FW</h1>
    </div>
</body>
</html>