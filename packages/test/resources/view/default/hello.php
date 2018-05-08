<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hello :)</title>
    <?= 
        Kernel\View::css([
            '*' => ['hello.css']
        ]); 
    ?>
    
    <?= 
       Kernel\View::js([
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