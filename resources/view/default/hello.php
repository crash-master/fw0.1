<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hello :)</title>
    <?= 
        View::css([
            '*' => ['bootstrap.min.css', 'powered-by.css']
        ]); 
    ?>
    
    <?= 
        View::js([
            '*' => ['jquery-2.2.2.min.js','bootstrap.min.js']
        ]); 
    ?>
</head>
<body>
    <div class="container">
        <h1>Powered by fw4</h1>
    </div>
</body>
</html>